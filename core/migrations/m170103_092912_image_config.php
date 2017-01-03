<?php

use yii\db\Migration;

class m170103_092912_image_config extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%image_config}}', [
            'id' => $this->primaryKey(),
            'res_name' => $this->string(100),
            'is_thumb' => $this->smallInteger(1)->defaultValue(1),
            'thumb_mode' => $this->smallInteger(1)->defaultValue(1),
            'thumb_config' => $this->text(),//缩略配置
            'water_mod' => $this->smallInteger(1)->defaultValue(1),//1图片 2文字
            'water_image' => $this->string(255),
            'water_text' => $this->string(255),
            'water_opacity' => $this->integer(4)->defaultValue(100),
            'water_pos' => $this->smallInteger(),//水印位置
            'created_at' => $this->integer(1)->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%image_config}}');
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
