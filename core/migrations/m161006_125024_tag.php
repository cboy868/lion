<?php

use yii\db\Migration;

class m161006_125024_tag extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'tag_name' => $this->string(255), //标签名
            'num' => $this->string(255),//标签数量
            'created_at' => $this->integer()->notNull(),//添加时间
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%tag_rel}}', [
            'tag_id' => $this->string(255),//标签数量
            'res_id' => $this->integer(),
            'res_name' => $this->string(255), //标签名
            'created_at' => $this->integer()->notNull(),//添加时间
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%tag_rel}}');
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
