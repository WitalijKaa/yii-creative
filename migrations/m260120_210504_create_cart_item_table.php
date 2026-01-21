<?php

use yii\db\Migration;

class m260120_210504_create_cart_item_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('cart_item', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer()->notNull(),
            'product_item_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->unsigned()->notNull(),
            'price' => $this->decimal(8, 2),
        ]);

        $this->addForeignKey(
            'ix_ci_cart',
            'cart_item',
            'cart_id',
            'cart',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'ix_ci_product_item',
            'cart_item',
            'product_item_id',
            'product_item',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('ix_ci_product_item', 'cart_item');
        $this->dropForeignKey('ix_ci_cart', 'cart_item');
        $this->dropTable('cart_item');
    }
}

