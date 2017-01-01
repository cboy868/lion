<?php

use yii\db\Migration;

class m160513_044426_note extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey(),//id
            'res_name' => $this->string('255'), //类型 比如在点餐页面显示，则可能为foods,普通商品页面显示可能是goods
            'intro' => $this->text(),
            'user_id' =>$this->integer(),//添加人
            'start' => $this->date(),//显示开始时间
            'end'   => $this->date(),//显示截止时间
            'created_at' => $this->integer()->notNull(),
            'status'    => $this->smallInteger() //1正常 2禁用 －1删除
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%shop_note}}');
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
