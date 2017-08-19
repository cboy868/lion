<?php

namespace api\common\models\memorial;

use app\core\helpers\ArrayHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
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
class Pray extends \api\common\models\ActiveRecord
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
            [['msg'], 'string','max' => 100, 'min'=>2],
            [['type'], 'string', 'max' => 200],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'memorial_id' => 'Memorial ID',
            'type' => '纪念类型',
            'msg' => '消息',
            'order_id' => '订单',
            'created_at' => '添加时间',
        ];
    }

    public static function prayCount($memorial_id, $types=[])
    {
        $list = self::find()->where(['memorial_id'=>$memorial_id])
                            ->andFilterWhere(['type'=>$types])
                            ->groupBy('type')
                            ->select(['COUNT(*) AS num', 'type'])
                            ->asArray()
                            ->all();

        return $list;
    }
}
