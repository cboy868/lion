<?php

use yii\db\Migration;

class m161217_134034_grave extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%grave}}', [
            'id' => $this->primaryKey(),
            'pid'=> $this->integer(),
            'level'=> $this->smallInteger()->notNull()->defaultValue(1),//树级
            'code' => $this->string(255),
            'name' => $this->string(255),
            'thumb' => $this->integer(), //存图片的id
            'intro' => $this->text(),//墓区的介绍
            'area_totle' => $this->float(),//总建筑面积
            'area_use'   => $this->float(),//使用面积
            'price'      => $this->decimal(10,2),//墓位基价，之后的墓位默认价格取此
            'status'=> $this->smallInteger(1), //墓区状态  -1删除 1建设中,2销售中,3售完
            'user_id' => $this->integer(),//添加人
            'sort' => $this->smallInteger()->notNull()->defaultValue(0),
            'is_leaf' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('{{%grave_tomb}}', [
            'id' => $this->primaryKey(),
            'grave_id'=> $this->integer(),
            'row' => $this->integer(),//排
            'col' => $this->integer(),//号
            'special' => $this->string(100), //处理一些特别情况，排和号不够用了，用此字段
            'tomb_no'  => $this->string(255),//墓位号，根据墓区排列号生成。
            'hole'    => $this->smallInteger(), //墓穴个数，也可理解为可安葬几个人。
            'price'   => $this->decimal(10,2),//墓位价格
            'cost'    => $this->decimal(10,2),//墓位石材成本 
            'area_total' => $this->float(),//占地面积
            'area_use' => $this->float(),//净墓面积
            'user_id'   => $this->integer(),//购买用户id
            'customer_id' => $this->integer(),//客户id
            'agent_id' => $this->integer(),//业务员id
            'agency_id' => $this->integer(),//办事处
            'guide_id' => $this->integer(),//导购员id
            'sale_time' => $this->dateTime(),//售出时间
            'note' => $this->text(),//墓位备注
            'thumb'=> $this->integer(),//封面，如无封面，程序显示时取墓区的
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),//-1删除,1闲置，2预定，3定金 4全款，5 部分安葬 6全部安葬
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%grave}}');
        $this->dropTable('{{%grave_tomb}}');
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
