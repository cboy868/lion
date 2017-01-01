<?php

use yii\db\Migration;

class m161006_125017_shop_foods extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%shop_mix_cate}}', [
            'id' => $this->primaryKey(),
            'pid'=> $this->integer(),
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
            // 'uid' => Schema::TYPE_STRING . "(11) NOT NULL DEFAULT '0' COMMENT '用户id' ", 给表加注释是这样加
        ], $tableOptions);

        $this->createTable('{{%shop_mix}}', [
            'id' => $this->primaryKey(),
            // 'category_id' => $this->integer()->defaultValue(0),//属性分类
            'mix_cate' => $this->integer()->defaultValue(0),//属性分类
            'name' => $this->string(255),//属性的名称
            'thumb' => $this->string(255),//图片
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            // 'uid' => Schema::TYPE_STRING . "(11) NOT NULL DEFAULT '0' COMMENT '用户id' ", 给表加注释是这样加
        ], $tableOptions);

        $this->createTable('{{%shop_mix_rel}}', [
            // 'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'mix_cate' => $this->integer()->defaultValue(0),//属性分类
            'goods_id' => $this->integer(),
            'mix_id' => $this->integer(),//属性id
            'measure' => $this->string(255)->notNull(),//份量
            'type' => $this->smallInteger(1)->defaultValue(0),//0主料 1辅料
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            // 'uid' => Schema::TYPE_STRING . "(11) NOT NULL DEFAULT '0' COMMENT '用户id' ", 给表加注释是这样加
        ], $tableOptions);

        $this->createTable('{{%shop_process}}', [
            'id' => $this->primaryKey(),
            // 'mid'=> $this->integer(),//商家id
            'goods_id' => $this->integer(),
            'step' => $this->smallInteger(),
            'intro' => $this->text(),//步骤说明
            'thumb' => $this->string(255),//步骤图片,设置成直接地址是为了更简单,以后调用缩略图可直接使用地址自动生成的方式
            'type'  => $this->smallInteger()->defaultValue(1),//类型 1 步骤, 2成品图
            'sort'  => $this->smallInteger(),//排序
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%shop_mix_cate}}');
        $this->dropTable('{{%shop_mix}}');
        $this->dropTable('{{%shop_mix_rel}}');
        $this->dropTable('{{%shop_process}}');
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
