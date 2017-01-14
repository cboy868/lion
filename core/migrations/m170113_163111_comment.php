<?php

use yii\db\Migration;

class m170113_163111_comment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'from' => $this->integer(),
            'to' => $this->integer(),
            'res_name' => $this->string(200),
            'res_id'   => $this->integer(),
            'pid'       => $this->integer()->defaultValue(0),
            'content'   => $this->text(),
            'privacy'   => $this->smallInteger(1)->defaultValue(0),//悄悄话之类的东西, 0为公开
            'status'    => $this->smallInteger(1)->defaultValue(0), //状态，删除、待审、发布
            'created_at'=> $this->integer()->notNull()

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%comment}}');
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
