<?php

use yii\db\Migration;

class m161129_134658_cms_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cms_category}}', [
            'id' => $this->primaryKey(),
            'pid'=> $this->integer(),
            'res_name' => $this->string(255),
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
        $this->dropTable('{{%cms_category}}');
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
