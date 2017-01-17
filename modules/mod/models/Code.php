<?php

namespace app\modules\mod\models;

use Yii;

/**
 * This is the model class for table "{{%module_code}}".
 *
 * @property integer $id
 * @property integer $module
 * @property string $type
 * @property string $code
 */
class Code extends \app\core\db\ActiveRecord
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
            $model_code = str_replace('{modstr}', $mod, $code->code);
            eval($model_code);
        }
    }
}
