<?php

namespace app\modules\user\models;

use Yii;
use app\modules\user\models\Addition;

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

}
