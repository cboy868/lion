<?php

namespace app\modules\user\models;

use Yii;
use app\modules\user\models\Addition;
use app\core\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%user_log}}".
 *
 * @property integer $user_id
 * @property string $login_date
 * @property string $login_ip
 */
class Log extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['login_date'], 'safe'],
            [['login_ip'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'login_date' => 'Login Date',
            'login_ip' => 'Login Ip',
        ];
    }


    public static function getLast()
    {
        $user_id = Yii::$app->user->id;

        return self::find()->where(['user_id'=>$user_id])->orderBy('login_date desc')->one();
    }

    public static function create()
    {
        $model = new self();
        $model->user_id = Yii::$app->user->id;

        $model->login_ip = Yii::$app->request->userIP;
        $model->login_date = date('Y-m-d H:i:s');
        $model->save();

        $addition = Addition::find()->where(['user_id'=>Yii::$app->user->id])->one();
        if (!$addition) {
            $addition = new Addition();
            $addition->user_id = Yii::$app->user->id;
            $addition->logins = 1;
        } else {
            $addition->logins += 1;
        }

        $addition->save();

    }


    /**
     * @name 获取僵尸用户, $time默认半年前 185天前
     */
    public static function nonActiveUsers($time=185, $logins=1)
    {

        $us = User::find()->where(['status'=>User::STATUS_ACTIVE, 'is_staff'=> User::STAFF_NO])
                          ->andWhere(['<', 'created_at', time()-$time*24*3600])
                          ->select(['id'])
                          ->asArray()
                          ->all();
        $us = ArrayHelper::getColumn($us, 'id');

        $loguser = self::find()->where(['user_id'=>$us])->asArray()->all();
        $loguser = ArrayHelper::getColumn($loguser, 'user_id');


        $del = [];
        foreach ($us as $k => $v) {
            if (!in_array($v, $loguser)) {
                array_push($del, $v);
            }
        }

        //以下是有登录，但时久和登录次数少的
        $users = self::find()->select(['user_id', ' substring_index(group_concat(login_date order by login_date desc),",",1) as login_date'])
                             ->groupBy('user_id')
                             ->asArray()
                             ->all();
        $non_active = [];
        foreach ($users as $k => $v) {
            if (strtotime($v['login_date']) < strtotime('-' . $time . ' day')) {
                array_push($non_active, $v['user_id']);
            }
        }

        $result = [];
        if (count($non_active) > 0) {
            $add = Addition::find()->where(['user_id'=>$non_active])
                                 ->andWhere(['<', 'logins', $logins])
                                 ->select(['user_id'])
                                 ->asArray()
                                 ->all();
            $result = ArrayHelper::getColumn($add, 'user_id');
        }
        

        return array_merge($result, $del);
    }

}
