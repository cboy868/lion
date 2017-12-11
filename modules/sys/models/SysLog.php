<?php

namespace app\modules\sys\models;

use Yii;

/**
 * This is the model class for table "{{%sys_log}}".
 *
 * @property string $id
 * @property string $res_name
 * @property string $res_id
 * @property integer $op_id
 * @property string $op_name
 * @property string $action
 * @property string $dt
 * @property string $intro
 * @property string $extra
 */
class SysLog extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'op_id'], 'integer'],
            [['op_id', 'op_name', 'dt'], 'required'],
            [['dt'], 'safe'],
            [['intro'], 'string'],
            [['res_name', 'op_name'], 'string', 'max' => 50],
            [['action'], 'string', 'max' => 30],
            [['extra'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'res_name' => '源',
            'res_id' => '源id',
            'op_id' => '操作人',
            'op_name' => '操作人',
            'action' => '动作',
            'dt' => '日期',
            'intro' => '描述',
            'extra' => '扩展',
        ];
    }

    public static function create($res_name, $res_id, $action,$intro='', $extra='')
    {
        $model = new self;
        $model->res_name = $res_name;
        $model->res_id = $res_id;
        $model->action = $action;
        $model->intro = $intro;
        $model->extra = $extra;
        $model->dt = date('Y-m-d H:i:s');
        $user = Yii::$app->user->identity;
        $model->op_id = $user->id;
        $model->op_name = $user->username;
        return $model->save();

    }

    public static function rlist($res_name, $res_id)
    {
        return self::find()->where(['res_name'=>$res_name,'res_id'=>$res_id])
            ->orderBy('id asc')
            ->all();
    }

    public static function types($type=null)
    {
        $t = [
            'create' => '创建',
            'update' => '编辑',
            'refuse' => '拒绝',
            'pass'   => '通过'
        ];

        if ($type === null) {
            return $t;
        }

        return isset($t[$type]) ? $t[$type] : '';
    }

    public function getType()
    {
        return static::types($this->action);
    }
}
