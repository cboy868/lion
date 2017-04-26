<?php

use yii\db\Migration;

class m170426_130910_news extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'category_id'=>$this->integer()->defaultValue(0),//分类
            'title' => $this->string(255)->notNull(),//标题
            'subtitle' => $this->string(255),//副标题
            'summary'=> $this->text(), //摘要
            'author' => $this->string(100),//新闻的作者
            'pic_author' => $this->string(100),//图片作者
            'video_author'=> $this->string(100),//视频作者
            'source' => $this->string(200),//来源
            'thumb' => $this->integer(), //图片封面
            'video' => $this->string(),//视频地址
            'sort' => $this->integer(),//排序 
            'view_all' => $this->integer()->defaultValue(0),
            'com_all' => $this->integer()->defaultValue(0),
            'recommend' => $this->smallInteger()->defaultValue(0),
            'is_top' => $this->smallInteger()->defaultValue(0),//是否置顶
            'type' => $this->smallInteger()->defaultValue(1),//1文字 2图片 3视频
            'created_by' => $this->integer(),//添加人
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)
        ], $tableOptions);

        $this->createTable('{{%news_data}}', [
            'news_id' => $this->primaryKey(),
            'body'=> $this->text(), //
            'status' => $this->smallInteger()->notNull()->defaultValue(1)//1正常  -1删除
        ], $tableOptions);

        $this->createTable('{{%news_category}}', [
            'id' => $this->primaryKey(),
            'pid'=> $this->integer()->defaultValue(0),
            'level'=> $this->smallInteger()->notNull()->defaultValue(1),//树级
            'code' => $this->string(255),
            'name' => $this->string(255)->notNull(),
            'cover' => $this->integer(), //存图片的id
            'body' => $this->text(),//分类的介绍
            'sort' => $this->smallInteger()->notNull()->defaultValue(0),
            'is_leaf' => $this->smallInteger(1)->defaultValue(1),
            'seo_title' => $this->string(255),
            'seo_keywords' => $this->string(255),
            'seo_description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%news_photo}}', [//相册
            'id' => $this->primaryKey(),
            'news_id' => $this->integer(),//相册id
            'title' => $this->string(200),//相册名
            'path' => $this->string(200),//路径
            'name' => $this->string(200),//图片名
            'sort' => $this->integer(),//排序 
            'view_all' => $this->integer()->defaultValue(0),
            'com_all' => $this->integer()->defaultValue(0),
            'body' => $this->text(),//图片介绍 
            'ext' => $this->string(100),//图片后缀
            'ip' => $this->string(200),//ip
            'created_by' => $this->integer(),//添加人
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%news}}');
        $this->dropTable('{{%news_data}}');
        $this->dropTable('{{%news_category}}');
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
