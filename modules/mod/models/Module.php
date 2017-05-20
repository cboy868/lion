<?php

namespace app\modules\mod\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $intro
 * @property string $logo
 * @property integer $status
 * @property integer $created_at
 */
class Module extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['intro'], 'string'],
            [['status', 'created_at'], 'integer'],
            [['name', 'title', 'logo'], 'string', 'max' => 200],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标识',
            'title' => '模块名',
            'intro' => '模块介绍',
            'logo' => 'Logo',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }

    public function createModels()
    {
        $tables = Yii::$app->getModule('mod')->params['table'];

        foreach ($tables as $key => $models) {
            foreach ($models as $k=>$model) {
                self::createTable($k, $this->id);
            }
        }

        Models::createModels($this);
    }

    public static function createTable($table, $module_id)
    {
        $sql = "CREATE TABLE IF NOT EXISTS %s LIKE %s";
        Yii::$app->db->createCommand(sprintf($sql, $table . '_' . $module_id, $table))->execute();
    }


    /**
     * @name 全是硬删除 注意
     */
    public function dropMod()
    {
        self::dropTable($this);
        self::dropData($this);
        Models::delModels($this);
    }

    //表应该不能硬删除，以免丢失数据
    //数据管理员操作时可以使用此方法,也应该先备份
    public static function dropTable($module)
    {
        $tables = Yii::$app->getModule('mod')->params['table'];

        $db = Yii::$app->db;
        foreach ($tables as $v) {
            foreach ($v as $table=>$class) {
                $sql = "drop table IF EXISTS " . $table . '_' . $module->id;
                $db->createCommand($sql)->execute();
            }
        }
    }

    /**
     * @param $table
     * @param $mod
     * @name 硬删除 慎用
     */
    public static function dropData($module)
    {
        $cate_sql = "DELETE FROM cms_category WHERE mid = '". $module->id . "'";
        $field_sql = "DELETE FROM module_field WHERE `model_id` = '" . $module->id . "'";

        Yii::$app->db->createCommand($cate_sql)->execute();
        Yii::$app->db->createCommand($field_sql)->execute();
    }

}
