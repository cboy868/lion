<?php

namespace app\modules\mod\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\helpers\FileHelper;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property integer $id
 * @property string $module
 * @property string $name
 * @property string $dir
 * @property string $link
 * @property integer $order
 * @property integer $show
 * @property string $logo
 * @property integer $created_at
 */
class Module extends \yii\db\ActiveRecord
{

    const SHOW_NO = 0;
    const SHOW_YES = 1;

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
            [['module', 'name'], 'required'],
            [['order', 'show', 'created_at'], 'integer'],
            [['intro'], 'string'],
            [['module', 'name', 'dir', 'link', 'logo'], 'string', 'max' => 255],
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

    public function getShowLabel()
    {
        $label = [
            self::SHOW_NO => '否',
            self::SHOW_YES => '是'
        ];

        return $label[$this->show];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module' => '模型',
            'name' => '模块名',
            'dir' => '目录',
            'link' => '连接地址',
            'order' => '排序',
            'show' => '是否显示',
            'showLabel' => '显示',
            'logo' => 'Logo',
            'created_at' => '添加时间',
            'intro' => '简述',
        ];
    }


    public static function createTable($table, $mod)
    {
        $sql = "CREATE TABLE %s LIKE %s";
        Yii::$app->db->createCommand(sprintf($sql, $table . '_' . $mod, $table))->execute();
    }

    public static function deleteTable($table, $mod)
    {
        $sql = "drop table IF EXISTS " . $table . '_' . $mod;

        Yii::$app->db->createCommand($sql)->execute();
    }

    public static function delData($table, $mod)
    {
        $cate_sql = "DELETE FROM cms_category WHERE res_name = '".$table . $mod . "'";
        $field_sql = "DELETE FROM module_field WHERE `table` = '".$table .'_'. $mod . "'";

        Yii::$app->db->createCommand($cate_sql)->execute();
        Yii::$app->db->createCommand($field_sql)->execute();
    }


    public static function deleteMod($model)
    {
        $tables = Yii::$app->controller->module->params['table'][$model->module];

        foreach ($tables as $k => $mod) {
            self::deleteTable($k, $model->id);
        }

        self::delData($model->module, $model->id);
    }


    public static function createModels($module)
    {
        $tables = Yii::$app->controller->module->params['table'][$module->module];

        foreach ($tables as $k => $model) {
            self::createTable($k, $module->id);
        }
    }
}
