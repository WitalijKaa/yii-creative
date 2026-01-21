<?php

use app\models\User;
use yii\db\Migration;

class m260101_010203_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(User::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255),
            'email' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-user-username', User::TABLE_NAME, 'username', true);

        $now = time();
        $this->insert(User::TABLE_NAME, [
            'username' => 'devops',
            'email' => 'devops@example.com',
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'password_hash' => \Yii::$app->security->generatePasswordHash('devops'),
            'status' => 10,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(User::TABLE_NAME);
    }
}

