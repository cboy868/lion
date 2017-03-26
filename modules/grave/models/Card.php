<?php

namespace app\modules\grave\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%grave_card}}".
 *
 * @property integer $id
 * @property integer $tomb_id
 * @property string $start
 * @property string $end
 * @property integer $total
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Card extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tomb_id', 'start', 'end'], 'required'],
            [['tomb_id', 'total', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['start', 'end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tomb_id' => '墓位id',
            'start' => '起始',
            'end' => '截止',
            'total' => '总续费年数',
            'created_by' => '添加人',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
            ]
        ];
    }

    public function getBy()
    {
        return $this->hasOne(\app\modules\user\models\User::className(),['id'=>'created_by']);
    }

    public function getTomb()
    {
        return $this->hasOne(\app\modules\grave\models\Tomb::className(),['id'=>'tomb_id']);
    }

    public function getRels()
    {
        return $this->hasMany(CardRel::className(), ['card_id' => 'id'])->orderBy('id asc');
    }
}
