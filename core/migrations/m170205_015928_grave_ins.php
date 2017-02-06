<?php

use yii\db\Migration;

class m170205_015928_grave_ins extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%grave_ins}}', [
            'id' => $this->primaryKey(),
            'guide_id' => $this->integer()->notNull(),//导购员，退墓操作的员工 
            'user_id' => $this->integer()->notNull(),//用户id
            'tomb_id' => $this->integer()->notNull(),//如果值为0,表示逝者不在本园
            'op_id' => $this->integer(),//操作人
            'position' => $this->string(100),//位置，前、后、盖板之类
            'shape' => $this->smallInteger(1),//横，竖
            'content' => $this->text(),
            'img' => $this->string(255),
            'is_tc' => $this->smallInteger(1),//是否繁体字 
            'font' => $this->smallInteger(1),//字体 
            'font_num' => $this->smallInteger(),//字数
            'new_font_num' => $this->smallInteger(),//新增字数
            'is_confirm' => $this->smallInteger(1),
            'confirm_date' => $this->date(),
            'confirm_by' => $this->integer(),
            'pre_finish' => $this->date(),
            'finish_at' => $this->date(),
            'note' => $this->text(),//碑文备注
            'version' => $this->integer(),//保留版本图片，之后可能比较安全
            'paint' => $this->smallInteger(),//金箔、铜粉之类
            'is_stand' => $this->smallInteger(1),//是否已立碑,立碑后，此字段不再有变动
            'paint_price' => $this->decimal(10,2), //颜料费
            'letter_price' => $this->decimal(10,2),//字费
            'tc_price'      => $this->decimal(10,2),//繁体字费 
            'status' => $this->smallInteger(1)->defaultValue(1),//-1删除 1
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

        $this->createTable('{{%grave_ins_log}}', [
            'id' => $this->primaryKey(),
            'ins_id' => $this->integer()->notNull(),
            'op_id' => $this->integer()->notNull(),//操作员
            'tomb_id' => $this->integer()->notNull(),//如果值为0,表示逝者不在本园
            'action' => $this->string(100),//动作 删除、编辑、新建之类，确认动作之类
            'img' => $this->string(200),//
            'content' => $this->text(),//碑文内容  json或serialize格式存
            'status' => $this->smallInteger(1)->defaultValue(1),//-1删除 1
            'updated_at'=> $this->integer()->notNull(),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%grave_ins}}');
        $this->dropTable('{{%grave_ins_log}}');
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
