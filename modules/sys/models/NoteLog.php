<?php

namespace app\modules\sys\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%sys_note_log}}".
 *
 * @property integer $id
 * @property integer $note_id
 * @property integer $user_id
 * @property string $content
 * @property integer $created_at
 */
class NoteLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_note_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_id', 'user_id'], 'required'],
            [['note_id', 'user_id', 'created_at'], 'integer'],
            [['content'], 'string'],
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
            'note_id' => 'Note ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'user_id']);
    }

    public static function create($note_id, $content)
    {
        $model = self::find()->where(['note_id'=>$note_id, 'content'=>$content])->one();
        if ($model) {
            return;
        }

        $data = [
            'note_id' => $note_id,
            'content' => $content,
            'user_id' => Yii::$app->user->id
        ];

        $log = new self;
        $log->load($data, '');
        return $log->save();
    }
}
