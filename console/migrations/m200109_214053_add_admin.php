<?php

use yii\db\Migration;

/**
 * Class m200109_214053_add_admin
 */
class m200109_214053_add_admin extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'username' => 'webmaster',
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(32),
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('webmaster'),
            'password_reset_token' => Yii::$app->getSecurity()->generateRandomString(128),
            'verification_token' => Yii::$app->getSecurity()->generateRandomString(128),
            'email' => 'webmaster@example.com',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => 'webmaster']);
    }
}
