<?php

use yii\db\Migration;

class m161006_120844_order extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),//id
            'wechat_uid' => $this->integer(),//下订单的人.微信用户表中的id
            'user_id' => $this->integer(),//下单人
            'op_id' => $this->integer(),//下单人
            'price' => $this->decimal(10,2),
            'origin_price' => $this->decimal(10,2),
            'type'    => $this->smallInteger()->defaultValue(1),//订单类型 1点餐 2订桌
            'progress'=> $this->smallInteger()->defaultValue(0),//状态0订单初始 1支付部分,2支付完成,3服务完成
            'note'     => $this->text(),//备注
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status'    => $this->smallInteger()->defaultValue(1) //1正常 2禁用 3部分退款 4整单退款 －1删除
            // 'uid' => Schema::TYPE_STRING . "(11) NOT NULL DEFAULT '0' COMMENT '用户id' ", 给表加注释是这样加
        ], $tableOptions);

        $this->createTable('{{%order_rel}}', [
            'id' => $this->primaryKey(),//id
            'wechat_uid' => $this->integer(),//购买人, 微信表中的id
            'user_id' => $this->integer(),//下单人
            'op_id' => $this->integer(),//下单人
            'title'=> $this->string(255), //商品名
            'type' => $this->smallInteger()->defaultValue(1), //类型1点餐,2订桌
            'category_id' => $this->smallInteger(),//菜品分类,
            'goods_id' => $this->integer(),//菜品id,
            'sku_id' => $this->integer(),
            'sku_name' => $this->string(),
            'order_id' => $this->integer(),
            'price' => $this->decimal(10,2),//商品总价
            'price_unit' => $this->decimal(10,2),//商品单价
            'num'   => $this->integer(),//购买数量
            'use_time' => $this->dateTime(),//使用时间
            'note'   => $this->text(),//备注
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status'    => $this->smallInteger()->defaultValue(1) //1正常 2禁用 3 退款 －1删除
        ], $tableOptions);

        $this->createTable('{{%order_pay}}', [
            'id' => $this->primaryKey(),//id
            'wechat_uid' => $this->integer(),//下订单的人.微信用户表中的id
            'user_id' => $this->integer(),//下订单的人.微信用户表中的id
            'op_id' => $this->integer(),//下单人
            'order_id' => $this->integer(),
            'order_no' => $this->string(255),
            'trade_no' => $this->string(255),
            'total_fee'=> $this->decimal(10,2),
            'total_pay'=> $this->decimal(10,2),
            'pay_method' => $this->smallInteger(),//0未知,1微信,2支付宝
            'pay_result' => $this->smallInteger(),//-1支付失败，0待支付，1支付部分 2支付完成
            'paid_at'     => $this->dateTime(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'checkout_at'=> $this->dateTime(),//结账日期
            'note'       => $this->text(),//付款说明
            'status'     => $this->smallInteger()->defaultValue(1) //1正常 －1删除
        ], $tableOptions);

        $this->createTable('{{%order_refund}}', [
            'id' => $this->primaryKey(),//id
            'order_id' => $this->integer(),
            'wechat_uid'    => $this->integer(),
            'user_id'    => $this->integer(),
            'op_id' => $this->integer(),//操作人
            'fee'      => $this->decimal(10,2),
            'progress' => $this->smallInteger()->defaultValue(1),//-1 审不通过，1待审 2审通过 3已退
            'intro'     => $this->text(),//退款内容
            'note'      => $this->text(),//备注
            'checkout_at'=> $this->dateTime(),//结算时间
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status'    => $this->smallInteger()->defaultValue(1), //1正常, -1删除
        ], $tableOptions);

        $this->createTable('{{%order_delay}}', [//欠款
            'id' => $this->primaryKey(),//id
            'order_id' => $this->integer(),
            'user_id'    => $this->integer(),
            'op_id' => $this->integer(),
            'price' => $this->decimal(10,2),
            'pre_dt' => $this->date(),//预定还款期
            'pay_dt' => $this->dateTime(),//实际支付时间
            'note'  => $this->text(),//备注
            'created_by' => $this->integer(),
            'is_verified' => $this->smallInteger(1)->defaultValue(0),//是否已审批通过
            'verified_by' => $this->integer(),//审批人
            'verified_at' => $this->integer(),//审批通过时间
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status'    => $this->smallInteger()->defaultValue(1), //1正常, -1删除
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%order_rel}}');
        $this->dropTable('{{%order_pay}}');
        $this->dropTable('{{%order_refund}}');
        $this->dropTable('{{%order_delay}}');
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
