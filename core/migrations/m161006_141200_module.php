<?php

use yii\db\Migration;

class m161006_141200_module extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%module}}', [
            'id' => $this->primaryKey(),
            'module' =>$this->string(255)->notNull(),//模块
            'name' => $this->string(255)->notNull(), //模块名
            'dir' => $this->string(255), //静态文件目录
            'link' => $this->string(255), //连接地址
            'order'=> $this->smallInteger(4), //模块排序
            'show' => $this->smallInteger(1)->defaultValue(1), //是否在前台显示
            'logo' => $this->string(255), //logo
            'created_at' => $this->integer()->notNull(),//添加时间
        ], $tableOptions);

        $this->createTable('{{%module_field}}', [
            'id' => $this->primaryKey(),
            'table' =>$this->string(45)->notNull(),//表
            'name' => $this->string(255)->notNull(), //字段名
            'title' => $this->string(255), //显示的标题
            'pop_note' => $this->string(255), //添加时的提示信息
            'html'=> $this->string(100), //表现形式 input textarea之类
            'option' => $this->text(), //选项值，当html为select radio checkbox之类时的选择值
            'default' => $this->text(), //默认值
            'is_show' => $this->smallInteger(1)->defaultValue(1),//是否显示
            'order' => $this->smallInteger(1),//排序
            'created_at' => $this->integer()->notNull(),//添加时间
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%module}}');
        $this->dropTable('{{%module_field}}');
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
