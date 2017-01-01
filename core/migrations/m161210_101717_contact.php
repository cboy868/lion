<?php

use yii\db\Migration;

class m161210_101717_contact extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull(),
            'note' => $this->text(),
            'ip'   => $this->string(100),
            'intro'=> $this->text(),//此字段可以放一些有用的信息，比如页面的网址，主要产品等
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%contact}}');
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
