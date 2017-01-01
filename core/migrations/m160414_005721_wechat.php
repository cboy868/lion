<?php

use yii\db\Migration;

class m160414_005721_wechat extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // $this->createTable('{{%wechat}}', [
        //     'id' => $this->primaryKey(),//id
        //     'name' => $this->string(255),//微信名
        //     'wechat_id' => $this->string(255), //原始微信id
        //     'appid' => $this->string(255),
        //     'secret' => $this->string(255),
        //     'token'=> $this->string(512),
        //     'encodekey' => $this->string(255), //加密串
        //     'type'=> $this->smallInteger()->defaultValue(1),//1明文,2加密,
        //     'created_at' => $this->integer()->notNull(),
        //     'status'    => $this->smallInteger()->defaultValue(1) //1正常 2禁用 －1删除
        // ], $tableOptions);


        $this->createTable('{{%wechat_menu}}', [
            'id' => $this->primaryKey(),
            'pid'=> $this->integer(),
            'level'=> $this->smallInteger()->notNull()->defaultValue(1),//树级
            'code' => $this->string(255),
            'name' => $this->string(255),
            'type' => $this->smallInteger()->notNull()->defaultValue(1), //1 click, 2 view
            'key' => $this->string(128),//事件标记
            'url' => $this->string(255),//view时 url地址
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            // 'uid' => Schema::TYPE_STRING . "(11) NOT NULL DEFAULT '0' COMMENT '用户id' ", 给表加注释是这样加
        ], $tableOptions);

        $this->createTable('{{%wechat_user}}', [
            'id' => $this->primaryKey(),
            'gid' => $this->integer(), //分组id
            'openid' => $this->string(255),
            'user_id' => $this->integer(),//与用户表关联
            'nickname' => $this->string(255),
            'remark'  => $this->string(255),
            'sex'       => $this->smallInteger(),
            'language' => $this->string(120),
            'city'  => $this->string(255),
            'province'  => $this->string(255),
            'country' => $this->string(255),
            'headimgurl'  => $this->string(255),
            'subscribe' => $this->smallInteger(), //是否关注
            'subscribe_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'realname' => $this->string(255),//真实姓名
            'mobile'   => $this->string(12),//电话号码,
            'birth'    => $this->date(),//生日
            'addr'     => $this->text(),//家庭住址
        ], $tableOptions);

        $this->createTable('{{%wechat_group}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255), //分组名
            'count' => $this->integer(), //分组的人数
        ], $tableOptions);

        $this->createTable('{{%wechat_token}}', [
            'wechat_id' => $this->string(255), //原始微信id
            'access_token'=> $this->string(512),//新的access_token
            'expire_at' => $this->integer()->notNull(),//过期时间
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%wechat}}');
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
