<?php

use app\models\Shop\Product\Product;
use app\models\Shop\Product\ProductItem;
use yii\db\Migration;

class m260120_210502_create_product_item_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(ProductItem::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->unsigned()->notNull(),
            'amount_reserved' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);

        $this->addForeignKey(
            'ix_pi_product',
            ProductItem::TABLE_NAME,
            'product_id',
            Product::TABLE_NAME,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'ix_pi_product_amount',
            ProductItem::TABLE_NAME,
            ['product_id', 'amount']
        );
    }

    public function safeDown()
    {
        $this->dropIndex('ix_pi_product_amount', ProductItem::TABLE_NAME);
        $this->dropForeignKey('ix_pi_product', ProductItem::TABLE_NAME);
        $this->dropTable(ProductItem::TABLE_NAME);
    }
}

