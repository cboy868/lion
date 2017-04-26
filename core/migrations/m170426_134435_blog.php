<?php

use yii\db\Migration;

class m170426_134435_blog extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),//标题
            'summary'=> $this->text(), //摘要
            'thumb' => $this->integer(), //图片封面
            'video' => $this->string(),//视频地址
            'body' => $this->text(),//
            'sort' => $this->integer(),//排序 
            'recommend' => $this->smallInteger()->defaultValue(0),//是否推荐 数值越大，越靠前
            'is_customer' => $this->smallInteger()->defaultValue(0),
            'is_top' => $this->smallInteger()->defaultValue(0),//是否置顶
            'type' => $this->smallInteger()->defaultValue(1),//1文字 3视频
            'memorial_id' => $this->integer()->defaultValue(0),//纪念馆id
            'privacy' => $this->smallInteger()->defaultValue(1),//隐私设置 1公开 2私密
            'view_all' => $this->integer()->defaultValue(0),
            'com_all' => $this->integer()->defaultValue(0),
            'publish_at' => $this->dateTime(),
            'created_by' => $this->integer(),//添加人
            'ip' => $this->string(200),//ip
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%blog_album}}', [//相册
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),//标题
            'summary'=> $this->text(), //摘要介绍
            'thumb' => $this->integer(), //图片封面
            'body' => $this->text(),//
            'sort' => $this->integer(),//排序 
            'recommend' => $this->smallInteger()->defaultValue(0),//是否推荐 数值越大，越靠前
            'is_customer' => $this->smallInteger()->defaultValue(0),
            'is_top' => $this->smallInteger()->defaultValue(0),//是否置顶
            'memorial_id' => $this->integer()->defaultValue(0),//纪念馆id
            'privacy' => $this->smallInteger()->defaultValue(1),//隐私设置 1公开 2私密
            'view_all' => $this->integer()->defaultValue(0),
            'com_all' => $this->integer()->defaultValue(0),
            'num'=> $this->integer(),//照片数
            'created_by' => $this->integer(),//添加人
            'ip' => $this->string(200),//ip
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%blog_album_photo}}', [//相册
            'id' => $this->primaryKey(),
            'album_id' => $this->integer(),//相册id
            'title' => $this->string(200),//相册名
            'path' => $this->string(200),//路径
            'name' => $this->string(200),//图片名
            'sort' => $this->integer(),//排序 
            'view_all' => $this->integer()->defaultValue(0),
            'com_all' => $this->integer()->defaultValue(0),
            'body' => $this->text(),//图片介绍 
            'ext' => $this->string(100),//图片后缀
            'ip' => $this->string(200),//ip
            'privacy' => $this->smallInteger()->defaultValue(1),//继承相册的值
            'created_by' => $this->integer(),//添加人
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%blog}}');
        $this->dropTable('{{%blog_album}}');
        $this->dropTable('{{%blog_album_photo}}');

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
