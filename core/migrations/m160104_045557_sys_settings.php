<?php

use yii\db\Schema;
use yii\db\Migration;

class m160104_045557_sys_settings extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sys_settings}}', [
            'sname' => $this->string(128)->notNull(),
            'svalue' => $this->string(128),
            'svalues' => $this->text(),
            'sintro'      => $this->string(128),
            'stype'     => $this->string(128),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'smodule' => $this->string(128),
            'PRIMARY KEY (sname)',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%sys_settings}}');
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
