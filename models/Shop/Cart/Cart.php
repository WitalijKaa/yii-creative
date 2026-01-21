<?php

namespace app\models\Shop\Cart;

use app\models\Shop\Product\Product;
use app\models\Shop\Product\ProductItem;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public const string TABLE_NAME = 'cart';
    public static function tableName(): string { return self::TABLE_NAME; }

    public function rules(): array
    {
        return [
            [['client_uuid'], 'string', 'max' => 36],
            [['client_uuid'], 'required'],
            [['status'], 'integer'],
            [['paid_at'], 'safe'],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function addToCartByProductID(int $productId, int $amount = 1): void // todo move to ShoppingInterface
    {
        if ($this->isNewRecord) {
            $this->save(false);
        }

        if (!$items = ProductItem::find()
            ->where(['product_id' => $productId])
            ->andWhere(['>=', 'amount', $amount])
            ->one())
        {
            return;
        }

        $cartItems = CartItem::itemsToAddToCart($this->id, $items->id);

        if ($items->amount >= $cartItems->amount + $amount) {
            $cartItems->amount += $amount;
            $cartItems->save(false);
        }
    }

    public function reserveToCartByProductItemID(CartItem $cartItems): void // todo move to ShoppingInterface
    {
        $productId = (int)ProductItem::find()->select(['product_id'])->where(['id' => $cartItems->product_item_id])->scalar();
        $price = (float)Product::find()->select(['price'])->where(['id' => $productId])->scalar();

        $transaction = Yii::$app->db->beginTransaction(\yii\db\Transaction::SERIALIZABLE);
        try {
            $items = ProductItem::find()->where(['id' => $cartItems->product_item_id])->one();

            $actualAmount = $cartItems->amount > $items->amount ? $items->amount : $cartItems->amount;

            if ($actualAmount < 1) {
                $cartItems->delete();
                $transaction->rollBack();
                return;
            }

            $items->amount -= $actualAmount;
            $items->amount_reserved += $actualAmount;

            $cartItems->amount = $actualAmount;
            $cartItems->price = $price;

            if (!$items->save(false) || !$cartItems->save(false)) {
                $transaction->rollBack();
                return;
            }

            $transaction->commit();
        } catch (\Throwable) {
            $transaction->rollBack();
        }
    }

    public function reserveCartItems(): void // todo move to ShoppingInterface
    {
        if ($this->status != CartStatusEnum::potential->value) {
            return;
        }

        foreach ($this->items as $cartItems) {
            try {
                $this->reserveToCartByProductItemID($cartItems);
            } catch (\Throwable $e) {
                // inform client about error with some items
            }
        }

        $this->status = CartStatusEnum::reserved->value;
        $this->save(false);
    }

    public function payCartItems(): void // todo move to ShoppingInterface
    {
        if ($this->status != CartStatusEnum::reserved->value) {
            throw new \RuntimeException('Pay critical error');
        }
        $transaction = Yii::$app->db->beginTransaction(\yii\db\Transaction::SERIALIZABLE);

        try {
            foreach ($this->items as $cartItems) {
                $productItems = ProductItem::find()->where(['id' => $cartItems->product_item_id])->one();

                $amountReserved = $productItems->amount_reserved - $cartItems->amount;
                if ($amountReserved < 0) {
                    // alert critical error
                    $amountReserved = 0;
                }

                if (1 != ProductItem::updateAll(
                    ['amount_reserved' => $amountReserved],
                    [
                        'id' => $cartItems->product_item_id,
                        'amount_reserved' => $productItems->amount_reserved,
                    ]
                )) {
                    $transaction->rollBack();
                    return;
                }
            }

            $this->status = CartStatusEnum::paid->value;
            $this->paid_at = date('Y-m-d H:i:s');
            
            if (!$this->save(false)) {
                $transaction->rollBack();
                return;
            }

            $transaction->commit();
        } catch (\Throwable $e) {
            $transaction->rollBack();
        }
    }

    public function productsItemsIDs(): array
    {
        if ($this->isNewRecord) {
            return [];
        }

        return CartItem::find()
            ->select(['product_item_id'])
            ->where(['cart_id' => $this->id])
            ->column();
    }

    public function setInCartAmount(array $productItems): void
    {
        foreach ($this->items as $cartItem) {
            $productItemOfCart = current(array_filter($productItems, fn(ProductItem $productItem) => $productItem->id == $cartItem->product_item_id));

            if ($productItemOfCart) {
                $productItemOfCart->inCartItem = $cartItem;
            }
        }
    }

    public function getMayReserve(): bool
    {
        return count($this->items) > 0 && (int) $this->status === CartStatusEnum::potential->value;
    }

    public function getMayPay(): bool
    {
        return (int) $this->status === CartStatusEnum::reserved->value;
    }

    public function getPrice(): float
    {
        $sum = 0.0;
        foreach ($this->items as $cartItem) {
            $sum += $cartItem->amount * (float)$cartItem->productItem?->product?->price;
        }
        return $sum;
    }

    public function getPriceReserved(): float
    {
        $sum = 0.0;
        foreach ($this->items as $cartItem) {
            $sum += $cartItem->amount * (float)$cartItem->price;
        }
        return $sum;
    }

    public function getItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }
}
