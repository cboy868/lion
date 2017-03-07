<?php

use yii\db\Migration;

class m170303_225817_task extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%task_info}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'name' => $this->string(200),//任务名
            'intro' => $this->text(),//描述
            'msg' => $this->text(),//消息内容,可带变量
            'msg_time' => $this->text(),//提醒时间,应该可以多选才对
            'trigger' => $this->integer()->defaultValue(1),//什么时候触发  比如支付后，比如加入购物车后，比如确认后
            'msg_type' => $this->string(200),//消息类型 1短信 2邮箱 3微信  不知道微信是否可以实现
            'status' => $this->smallInteger()->defaultValue(1),//状态
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);


         $this->createTable('{{%task_goods}}', [//任务商品关联关联
            'id' => $this->primaryKey(),
            'info_id' => $this->integer(),
            'res_name' => $this->string(),//category / goods
            'res_id'  => $this->integer(),//category_id / goods_id
        ], $tableOptions);

        $this->createTable('{{%task_user}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'info_id' => $this->integer(),//任务信息id
            'user_id' => $this->integer(),//关联人
            'default' => $this->smallInteger(1),//是否默认的，如果是，则任务发给此人
        ], $tableOptions);

       

        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'cate_id' => $this->integer(),
            'res_name' => $this->string(200),
            'res_id' => $this->integer(),
            'user_id' => $this->integer(),//任务发起人
            'order_rel_id' => $this->integer(),
            'op_id' => $this->integer(),
            'title' => $this->string(200),
            'content' => $this->text(),
            'pre_finish' => $this->dateTime(),//预定完成时间
            'finish' => $this->dateTime(),//完成时间
            'status' => $this->smallInteger(2)->defaultValue(1),//-1删除 1初始
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%task_log}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'user_id' => $this->integer(),//操作人
            'action' => $this->string(200),
            'conent' => $this->text(),
            'created_at'=> $this->integer()->notNull()//操作时间
        ], $tableOptions);

        $this->createTable('{{%task_order}}', [//任务订单关联
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'order_id' => $this->integer(),
            'order_rel_id' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%task_self}}', [//自加的一些任务
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),//任务发起人
            'title' => $this->string(200),
            'content' => $this->text(),
            'pre_finish' => $this->dateTime(),//预定完成时间
            'finish' => $this->dateTime(),//完成时间
            'status' => $this->smallInteger(2)->defaultValue(1),//-1删除 1初始
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%task_info}}');
        $this->dropTable('{{%task}}');
        $this->dropTable('{{%task_user}}');
        $this->dropTable('{{%task_goods}}');
        $this->dropTable('{{%task_log}}');
        $this->dropTable('{{%task_order}}');
        $this->dropTable('{{%task_self}}');
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
