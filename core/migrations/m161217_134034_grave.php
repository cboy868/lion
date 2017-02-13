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
            'pid'=> $this->integer()->defaultValue(0),
            'level'=> $this->smallInteger()->notNull()->defaultValue(1),//树级
            'code' => $this->string(255),
            'name' => $this->string(255)->notNull(),
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
            'mnt_by' => $this->string(200),//立碑人
            'note' => $this->text(),//墓位备注
            'thumb'=> $this->integer(),//封面，如无封面，程序显示时取墓区的
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),//-1删除,1闲置，2预定，3定金 4全款，5 部分安葬 6全部安葬
        ], $tableOptions);

        $this->createTable('{{%grave_dead}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'tomb_id' => $this->integer()->notNull(),
            'memorial_id' => $this->integer(),
            'dead_name'=> $this->string(255)->notNull(),
            'second_name' => $this->string(255),//
            'dead_title' => $this->string()->notNull(),//关系吧 比如母亲、父亲
            'serial' =>$this->integer(),//逝者编号
            'gender' =>$this->smallInteger(1)->defaultValue(1),//1 男  2女
            'birth_place'=> $this->string(255),
            'birth'  =>  $this->date(),//取身份证上的
            'fete'   => $this->date(),//取阳历  //一些纪念日如果想用阴历，可在纪念日中添加
            'is_alive'=> $this->smallInteger(1)->defaultValue(1),
            'is_adult' => $this->smallInteger(1),// 是否成人
            'age' => $this->smallInteger(),
            'follow_id' => $this->integer(),//携子的id
            'desc' => $this->text(),//生平
            'is_ins' => $this->smallInteger(1)->defaultValue(0),//是否立碑
            'bone_type' => $this->string(50),//安葬类型 骨灰 骨质 灵位 之类
            'bone_box' => $this->smallInteger(),//安葬种类 自带骨质盒...
            'pre_bury' => $this->dateTime(),
            'bury' => $this->dateTime(),
            'sort' => $this->smallInteger()->defaultValue(0),//排序
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->smallInteger(),
        ], $tableOptions);

        $this->createTable('{{%grave_customer}}', [
            'id' => $this->primaryKey(),
            'tomb_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(200),
            'phone' => $this->string(20),  //固定电话
            'mobile' => $this->string(20), //手机
            'email' => $this->string(100),//邮箱
            'second_ct' => $this->string(100),
            'second_mobile' => $this->string(20),
            'units' => $this->string(255),//工作单位
            'province' => $this->string(200),
            'city' => $this->string(200),
            'zone' => $this->string(200),
            'addr' => $this->text(),//联系地址
            'relation' => $this->string(100),
            'is_vip' => $this->smallInteger(1)->defaultValue(0),
            'vip_desc'=> $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->smallInteger(),
        ], $tableOptions);

        $this->createTable('{{%grave_bury}}', [
            'id' => $this->primaryKey(),
            'tomb_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'dead_id' => $this->integer()->notNull(),
            'dead_name' => $this->integer()->notNull(),
            'dead_num' => $this->smallInteger()->notNull(),//本次安葬人数
            'bury_type' => $this->smallInteger(),//寿 单  合 独 二次
            'pre_bury_date'=> $this->dateTime(),
            'bury_date' => $this->dateTime(),
            'bury_time' => $this->time(),//类型
            'bury_user' => $this->integer(),//安葬员
            'bury_order'=> $this->smallInteger(),//一天之中的安葬顺序
            'note' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->smallInteger(),

        ], $tableOptions);

        $this->createTable('{{%grave_address}}', [
            'id' => $this->primaryKey(),
            'res_name' => $this->string(100),//类型，比如custome dead之类需要地址的都可以往这里放 
            'res_id' => $this->integer(),
            'province_id' => $this->integer(),
            'city_id' => $this->integer(),
            'zone_id' => $this->integer(),
            'address' => $this->text(),//详细地址 具体的门号
            'postcode'=> $this->string(20),//邮编
            'mobile' => $this->string(20),//电话
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->smallInteger(),
        ], $tableOptions);

        $this->createTable('{{%grave_return}}', [//退墓
            'id' => $this->primaryKey(),
        ], $tableOptions);

        // $this->createTable('{{%grave_address}}', [ // 墓位与定单的关联
        //     'id' => $this->primaryKey(),
        //     'tomb_id' => $this->integer()->notNull(),
        //     'order_id' => $this->integer()->notNull(),
        //     'type' => $this->integer()->notNull(),//哪一步生成的定单,比如安葬用、比如远程用、比如清明用
        // ], $tableOptions);


        //customer address 是不是应该放在外层   然后继承着去做

    }

    public function down()
    {
        $this->dropTable('{{%grave}}');
        $this->dropTable('{{%grave_tomb}}');
        $this->dropTable('{{%grave_dead}}');
        $this->dropTable('{{%grave_customer}}');
        $this->dropTable('{{%grave_bury}}');
        $this->dropTable('{{%grave_address}}');
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
