<?php

namespace api\common\models\memorial;

use app\core\models\Attachment;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Tomb;
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
class Memorial extends \api\common\models\ActiveRecord
{
    const PRIVACY_PUBLIC = 0;
    const PRIVACY_FRIENDS = 1;
    const PRIVACY_PRIVATE = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial}}';
    }


    public function fields()
    {
        $fields = parent::fields();
        $other = [
            'add_date' => function($model){
                return date('Y-m-d H:i:s', $model->created_at);
            },
            // 字段名为"email", 对应的属性名为"email_address"
            //参数 cover-size=50x50&
            'cover' => function($model){
                $size = Yii::$app->request->get('thumbSize');
                if ($size) {
                    return self::BASE_URL . $model->getCover($size);
                }
                return self::BASE_URL . $model->cover;
            },

        ];

        $fields = array_merge($fields, $other);

        unset($fields['thumb']);
        unset($fields['status']);

        return $fields;
    }

    /**
     * @return array
     * 参数 expand=images&image-size=100x100
     */
//    public function extraFields()
//    {
//        $req = Yii::$app->request;
//        return [
//            'image' => function($model) use ($req){
//                if ($model->type == self::TYPE_IMAGE) {
//                    $photos = NewsPhoto::find()->where(['news_id'=>$model->id, 'status'=>NewsPhoto::STATUS_ACTIVE])
//                        ->all();
//                    $images = [];
//                    $img_size = $req->get('image-size');
//                    $size = $img_size ? $img_size : null;
//                    foreach ($photos as $v) {
//                        $images[$v['id']] = self::BASE_URL . NewsPhoto::getById($v['id'], $size);
//                    }
//                    return $images;
//                }
//                return [];
//            },
//        ];
//    }

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
            'intro' => '生平介绍',
            'privacy' => '隐私',
            'view_all' => '查看次数',
            'com_all' => '评论数',
            'tpl' => '模板',
            'status' => '状态',
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

    public function getDeads()
    {
        return $this->hasMany(Dead::className(), ['memorial_id'=>'id'])->andWhere(['status'=>Dead::STATUS_NORMAL]);
    }

    public function incrementView()
    {
        $this->view_all++;
        return $this->save();
    }

}
