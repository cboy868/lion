<?php

namespace app\modules\memorial\models;

use app\core\models\Attachment;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Tomb;
use app\modules\user\models\Track;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%memorial}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property string $title
 * @property string $custom_title
 * @property string $cover
 * @property string $intro
 * @property integer $privacy
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $tpl
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Memorial extends \app\core\db\ActiveRecord
{
    const PRIVACY_PUBLIC = 0;
    const PRIVACY_FRIENDS = 1;
    const PRIVACY_PRIVATE = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = -1;
    const STATUS_APPLY = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial}}';
    }

    public static function privacys($privac=null)
    {
        $p =[
            self::PRIVACY_PUBLIC =>'公开',
            self::PRIVACY_PRIVATE =>'私密',
        ];

        if ($privac === null) {
            return $p;
        }

        return $p[$privac];
    }

    public static function statusLabel($status=null)
    {
        $s = [
            self::STATUS_APPLY =>'待审核',
            self::STATUS_ACTIVE => '审核通过'
        ];

        if ($status === null) {
            return $s;
        }

        return $s[$status];
    }

    public function getStatusText()
    {
        return self::statusLabel($this->status);
    }

    public function getPrivacyText()
    {
        return self::privacys($this->privacy);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['user_id', 'tomb_id', 'privacy', 'view_all', 'com_all', 'status', 'updated_at', 'created_at'], 'integer'],
            [['intro', 'tpl'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['thumb'], 'safe']
        ];
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'tomb_id' => '墓位id',
            'title' => '馆名',
            'thumb' => '封面',
            'intro' => '馆介绍',
            'privacy' => '隐私',
            'privacyText' => '隐私',
            'view_all' => '查看次数',
            'com_all' => '评论数',
            'tpl' => '模板',
            'statusText' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '添加时间',
        ];
    }

    // public function beforeSave($insert)
    // {
    //     parent::beforeSave($insert);
    //     // $this->user_id = Yii::$app->user->id;

    //     return true;
    // }

    /**
     * @name 添加纪念馆
     */
    public static function create($user_id, $title, $tomb_id=0)
    {
        $memorial = Memorial::find()->where(['user_id'=>$user_id, 'tomb_id'=>$tomb_id])->one();

        if (!$memorial) {
            $memorial = new self;
            $memorial->user_id = $user_id;
            
            $memorial->tomb_id = $tomb_id;
        }
        $memorial->title = $title;
        $memorial->save();
        return $memorial;
    }

    public static function getMemorialsByUser($user_id)
    {
        return self::find()->where(['status'=>self::STATUS_ACTIVE])
                            ->andWhere(['user_id'=>$user_id])
                            ->all();
    }

    /**
     * @param null $size
     * @return string
     * @name 取缩略图
     */
    public function getCover($size=null)
    {
        return Attachment::getById($this->thumb, $size);
    }

    public function getTomb()
    {
        return $this->hasOne(Tomb::className(),['id'=>'tomb_id']);
    }

    public function getUser()
    {
        return $this->hasOne(\app\modules\user\models\User::className(), ['id'=>'user_id']);
    }

    public function getDeads()
    {
        return $this->hasMany(Dead::className(), ['memorial_id'=>'id'])->andWhere(['status'=>Dead::STATUS_NORMAL]);
    }

    public function getNotAliveDeads()
    {
        return $this->hasMany(Dead::className(), ['memorial_id'=>'id'])
            ->andWhere(['status'=>Dead::STATUS_NORMAL])
            ->andWhere(['is_alive'=>0]);
    }

    public function incrementView()
    {
        $this->view_all++;
        return $this->save();
    }

    public function getThumbImg($size, $default="/static/images/default.png")
    {
        return \app\core\models\Attachment::getById($this->thumb, $size, $default);

    }

    /**
     * @name 脚印
     */
    public function track()
    {
        if (Yii::$app->user->isGuest) {
            return ;
        }
        if (Yii::$app->user->id == $this->user_id) {
            return ;
        }

        Track::create(Track::RES_MEMORIAL, $this->id);
    }

}
