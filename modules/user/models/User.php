<?php
namespace app\modules\user\models;

use app\core\helpers\ArrayHelper;
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
class User extends \app\core\models\User
{

    const STAFF_AGENT = 2;//业务员
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
            [['status', 'created_at', 'updated_at', 'avatar', 'is_staff', 'category'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['mobile',], 'string', 'max' => 15, 'min'=>8],
            [['auth_key', 'py'], 'string', 'max' => 32],
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
            'is_staff' => '是否是员工',
            'category' => '办事处',
            'cate.title' => '办事处'
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

        return false;
    }

    /**
     * @name 所有员工
     */
    public static function staffs()
    {
        return self::find()->where(['status'=>self::STATUS_ACTIVE, 'is_staff'=>self::STAFF_YES])->all();
    }

    public static function agents()
    {
        return self::find()->where(['status'=>self::STATUS_ACTIVE, 'is_staff'=>self::STAFF_AGENT])->all();
    }

    public static function noStaffs()
    {
        return self::find()->where(['status'=>self::STATUS_ACTIVE, 'is_staff'=>self::STAFF_NO])->all();
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
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

    public function isStaff()
    {
        return $this->is_staff ? true : false;
    }

    public static function getRoleUsers($role_name)
    {

        $auth = Yii::$app->authManager;

        if (is_array($role_name)) {
            $users = [];
            foreach ($role_name as $k => $v) {
                $user_id = $auth->getUserIdsByRole($v);

                $tmp = User::find()->where(['id'=>$user_id])
                    ->andWhere(['status'=>User::STATUS_ACTIVE])
                    ->select(['id', 'username'])
                    ->asArray()
                    ->all();

                $users = array_merge($users, $tmp);
            }
        } else if (is_string($role_name)) {


            $user_id = $auth->getUserIdsByRole($role_name);

            $users = User::find()->where(['id'=>$user_id])
                ->andWhere(['status'=>User::STATUS_ACTIVE])
                ->select(['id', 'username'])
                ->asArray()
                ->all();

        }


        $users = ArrayHelper::map($users, 'id', 'username');
        return $users;
    }

    public static function getGuides()
    {
        $guide = Yii::$app->getModule('grave')->params['role']['guide'];
        return self::getRoleUsers($guide);
    }

    
}