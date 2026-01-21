<?php

use app\models\Shop\Cart\Cart;
use app\models\Shop\Cart\CartItem;
use app\models\Shop\Product\ProductItem;
use yii\db\Migration;

class m260120_210504_create_cart_item_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(CartItem::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer()->notNull(),
            'product_item_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->unsigned()->notNull(),
            'price' => $this->decimal(8, 2),
        ]);

        $this->addForeignKey(
            'ix_ci_cart',
            CartItem::TABLE_NAME,
            'cart_id',
            Cart::TABLE_NAME,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'ix_ci_product_item',
            CartItem::TABLE_NAME,
            'product_item_id',
            ProductItem::TABLE_NAME,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('ix_ci_product_item', CartItem::TABLE_NAME);
        $this->dropForeignKey('ix_ci_cart', CartItem::TABLE_NAME);
        $this->dropTable(CartItem::TABLE_NAME);
    }
}

