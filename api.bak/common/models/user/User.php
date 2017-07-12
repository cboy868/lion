<?php

namespace api\common\models\user;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;
use app\core\models\Attachment;
use api\common\models\ActiveRecord;


class User extends ActiveRecord implements IdentityInterface,RateLimitInterface
{
    const STATUS_DELETED = -1;
    const STATUS_ACTIVE = 10;
    const STATUS_REGISTER = 0;//注册待激活状态

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function fields()
    {

        $fields = parent::fields();
        $other = [
            //参数 cover-size=50x50&
            'avatar' => function($model){
                $size = Yii::$app->request->get('avatarSize');
                if ($size) {
                    return self::BASE_URL . $model->getAvatar($size);
                }
                return self::BASE_URL . $model->avatar;
            },

        ];

        $fields = array_merge($fields, $other);

        unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);
        unset($fields['status']);

        return $fields;

    }

    public function getAddition()
    {
        return $this->hasOne(Addition::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getAvatar($size=null, $default=null)
    {
        return Attachment::getById($this->avatar, $size, $default);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['api_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    // 返回某一时间允许请求的最大数量，比如设置10秒内最多5次请求（小数量方便我们模拟测试）
    public  function getRateLimit($request, $action){  
         return [5, 10];  
    }
     
    // 回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时
    public  function loadAllowance($request, $action){  
         return [$this->allowance, $this->allowance_updated_at];  
    }  
     
    // 保存允许剩余的请求数和当前的UNIX时间戳
    public  function saveAllowance($request, $action, $allowance, $timestamp){ 
        $this->allowance = $allowance;  
        $this->allowance_updated_at = $timestamp;  
        $this->save();  
    }

    


}