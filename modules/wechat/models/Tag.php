<?php

namespace app\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "{{%wechat_tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $count
 */
class Tag extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'tag_id','wid'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标签名',
            'count' => '粉丝数',
        ];
    }

    public static function updateCount()
    {
        $list = self::find()->all();
        foreach ($list as $v){
            $v->count = TagRel::find()->where(['wid'=>$v->wid,'tag_id'=>$v->tag_id])->count();
            $v->save();
        }
    }




}
