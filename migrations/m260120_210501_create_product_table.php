<?php

use yii\db\Migration;

class m260120_210501_create_product_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'name' => $this->string(500)->notNull(),
            'price' => $this->decimal(8, 2)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('product');
    }
}

