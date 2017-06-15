<?php

namespace api\common\models;

use Yii;

/**
 * This is the model class for table "{{%module_code}}".
 *
 * @property integer $id
 * @property integer $module
 * @property string $type
 * @property string $code
 */
class Code extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module_code}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'code', 'module'], 'required'],
            [['code'], 'string'],
            [['type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module' => 'Module',
            'type' => 'Type',
            'code' => 'Code',
        ];
    }


    public static function createObj($module, $mod)
    {
        $codes = Code::find()->where(['module'=>$module])->orderBy('id asc')->all();

        foreach ($codes as $code) {

            $type = $mod;
            if ($code->type == 'search') {
                $type = $mod . 'Search';
            } else if ($code->type == 'data') {
                $type = 'Data' . $mod;
            }

            $class = ucfirst($code->module) . $type;
            $rclass = "app\modules\cms\models\mods\\" . $class;

            if (class_exists($rclass)) {
                continue;
            }

            $model_code = str_replace('{modstr}', $mod, $code->code);

            eval($model_code);
        }

    }
}
