<?php

use yii\db\Migration;

/**
 * Class m200110_201220_apple_createtable
 */
class m200110_201220_apple_createtable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string(8)->null(),
            'eaten' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'down_at' =>$this->integer()->null(),
            'created_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-status', '{{%apple}}', ['status']);
        $this->createIndex('idx-created_by', '{{%apple}}', ['created_by']);

        $this->addForeignKey(
            'fk-apple-user',
            '{{%apple}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-apple-user', '{{%apple}}');
        $this->dropTable('{{%apple}}');
    }
}
