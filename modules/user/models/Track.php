<?php

namespace app\modules\user\models;

use app\core\helpers\Url;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%user_track}}".
 *
 * @property integer $id
 * @property integer $res_id
 * @property string $res_name
 * @property integer $user_id
 * @property integer $y
 * @property integer $m
 * @property integer $d
 * @property integer $h
 * @property integer $w
 * @property string $ip
 * @property integer $created_at
 */
class Track extends \app\core\db\ActiveRecord
{

    const RES_MEMORIAL = 'memorial';
    const RES_BLOG = 'blog';
    const RES_NEWS = 'news';
    const RES_PROFILE = 'profile';
    const RES_ALBUM = 'album';
    const RES_ARCHIVE = 'archive';
    const RES_MISS = 'miss';


    public static function res($res_name = null)
    {
        $r = [
            self::RES_BLOG => '博客',
            self::RES_MEMORIAL => '纪念馆',
            self::RES_ALBUM => '相册',
            self::RES_PROFILE => '个人中心',
            self::RES_NEWS => '新闻'
        ];

        if ($res_name === null) {
            return $r;
        }

        return isset($r[$res_name]) ? $r[$res_name] : '';
    }

    public function getRes()
    {
        return self::res($this->res_name);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_track}}';
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
    public function rules()
    {
        return [
            [['res_id', 'res_name', 'user_id'], 'required'],
            [['res_id', 'user_id', 'y', 'm', 'd', 'h', 'w', 'created_at'], 'integer'],
            [['res_name'], 'string', 'max' => 20],
            [['ip'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'res_id' => '资源id',
            'res_name' => '资源类型',
            'user_id' => 'User ID',
            'y' => '来访年份',
            'm' => '来访月份',
            'd' => 'D',
            'h' => 'H',
            'w' => '来访周数',
            'ip' => 'Ip地址',
            'created_at' => '访问时间',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }


    public static function create($res_name, $res_id)
    {
        $uid = Yii::$app->user->id;

        $filter = [
            'user_id' => $uid,
            'res_name' => $res_name,
            'res_id' => $res_id
        ];

        $data = [
            'ip' =>Yii::$app->request->getUserIP(),
            'y' => date('Y'),
            'm' => date('m'),
            'd' => date('d'),
            'w' => date('W'),
            'h' => date('H'),
            'created_at' => time()
        ];

        $model = self::find()->where($filter)->one();
        if (!$model) {
            $model = new self;
            $model->load($filter, '');
        }
        $model->load($data, '');

        return $model->save();
    }

    /**
     * @name 取资源地址
     */
    public function getResUrl()
    {
        switch ($this->res_name) {
            case 'blog':
                return Url::toRoute(['/blog/home/default/view', 'id'=>$this->res_id], true);
            case 'memorial':
                return Url::toRoute(['/memorial/home/hall/index', 'id'=>$this->res_id], true);
            case 'news':
                return Url::toRoute(['/news/home/default/view', 'id'=>$this->res_id]);
            case 'album':
                return Url::toRoute(['/blog/home/album/photos', 'id'=>$this->res_id]);
            case 'profile':
                return Url::toRoute(['/user/home/profile/index', 'id'=>$this->res_id]);
            default:
                return false;
        }
    }
}
