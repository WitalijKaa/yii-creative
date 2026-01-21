<?php

use yii\db\Migration;

class m260120_210502_create_product_item_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('product_item', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->unsigned()->notNull(),
            'amount_reserved' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'ix_pi_product',
            'product_item',
            'product_id',
            'product',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'ix_pi_product_amount',
            'product_item',
            ['product_id', 'amount']
        );
    }

    public function safeDown()
    {
        $this->dropIndex('ix_pi_product_amount', 'product_item');
        $this->dropForeignKey('ix_pi_product', 'product_item');
        $this->dropTable('product_item');
    }
}

