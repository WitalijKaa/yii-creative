<?php

namespace app\models\Shop\Cart;

use app\models\Shop\Product\ProductItem;
use yii\db\ActiveRecord;

class CartItem extends ActiveRecord
{
    public const string TABLE_NAME = 'cart_item';
    public static function tableName(): string { return self::TABLE_NAME; }

    public function rules(): array
    {
        return [
            [['cart_id', 'product_item_id', 'amount'], 'integer'],
            [['price'], 'number'],
        ];
    }

    public function removeFromCart(int $amount = 1): void
    {
        $this->amount -= $amount;

        if ($this->amount > 0) {
            $this->save(false);
        } else {
            $this->delete();
        }
    }

    public static function itemsToAddToCart(int $cartId, int $productItemId): self
    {
        $model = static::find()
            ->where(['cart_id' => $cartId, 'product_item_id' => $productItemId])
            ->one();

        if ($model === null) {
            $model = new static();
            $model->cart_id = $cartId;
            $model->product_item_id = $productItemId;
            $model->amount = 0;
        }

        return $model;
    }

    public function getCart()
    {
        return $this->hasOne(Cart::class, ['id' => 'cart_id']);
    }

    public function getProductItem()
    {
        return $this->hasOne(ProductItem::class, ['id' => 'product_item_id']);
    }
}
