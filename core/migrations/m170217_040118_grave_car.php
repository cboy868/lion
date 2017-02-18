<?php

use yii\db\Migration;

class m170217_040118_grave_car extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%grave_car_record}}', [
            'id' => $this->primaryKey(),
            'bury_id'=> $this->integer(),
            'user_id' => $this->integer()->notNull(),//用户id
            'tomb_id' => $this->integer()->notNull(),//如果值为0,表示逝者不在本园
            'grave_id' => $this->integer(),
            'dead_id' => $this->string(200),
            'dead_name'=> $this->string(200),
            'car_id' => $this->integer(),
            'driver_id' => $this->integer(),
            'use_date' => $this->date(),
            'use_time' => $this->time(),
            'price' => $this->decimal(10,2),
            'contact_user' => $this->string(200),  
            'contact_mobile' => $this->string(20),
            'user_num' => $this->integer(),
            'addr_id' => $this->integer(),
            'addr' => $this->text(),
            'status' => $this->smallInteger(1),//-1删除 1未派车 2已派 3完成
            'note' => $this->text(),
            'order_id' => $this->integer(),
            'order_rel_id' => $this->integer(),
            'is_cremation' => $this->smallInteger()->defaultValue(0),//是否火化
            'is_back' => $this->smallInteger()->defaultValue(0),//是否返程
            'car_type' => $this->smallInteger(), 
            'updated_at'=> $this->integer()->notNull(),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%grave_car}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(20),
            'type' => $this->smallInteger(1)->defaultValue(1),//车类型 1迎灵 ／2风行
            'keeper' => $this->integer(),//保管人
            'note' => $this->text(),//备注
            'status' => $this->smallInteger(1)->defaultValue(1),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%grave_car_addr}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(200),
            'type' => $this->smallInteger(1)->defaultValue(1),//类型 1近 ／2远
            'time' => $this->integer()->defaultValue(0),//来回需要用的时间 分钟为单位
            'status' => $this->smallInteger(1)->defaultValue(1),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%grave_car}}');
        $this->dropTable('{{%grave_car_record}}');
        $this->dropTable('{{%grave_car_addr}}');
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
