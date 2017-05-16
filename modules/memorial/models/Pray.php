<?php

namespace app\modules\memorial\models;

use app\core\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "{{%memorial_pray}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $memorial_id
 * @property string $type
 * @property string $msg
 * @property integer $order_id
 * @property integer $created_at
 */
class Pray extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%memorial_pray}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'memorial_id', 'type'], 'required'],
            [['user_id', 'memorial_id', 'order_id', 'created_at'], 'integer'],
            [['msg'], 'string'],
            [['type'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'memorial_id' => 'Memorial ID',
            'type' => '纪念类型',
            'msg' => '留言',
            'order_id' => '订单',
            'created_at' => '添加时间',
        ];
    }

    public static function prayCount($memorial_id)
    {
        $list = self::find()->where(['memorial_id'=>$memorial_id])
                            ->groupBy('type')
                            ->select(['COUNT(*) AS num', 'type'])
                            ->asArray()
                            ->all();

        return $list;
    }
}
