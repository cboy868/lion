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
class UserUpdate extends User
{

    public function rules()
    {
        return [
            // [['username', 'email'], 'required'],
            [['email'], 'required'],//为了适应没有邮箱的人
            [['status', 'created_at', 'updated_at', 'avatar', 'is_staff', 'category'], 'integer'],
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

}