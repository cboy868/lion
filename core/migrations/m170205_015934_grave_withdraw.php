<?php

use yii\db\Migration;

class m170205_015934_grave_withdraw extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%grave_withdraw}}', [
            'id' => $this->primaryKey(),
            'guide_id' => $this->integer()->notNull(),//导购员，退墓操作的员工 
            'user_id' => $this->integer()->notNull(),//用户id
            'tomb_id' => $this->integer()->notNull(),//如果值为0,表示逝者不在本园
            'current_tomb_id' => $this->integer()->notNull(),//新墓位id
            'refund_id' => $this->integer(),//如果产生了退款，则加一条退款记录
            'ct_name' => $this->string(200),//联系人
            'ct_mobile' => $this->string(20),
            'ct_card' => $this->string(100),
            'ct_relation' => $this->string(100),
            'reson' => $this->text(),//退墓原因
            'price' => $this->decimal(10,2),//退墓产生的金额
            'in_tomb_id' => $this->integer(),//退墓迁本园的迁入id
            'note' => $this->text(),//备注
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

    }

    public function down()
    {
        $this->dropTable('{{%grave_withdraw}}');
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
