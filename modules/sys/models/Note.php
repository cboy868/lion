<?php

namespace app\modules\sys\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%sys_note}}".
 *
 * @property integer $id
 * @property string $res_name
 * @property integer $res_id
 * @property integer $user_id
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 */
class Note extends \yii\db\ActiveRecord
{

    const RES_TOMB = 'tomb';
    const RES_CUSTOMER = 'customer';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_note}}';
    }

    public static function res($res_name = null)
    {
        $r = [
            self::RES_TOMB => '墓位',
            self::RES_CUSTOMER => '客户'
        ];

        if ($res_name === null) {
            return $r;
        }

        return $r[$res_name];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_name', 'res_id', 'user_id'], 'required'],
            [['res_id', 'user_id', 'status', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['res_name'], 'string', 'max' => 255],
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
            'res_name' => '类型',
            'res_id' => '类型id',
            'user_id' => '用户id',
            'content' => '内容',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }

    public static function create($res_name, $res_id, $content)
    {
        $data = [
            'res_name' => $res_name,
            'res_id'   => $res_id,
            'content'  => $content,
            'user_id'  => Yii::$app->user->id
        ];

        $note = new self();
        $note->load($data, '');
        NoteLog::create($note->id, $content);
        return $note->save();
    }

    /**
     * @name 修改备注
     */
    public static function edit($id, $content)
    {
        $model = self::findOne($id);
        if (!$model) {
            return ;
        }
        $model->content = $content;
        NoteLog::create($model->id, $content);
        return $model->save();
    }
}
