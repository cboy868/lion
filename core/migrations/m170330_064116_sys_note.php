<?php

use yii\db\Migration;

class m170330_064116_sys_note extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%sys_note}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'res_name' => $this->string(255)->notNull(),
            'res_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'content' => $this->text(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%sys_note_log}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'note_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'content' => $this->text(),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);
       
    }

    public function down()
    {
        $this->dropTable('{{%sys_note}}');
        $this->dropTable('{{%sys_note_log}}');
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
