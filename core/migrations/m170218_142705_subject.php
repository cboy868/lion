<?php

use yii\db\Migration;

class m170218_142705_subject extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%subject}}', [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer(),
            'title' => $this->string(200),
            'link' => $this->string(200),
            'cover' => $this->string(200),
            'path' => $this->string(200),
            'status' => $this->smallInteger()->defaultValue(1),
            'updated_at'=> $this->integer()->notNull(),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%subject}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
