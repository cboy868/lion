<?php

namespace app\modules\sys\models;

use Yii;

/**
 * This is the model class for table "{{%set}}".
 *
 * @property string $sname
 * @property string $svalue
 * @property string $svalues
 * @property string $sintro
 * @property string $stype
 * @property string $smodule
 */
class Set extends \yii\db\ActiveRecord
{

        //设置所属模块
    const MODULE_SYSTEM = 'system';
    const MODULE_UPLOAD = 'upload';
    const MODULE_SEO    = 'seo';
    const MODULE_EMAIL  = 'email';

    //设置的值类型
    const TYPE_INPUT    = 'input';
    const TYPE_FILE     = 'file';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_SELECT   = 'select';
    const TYPE_RADIO    = 'radio';
    const TYPE_CHECKBOX = 'checkbox';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sname', 'sintro', 'stype'], 'required'],
            [['svalue', 'svalues', 'stype'], 'string'],
            [['sname'], 'string', 'max' => 20],
            [['sintro'], 'string', 'max' => 255],
            [['smodule'], 'string', 'max' => 100],
            [['sname'], 'unique'],
            [['sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sname' => '设置名',
            'svalue' => '值',
            'svalues' => '多值选择',
            'sintro' => '备注',
            'stype' => '输入类型',
            'smodule' => '所属模块',
            'sort'  => '排序'
        ];
    }

     public static function getModule($module=null)
    {

        $arr = Yii::$app->controller->module->params['set_modules'];

        // $arr = [
        //     self::MODULE_SEO => 'SEO设置',
        //     self::MODULE_UPLOAD => '上传设置',
        //     self::MODULE_SYSTEM => '系统设置'
        // ];
        if (is_null($module)) {
            return $arr;
        } else if(isset($arr[$module])) {
            return $arr[$module];
        } else {
            return '';
        }
    }

    public static function getTypes($type = null)
    {
        $arr = [
            self::TYPE_INPUT => 'Input',
             self::TYPE_FILE  => 'File',
            // self::TYPE_CHECKBOX => 'Checkbox',
            // self::TYPE_RADIO    => 'Radio',
            self::TYPE_SELECT   => 'Select',
            self::TYPE_TEXTAREA => 'Textarea'
        ];

        return is_null($type) ? $arr : $arr[$type];
    }

    /**
     * 获取svalue值
     */
    // public function getValue()
    // {
    //     $multi = [
    //         self::TYPE_INPUT,
    //         self::TYPE_TEXTAREA,
    //         self::TYPE_FILE
    //     ];
    //     if (in_array($this->stype, $multi)) {
    //         return $this->svalue;
    //     } else {
    //         $values = unserialize($this->svalues);
    //         return $values[$this->svalue];
    //     }
    // }
}
