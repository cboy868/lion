<?php

use yii\db\Schema;
use yii\db\Migration;

class m160116_042049_attachment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
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

        $this->createTable('{{%attachment_rel}}', [
            'res_id' => $this->integer(),
            'res_name' => $this->string(64), //资源名
            'attach_id' => $this->integer(), //附件id
            'use' => $this->string(100),
            'FOREIGN KEY (attach_id) REFERENCES attachment (id) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%attachment}}');
        $this->dropTable('{{%attachment_rel}}');
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
