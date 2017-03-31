<?php

use yii\db\Migration;

class m170331_022311_shop_bag extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%shop_bag}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->defaultValue(0),//如果是0，则为跨分类
            'title' => $this->string(255)->notNull(),
            'op_id' => $this->integer(),
            'original_price' => $this->decimal(10,2),//直接加起来的商品总价
            'price' => $this->decimal(10,2),
            'thumb' => $this->integer(),//缩图
            'intro' => $this->text(),//商品介绍 
            'type' => $this->smallInteger()->defaultValue(1),//是组合sku还是单个sku 1 组合  2单个
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at'=> $this->integer()->notNull(),
            'updated_at'=> $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%shop_bag_rel}}', [//任务类型信息
            'id' => $this->primaryKey(),
            'bag_id' => $this->integer()->notNull(),
            'sku_id' => $this->integer()->notNull(),
            'num'    => $this->integer()->defaultValue(1)->notNull(),
            'unit_price'  => $this->decimal(10,2),//添加时，单个商品的价格
            'price' => $this->decimal(10,2),//总价
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at'=> $this->integer()->notNull(),
        ], $tableOptions);
       
    }

    public function down()
    {
        $this->dropTable('{{%shop_bag}}');
        $this->dropTable('{{%shop_bag_rel}}');
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
