<?php

use yii\db\Migration;

class m170323_032127_settlement_tomb extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%settlement_tomb}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'num' => $this->integer(),
            'amount' => $this->decimal(20,2),
            'time'  => $this->integer(),//年2012,季20121,月201201,周2012001
            'intro' => $this->text(),//统计分析
            'created_at'=> $this->integer()->notNull(),
        ], $tableOptions);
       
    }

    public function down()
    {
        $this->dropTable('{{%settlement_tomb}}');
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
