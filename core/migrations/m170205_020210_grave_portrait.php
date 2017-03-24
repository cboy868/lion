<?php

use yii\db\Migration;

class m170205_020210_grave_portrait extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%grave_portrait}}', [
            'id' => $this->primaryKey(),
            'guide_id' => $this->integer()->notNull(),//导购员，退墓操作的员工 
            'user_id' => $this->integer()->notNull(),//用户id
            'tomb_id' => $this->integer()->notNull(),//如果值为0,表示逝者不在本园
            'title' => $this->string(200),
            'sku_id' => $this->integer(),//用作sku_id吧，原来是goods_id
            'order_id' => $this->integer(),
            'order_rel_id' => $this->integer(),
            'dead_ids' => $this->string(),//像上有几个逝者，就有几个id 如12,32
            'photo_original' => $this->string(),//初始照片
            'photo_processed' => $this->string(),//制作好的照片
            'confirm_by' => $this->integer(),//确认人
            'confirm_at' => $this->dateTime(),//确认时间
            'photo_confirm' => $this->string(200),//确认的图片
            'use_at' => $this->dateTime(),//使用时间
            'up_at' => $this->dateTime(),//照片上传时间
            'notice_id' => $this->integer(),//任务id
            'type' => $this->smallInteger(),//瓷像、福寿牌、影雕
            'note' => $this->text(),//备注
            'sort'=> $this->integer()->defaultValue(0),
            'status' => $this->smallInteger(1)->defaultValue(1),//-1删除 1待上传照片,2待ps, 3待确认,4待制作,5待粘贴,6完成
            'updated_at'=> $this->integer()->notNull(),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);
        //status
        // const RETURN_DEPOSIT = 1;//订金退
        // const RETURN_IN = 3; //退墓迁本园
        // const RETURN_OUT = 5;//退墓迁出

        // const RETURN_DEPOSIT_OK = 2;//订金退
        // const RETURN_IN_OK = 4; //退墓迁本园
        // const RETURN_OUT_OK = 6;//退墓迁出

         $this->createTable('{{%grave_portrait_log}}', [
            'id' => $this->primaryKey(),
            'portrait_id' => $this->integer()->notNull(),
            'op_id' => $this->integer()->notNull(),//操作员
            'tomb_id' => $this->integer()->notNull(),//如果值为0,表示逝者不在本园
            'action' => $this->string(100),//动作 删除、编辑、新建之类，确认动作之类确认、上传照片、处理照片之类
            'img' => $this->string(200),//
            'note' => $this->text(),//瓷像其它内容
            'status' => $this->smallInteger(1)->defaultValue(1),//-1删除 1
            'updated_at'=> $this->integer()->notNull(),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%grave_portrait}}');
        $this->dropTable('{{%grave_portrait_log}}');
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
