<?php

namespace app\models\Shop\Product;

use app\models\Shop\Cart\CartItem;
use yii\db\ActiveRecord;

/**
 * @property CartItem $inCartItem
 */
class ProductItem extends ActiveRecord
{
    public const string TABLE_NAME = 'product_item';
    public static function tableName(): string { return self::TABLE_NAME; }

    private ?CartItem $inCartItem = null;

    public function rules(): array
    {
        return [
            [['product_id', 'amount', 'amount_reserved'], 'integer'],
        ];
    }

    public static function findAvailableAll(array $forcedIDs = [])
    {
        $query = static::find()
            ->with(['product'])
            ->where(['>', 'amount', 0]);
        if ($forcedIDs) {
            $query->orWhere(['id' => $forcedIDs]);
        }
        return $query->all();
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getInCartItem(): ?CartItem
    {
        return $this->inCartItem;
    }

    public function setInCartItem(?CartItem $cartItem): void
    {
        $this->inCartItem = $cartItem;
    }
}
