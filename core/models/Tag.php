<?php

namespace app\core\models;

use Yii;
use yii\behaviors\TimestampBehavior;



/**
 * This is the model class for table "{{%tag}}".
 *
 * @property string $id
 * @property string $tag_name
 * @property string $num
 * @property string $created_at
 * @property string $updated_at
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num'], 'integer'],
            [['created_at'], 'safe'],
            [['tag_name'], 'string', 'max' => 255],
            [['tag_name'], 'unique']
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'tag id',
            'tag_name' => 'tag名字',
            'num' => '此tag出现次数',
            'created_at' => '添加时间',
        ];
    }

    /**
     * 添加tag,有则更新，无则新加
     */
    public static function addTag($tag_name)
    {
        $model = self::find()->where(['tag_name'=>$tag_name])->one();
        $now = date('Y-m-d H:i:s');
        if ($model) {
            $model->num++;
            // $model->updated_at = $now;
            $model->save();
        } else {
            $model = new static;
            $model->tag_name = $tag_name;
            $model->num = 1;
            // $model->created_at = $now;
            $model->save();
        }
        return $model;
    }

    /**
     * 找出若干tag, 可用于标签云
     */
    public static function getTags($num)
    {
        return self::find()->orderBy('num DESC')->limit($num)->all();
    }
}
