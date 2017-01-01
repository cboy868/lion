<?php

use yii\db\Schema;
use yii\db\Migration;

class m160110_012843_post extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'author' => $this->string(100),//添加的作者
            'category_id'=>$this->integer()->defaultValue(0),
            'title' => $this->string(255),
            'subtitle' => $this->string(255),
            'summary'=> $this->text(), //摘要
            'thumb' => $this->integer(), //存图片的id
            'ip'    => $this->string(64),
            'view_all' => $this->integer()->defaultValue(0),
            'com_all' => $this->integer()->defaultValue(0),
            'recommend' => $this->smallInteger()->defaultValue(0),
            'created_by' => $this->integer(),//添加人
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            // 'uid' => Schema::TYPE_STRING . "(11) NOT NULL DEFAULT '0' COMMENT '用户id' ", 给表加注释是这样加
        ], $tableOptions);


        $this->createTable('{{%post_data}}', [
            // 'id' => $this->primaryKey(),
            'post_id' => $this->primaryKey(),
            'body'=> $this->text(), //
            // 'sort'=> $this->smallInteger()->notNull()->defaultValue(1),//排序，可用于分页
            'status' => $this->smallInteger()->notNull()->defaultValue(1),//1正常  -1删除
            'FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);


        $this->createTable('{{%post_attach}}', [
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

        $this->createTable('{{%post_category}}', [
            'id' => $this->primaryKey(),
            'pid'=> $this->integer(),
            'level'=> $this->smallInteger()->notNull()->defaultValue(1),//树级
            'code' => $this->string(255),
            'name' => $this->string(255),
            'cover' => $this->integer(), //存图片的id
            'body' => $this->text(),//分类的介绍
            'sort' => $this->smallInteger()->notNull()->defaultValue(0),
            'is_leaf' => $this->smallInteger(1)->defaultValue(1),
            'seo_title' => $this->string(255),
            'seo_keywords' => $this->string(255),
            'seo_description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            // 'uid' => Schema::TYPE_STRING . "(11) NOT NULL DEFAULT '0' COMMENT '用户id' ", 给表加注释是这样加
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%post}}');
        $this->dropTable('{{%post_data}}');
        $this->dropTable('{{%post_attach}}');
        $this->dropTable('{{%post_category}}');
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
