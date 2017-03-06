<?php

use yii\db\Migration;

class m170306_163828_sms extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%sms_send}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'mobile' => $this->string(20),//任务名
            'msg' => $this->text(),//描述
            'time' => $this->dateTime(),//发送时间
            'status' => $this->smallInteger()->defaultValue(1),//状态1正常 0成功 2失败 -1删除
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%sms_receive}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'mobile' => $this->string(20),//任务名
            'msg' => $this->text(),//描述
            'status' => $this->smallInteger()->defaultValue(1),//状态1正常   -1删除
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);
       
    }

    public function down()
    {
        $this->dropTable('{{%sms_send}}');
        $this->dropTable('{{%sms_receive}}');
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
