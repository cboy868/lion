<?php

use yii\db\Migration;

class m161231_030523_links extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%links}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200),
            'link' => $this->string(255),
            'logo' => $this->string(255),
            'intro' => $this->text(),
            'status' => $this->smallInteger(1)->defaultValue(1),
            'created_at' => $this->integer(1)->notNull()
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%links}}');
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
