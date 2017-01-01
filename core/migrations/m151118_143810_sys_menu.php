<?php

use yii\db\Schema;
use yii\db\Migration;

class m151118_143810_sys_menu extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sys_menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
            'auth_name' => $this->string(128),
            'pid' => $this->integer(),
            'icon'      => $this->string(32),
            'sort'     => $this->smallInteger()->notNull()->defaultValue(1),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'description' => $this->text(),
            'panel' => $this->string(32),//菜单所属的面板，保留字段，将来可能用的上
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%sys_menu}}');
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


























