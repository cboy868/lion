<?php

namespace app\core\models;

use app\core\base\Pagination;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\user\models\User;
/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $from
 * @property integer $to
 * @property string $res_name
 * @property integer $res_id
 * @property integer $pid
 * @property string $content
 * @property integer $privacy
 * @property integer $status
 * @property integer $created_at
 */
class Comment extends \app\core\db\ActiveRecord
{

    const STATUS_DRAFT = 1;//待审
    const STATUS_DELETE = -1;//删除
    const STATUS_PUBLISH = 2;//发布

    const PRIVACY_PUBLIC = 1;//公开
    const PRIVACY_PRIVATE = 2;//私有,悄悄话

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to', 'res_id', 'pid', 'privacy', 'status', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['content', 'to', 'res_name', 'res_id', 'privacy'], 'required'],
            [['res_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'to' => 'To',
            'res_name' => 'Res Name',
            'res_id' => 'Res ID',
            'pid' => 'Pid',
            'content' => 'Content',
            'privacy' => 'Privacy',
            'status' => 'Status',
            'created_at' => 'Created At',
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

    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id'=>'from']);
    }

    public static function getByRes($res_name, $res_id, $limit=20)
    {
        $query = self::find()->where(['status'=>self::STATUS_NORMAL])
                            ->andWhere(['res_name'=>$res_name, 'res_id'=>$res_id]);

        $cnt = $query->count();
        $pagination = new Pagination(['totalCount'=>$cnt, 'pageSize'=>$limit]);
        $list = $query->orderBy('id desc')
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();

        return ['list'=>$list, 'pagination'=>$pagination];


    }

    public static function create($res_name, $res_id, $content, $pid=0, $privacy, $to)
    {
        $comment = new self();
        $comment->res_name = $res_name;
        $comment->res_id = $res_id;
        $comment->content = $content;
        $comment->pid =$pid;
        $comment->privacy = $privacy;
        $comment->from = Yii::$app->user->id;
        $comment->to = $to;
        return $comment->save();

    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            // $this->from = isset(Yii::$app->user->id) ? Yii::$app->user->id : 0;
            // $this->status = self::STATUS_DRAFT;
            return true;
        }

        return false;
        
    }


}
