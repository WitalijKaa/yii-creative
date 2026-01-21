<?php

namespace app\models\Shop\Product;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public const string TABLE_NAME = 'product';
    public static function tableName(): string { return self::TABLE_NAME; }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 500],
            [['price'], 'number'],
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
}
