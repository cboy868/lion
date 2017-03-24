<?php

use yii\db\Migration;

class m161006_121900_shop extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%shop_category}}', [
            'id' => $this->primaryKey(),
            'pid'=> $this->integer(),
            'type_id' => $this->integer(),
            'level'=> $this->smallInteger()->notNull()->defaultValue(1),//树级
            'code' => $this->string(255),
            'name' => $this->string(255),
            'thumb' => $this->integer(), //存图片的id
            'body' => $this->text(),//分类的介绍
            'sort' => $this->smallInteger()->notNull()->defaultValue(0),
            'is_leaf' => $this->smallInteger()->notNull()->defaultValue(1),
            'seo_title' => $this->string(255),
            'seo_keywords' => $this->string(255),
            'seo_description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%shop_goods}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'serial' => $this->string(200),
            'name' => $this->string(255),
            'thumb' => $this->integer(),
            'intro' => $this->text(),//介绍
            'skill' => $this->text(),//技巧
            'unit'  => $this->string(100),
            'original_price' => $this->decimal(10,2),//原价
            'price' => $this->decimal(10,2),//现价
            'num' => $this->integer(),
            'is_recommend' => $this->smallInteger()->defaultValue(0),//是否推荐，值越大，优先级越高
            'status' => $this->smallInteger()->notNull()->defaultValue(1), //-1删除
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%shop_sku}}', [
            'id' => $this->primaryKey(),//id
            'goods_id' => $this->integer()->notNull(),
            'serial' => $this->string(200),
            'num'   => $this->integer(),
            'price'=> $this->decimal(10,2),
            'original_price' => $this->decimal(10,2),//原价
            'name' => $this->string(255),//sku名称
            'av' => $this->string(255),//属性:属性值串
            'created_at' => $this->integer()->notNull(),//添加时间
        ], $tableOptions);

        $this->createTable('{{%shop_cart}}', [
            'id' => $this->primaryKey(),//id
            // 'wechat_uid' => $this->string(255)->notNull(),
            'user_id' => $this->integer(),
            'type'   => $this->smallInteger()->defaultValue(1), // 1 点餐, 2订桌
            'goods_id' => $this->integer(),//商品id
            'sku_id' => $this->integer(),//商品id
            'num'      => $this->integer(), //数量
            'created_at' => $this->integer()->notNull(),//添加时间
        ], $tableOptions);

        $this->createTable('{{%shop_history}}', [//看过啥东西
            'id' => $this->primaryKey(),//id
            'wechat_uid' => $this->string(255)->notNull(),
            'goods_id' => $this->integer(),//商品id
            'sku_id' => $this->integer(),//商品id
            'created_at' => $this->integer()->notNull(),//添加时间
        ], $tableOptions);

        $this->createTable('{{%shop_attach}}', [
            'id' => $this->primaryKey(),
            'res_id' => $this->integer(),
            'author_id' => $this->integer(),
            'title' => $this->string(255), //标题
            'path' => $this->string(255), //路径
            'name' => $this->string(255), //真实图片名 加上path为图片地址
            'sort'  => $this->integer(),
            'desc'  => $this->text(),//描述
            'ext'   => $this->string(64),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)//1正常 -1被删除
        ], $tableOptions);

        $this->createTable('{{%shop_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255), //标题
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createTable('{{%shop_message}}', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer(),
            'op_id' => $this->integer()->defaultValue(0),//处理人
            'title' => $this->string(255),
            'term' => $this->date(),
            'product' => $this->string(255),
            'username' => $this->string(255)->notNull(),
            'mobile' => $this->string(50)->notNull(),
            'email' => $this->string(50),
            'qq' => $this->string(20),
            'skype' => $this->string(20),
            'intro' => $this->text(),
            'company' => $this->string(200),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at'=> $this->integer()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%shop_category}}');
        $this->dropTable('{{%shop_goods}');
        $this->dropTable('{{%shop_sku}}');
        $this->dropTable('{{%shop_cart}}');
        $this->dropTable('{{%shop_history}}');
        $this->dropTable('{{%shop_type}}');
        $this->dropTable('{{%shop_message}}');
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
