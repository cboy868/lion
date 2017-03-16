<?php

use yii\db\Migration;

/**
 * @name 统计
 */
class m170316_013222_analysis extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%settlement}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'op_id' => $this->integer()->notNull(),
            'guide_id' => $this->integer(),
            'agent_id' => $this->integer(),
            'type'     => $this->smallInteger()->notNull(),//结算类型 1定金 2充定金 3充定金全款 4全款 5退款 6退墓
            'pay_type' => $this->smallInteger()->notNull(),//支付方式
            'ori_price'=> $this->decimal(10,2)->notNull(),//原价
            'price'    => $this->decimal(10,2)->notNull(),//实付款
            'year'     => $this->smallInteger(),
            'month'    => $this->smallInteger(2),
            'week'     => $this->smallInteger(2),
            'day'      => $this->smallInteger(2),
            'settle_time' => $this->dateTime()->notNull(),//结帐时间
            'pay_time'  => $this->dateTime(),
            'intro'    => $this->text(),
            'status'   => $this->smallInteger()->defaultValue(1),
            'created_at'=> $this->integer()->notNull(),
            'updated_at'=> $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%settlement_rel}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'settlement_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'op_id' => $this->integer()->notNull(),
            'guide_id' => $this->integer(),
            'agent_id' => $this->integer(),
            'res_name' => $this->string(100),//商品类型 tomb, goods
            'category_id' => $this->integer()->notNull(),
            'goods_id'  => $this->integer()->notNull(),
            'sku_id'    => $this->integer()->notNull(),
            'type'     => $this->smallInteger(),//总款打折后，明细的分配方式 1按比例平均，2如有墓位,计算到墓位,如无墓位，按比例平均
            'num'      => $this->integer()->defaultValue(1),//数量
            'ori_price'=> $this->decimal(10,2)->notNull(),//原价
            'price'    => $this->decimal(10,2)->notNull(),//实付款
            'year'     => $this->smallInteger(),
            'month'    => $this->smallInteger(2),
            'week'     => $this->smallInteger(2),
            'day'      => $this->smallInteger(2),
            'settle_time' => $this->dateTime()->notNull(),//结帐时间
            'pay_time'  => $this->dateTime(),
            'intro'    => $this->text(),
            'status'   => $this->smallInteger()->defaultValue(1),
            'created_at'=> $this->integer()->notNull(),
            'updated_at'=> $this->integer()->notNull()
        ], $tableOptions);
       
    }

    public function down()
    {
        $this->dropTable('{{%settlement}}');
        $this->dropTable('{{%settlement_rel}}');
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
