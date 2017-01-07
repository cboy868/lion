<?php

use yii\db\Migration;

class m170106_085056_favor extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%favor}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'res_name' => $this->string(200),
            'res_id'   => $this->integer(),
            'title'     => $this->string(200),
            'res_url'   => $this->string(255),
            'created_at' => $this->integer(1)->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%favor}}');
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
