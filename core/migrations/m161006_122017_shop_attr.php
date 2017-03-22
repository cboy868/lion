<?php

use yii\db\Migration;

class m161006_122017_shop_attr extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%shop_attr}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer(),
            'name' => $this->string(255),//属性的名称
            'is_multi' => $this->smallInteger()->defaultValue(0),//1多选,0单选
            'is_spec' => $this->smallInteger()->defaultValue(0),//是规格还是属性
            'body' => $this->text(),//分类的介绍
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%shop_av}}',[ //属性值
            'id' => $this->primaryKey(),
            'type_id' => $this->integer(),
            'attr_id' => $this->integer(),
            'val' => $this->string(255),//属性的名称
            'thumb' => $this->string(200), //存图片的id
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%shop_av_rel}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer(),
            'category_id' => $this->integer(),
            'goods_id' => $this->integer(),
            'attr_id' => $this->integer(),//属性id
            'av_id' => $this->integer(), //属性值id
            'value' => $this->string(200),
            // 'num' => $this->integer(),//此属性商品的数量   有了sku 这个值应该没用了
            // 'price' => $this->decimal(10,2),//本属性要增加的价格 有了sku 这个值应该没用了
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%shop_attr}}');
        $this->dropTable('{{%shop_av}}');
        $this->dropTable('{{%shop_av_rel}}');
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
