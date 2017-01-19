<?php

use yii\db\Migration;

class m170119_010710_memorial extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%memorial}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'tomb_id' => $this->integer()->defaultValue(0),//如果值为0,表示逝者不在本园
            'title'   => $this->string(255),
            // 'custom_title' => $this->string(255), //客户自定义的名字, 感觉没啥用呢
            'cover'     => $this->string(255),//封面
            'intro'   => $this->text(),//生平介绍
            'privacy' => $this->smallInteger(1)->defaultValue(0),//隐私,0 公开,1好友,2隐私
            'view_all'=> $this->integer()->defaultValue(0),
            'com_all' => $this->integer()->defaultValue(0),
            'tpl' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger(1)->defaultValue(1),//-1删除 1正常
            'updated_at'=> $this->integer()->notNull(),
            'created_at'=> $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%memorial_day}}', [
            'id' => $this->primaryKey(),
            'memorial_id' => $this->integer(),
            'date'        => $this->date(),
            'date_type'   => $this->smallInteger(1)->defaultValue(1),//1阳历 2阴历
            'created_by'  => $this->integer(),
            'created_at'  => $this->integer()->notNull(),
            'status'      => $this->smallInteger(1)->defaultValue(1),//-1删除 1正常
        ], $tableOptions);

        //纪念馆管理人
        $this->createTable('{{%memorial_user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'memorial_id' => $this->integer()->notNull(),
            'relation'    => $this->string(100),//与纪念馆逝者的关系
            'note'       => $this->text(),//备注
            'status'     => $this->smallInteger()->defaultValue(1),//-1删除此关系
            'created_at'  => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%memorial_pray}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'memorial_id' => $this->integer()->notNull(),
            'type'    => $this->string(200),//纪念方式 如点珠、献花、购买的东西//这个在配置里取就好吧
            'msg'       => $this->text(),//寄语
            'order_id'  => $this->integer()->defaultValue(0),//如果此值不为0,则是购买的东西，看看页面要怎么展示
            'created_at'  => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%memorial_rel}}', [
            'id' => $this->primaryKey(),
            'memorial_id' => $this->integer()->notNull(),
            'res_name' => $this->string(200)->notNull(),
            'res_id' => $this->integer()->notNull(),
            'res_title' => $this->string(255),
            'res_user'  => $this->string(200),//文章作者
            'res_cover' => $this->string(200),//文章封面
            'created_at'  => $this->integer()->notNull(),
        ], $tableOptions);


    }

    public function down()
    {
        $this->dropTable('{{%memorial}}');
        $this->dropTable('{{%memorial_day}}');
        $this->dropTable('{{%memorial_user}}');
        $this->dropTable('{{%memorial_pray}}');
        $this->dropTable('{{%memorial_rel}}');
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
