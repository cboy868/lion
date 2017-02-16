<?php
namespace app\modules\user\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use app\core\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\core\models\Attachment;
use app\modules\user\models\Addition;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = -1;
    const STATUS_ACTIVE = 10;
    const STATUS_REGISTER = 0;//注册待激活状态

    const STAFF_YES = 1;
    const STAFF_NO  = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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


    public function rules()
    {
        return [
            // [['username', 'email'], 'required'],
            [['username'], 'required'],//为了适应没有邮箱的人
            [['status', 'created_at', 'updated_at', 'avatar', 'is_staff'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['mobile',], 'string', 'max' => 15, 'min'=>8],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email','mobile'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_REGISTER],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_REGISTER]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'email' => '邮箱',
            'status' => '状态',
            'avatar' => '头像',
            'mobile' => '联系方式',
            'created_at' => '添加时间',
            'updated_at' => '添加时间',
            'is_staff' => '是否是员工'
        ];
    }

    public function createUser($pwd="999999", $is_staff=self::STAFF_NO)
    {
        $this->setPassword($pwd);
        $this->generateAuthKey();
        $this->is_staff = $is_staff;

        if ($this->save()) {
            return $this;
        }

        return fasle;
    }


    // public static function createUser($username, $email='', $pwd='999999', $is_staff=self::STAFF_NO)
    // {
    //     $user = new self;
    //     $user->username = $username;
    //     $user->setPassword($pwd);
    //     $user->generateAuthKey();
    //     $user->is_staff = $is_staff;
    //     $user->email = $email;
    //     if ($user->save()) {
    //         return $user;
    //     }
    //     return fasle;
    // }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
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
     * @return boolean
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

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
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

    public function getAvatar($size, $default=null)
    {
        return Attachment::getById($this->avatar, $size, $default);
    }

    public function getAddition()
    {
        return $this->hasOne(Addition::className(), ['user_id' => 'id']);
    }
    public static function drop($user_id)
    {
        $model = self::findOne($user_id);
        if (!$model) {
            return;
        }
        $model->status = self::STATUS_DELETED;
        $model->save();
    }
    public static function dropBatch($users)
    {
        $connection = Yii::$app->db;
        $connection->createCommand()
                    ->update(
                        self::tableName(),
                        ['status'=>self::STATUS_DELETED],
                        ['id'=>$users]
                    )->execute();
    }

    
}