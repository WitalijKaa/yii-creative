<?php

use app\models\Shop\Cart\Cart;
use yii\db\Migration;

class m260120_210503_create_cart_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(Cart::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'client_uuid' => $this->string(36)->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
            'paid_at' => $this->dateTime(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(Cart::TABLE_NAME);
    }
}

