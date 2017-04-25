<?php

use yii\db\Migration;

class m170424_013738_shop_inventory extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%inventory_storage}}', [//仓库
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull(),
            'pos'  => $this->string(200),//位置
            'op_id' => $this->integer(),//管理员
            'op_name' => $this->string(200),//管理员名字
            'mobile'  => $this->string(15),
            'thumb'   => $this->string(200),//图片
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%inventory_supplier}}', [//供货商
            'id' => $this->primaryKey(),
            'cp_name' => $this->string(200)->notNull(),
            'cp_phone' => $this->string(15),//公司电话
            'addr'  => $this->text()->notNull(),
            'ct_name' => $this->string(255),
            'ct_mobile' => $this->string(15),
            'ct_sex' => $this->smallInteger(),//1先生 2女士 3未知
            'qq' => $this->string(20),
            'wechat' =>$this->string(20),
            'note' => $this->text(),//备注
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%inventory_purchase}}', [//供货记录
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer(),//供货商id
            'op_id' => $this->integer(),
            'op_name'=> $this->string(100),//办理人
            'ct_name' => $this->string(100),//联系人
            'ct_mobile' =>$this->string(15),//
            'checker_id' => $this->integer(),//验收 人
            'checker_name' => $this->string(100),//
            'total' => $this->decimal(10,2),//总金额
            'note' => $this->text(),//备注
            'supply_at' => $this->date(),//供货日期
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),//2退货
        ], $tableOptions);

        $this->createTable('{{%inventory_purchase_rel}}', [//供货记录
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer()->notNull(),//供货商id
            'record_id' => $this->integer()->notNull(),//批次id
            'goods_id' => $this->integer()->notNull(),
            'sku_id' => $this->integer()->notNull(),
            'unit_price' => $this->decimal(10,2),
            'num' => $this->float(),
            'unit' => $this->string(20),//单位
            'total' => $this->decimal(10,2),//总价
            'retail' => $this->decimal(10,2),//建议零售价
            'op_id' => $this->integer(),//操作人
            'op_name' => $this->string(100),//操作人
            'note' => $this->text(),//备注
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1), //2退货
        ], $tableOptions);

        $this->createTable('{{%inventory}}', [//详细记录
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer(),
            'sku_id' => $this->integer(),
            'record' => $this->float(),//记录数量
            'actual' => $this->float(),//实际数量
            'op_id' =>$this->integer(),//
            'op_date' => $this->dateTime(),//盘点时间
            'diff_num' => $this->float(),//盈亏数量 
            'diff_amount' => $this->decimal(10,2),//盈亏金额
            'note' => $this->text(),//备注
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%inventory_purchase_refund}}', [//退货记录
            'id' => $this->primaryKey(),
            'purchase_rel_id' => $this->integer(),//退货记录
            'num' => $this->float(),//退货数量 
            'amount' => $this->decimal(10,2),//退货金额
            'op_id' => $this->integer(),
            'op_name' =>$this->string(),//退货人
            'ct_name' => $this->string(),//退货联系人
            'ct_mobile' => $this->string(15),//电话
            'note' => $this->text(),//备注
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(2),//2发起 //1退款完成
        ], $tableOptions);

        $this->createTable('{{%inventory_purchase_finance}}', [//账务 
            'id' => $this->primaryKey(),
            'purchase_id' => $this->integer(),//
            'refund_id' =>$this->integer(),//
            'amount' => $this->decimal(10,2),//总金额 负值时表示退款
            'op_id' => $this->integer(),
            'op_name' =>$this->string(),//财务操作人
            'ct_name' => $this->string(),//退货联系人
            'ct_mobile' => $this->string(15),//电话
            'note' => $this->text(),//备注
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(2),//2发起 //1付款/退款完成
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%shop_storage}}');
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
