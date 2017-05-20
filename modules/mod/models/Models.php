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
class Models extends \yii\db\ActiveRecord
{

    const SHOW_NO = 0;
    const SHOW_YES = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module_model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'name', 'mid'], 'required'],
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


    public static function createModels($module)
    {
        $models = Yii::$app->getModule('mod')->params['table'];

        foreach ($models as $k => $model) {
            $m = new self;
            $m->mid = $module->id;
            $m->module = $k . '_' . $module->id;
            $m->name = $module->title;
            $m->save();
        }
    }

    public static function delModels($module)
    {
        return Yii::$app->db->createCommand()
                        ->delete(self::tableName(),[
                            'mid' => $module->id
                        ])->execute();

    }

}
