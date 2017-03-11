<?php

use yii\db\Migration;

class m170311_042531_nav extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%cms_nav}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'url' => $this->string(255),
            'title' => $this->string(255),
            'keywords' => $this->string(255),
            'description' => $this->text(),
            'show' => $this->smallInteger()->defaultValue(1),
            'sort' => $this->smallInteger()->defaultValue(0),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);
       
    }

    public function down()
    {
        $this->dropTable('{{%sms_nav}}');
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
