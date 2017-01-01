<?php

use yii\db\Migration;

class m161129_121955_album extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%album}}', [
            'id' => $this->primaryKey(),
            'author' => $this->string(100),//作者
            'category_id'=>$this->integer(),
            'title' => $this->string(255),
            'thumb' => $this->integer(), //存图片的id
            'intro' => $this->text(),
            'sort'  => $this->integer(),
            'view_all' => $this->integer()->defaultValue(0),
            'com_all' => $this->integer()->defaultValue(0),
            'photo_num' => $this->integer()->defaultValue(0),
            'recommend' => $this->smallInteger()->defaultValue(0),
            'created_by' => $this->integer(),//添加人
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%album}}');
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
