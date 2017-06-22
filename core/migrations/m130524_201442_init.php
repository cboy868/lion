<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'email' => $this->string()->unique(),
            // 'mid' => $this->integer()->defaultValue(0),//用户所属商家id
            'mobile' => $this->string(60),//手机号
            'avatar' => $this->integer(),//头像
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'is_staff' => $this->smallInteger(1)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%user_field}}', [
            'id' => $this->primaryKey(),
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

        $this->createTable('{{%user_addition}}', [
            'user_id' => $this->primaryKey(),
            'real_name' => $this->string(200),
            'logins'    => $this->integer(),
            'gender'    => $this->smallInteger(1)->defaultValue(1),//1男 2女
            'birth'     => $this->date(),
            'height'    => $this->integer(),//厘米
            'weight'    => $this->float(),//kg
            'qq'        => $this->string(20),
            'address'   => $this->text(),
            'hobby'     => $this->text(),
            'native_place' => $this->text(),
            'address'   => $this->text(),//现住址
            'intro'     => $this->text() //个人介绍
        ], $tableOptions);
        $this->createTable('{{%user_log}}', [
            'user_id' => $this->integer(),
            'login_date' => $this->dateTime(),
            'login_ip' => $this->string(100),
        ], $tableOptions);

        $this->createTable('{{%user_token}}', [
            'id' => $this->primaryKey(),
            'user_id'    => $this->integer()->notNull(),
            'code'       => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'type'       => $this->smallInteger()->notNull(),//1注册,2找回密码
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%user_field}}');
        $this->dropTable('{{%user_addition}}');
        $this->dropTable('{{%user_log}}');
        $this->dropTable('{{%user_token}}');
    }
}
