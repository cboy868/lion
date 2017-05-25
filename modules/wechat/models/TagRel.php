<?php

namespace app\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "{{%wechat_tag_rel}}".
 *
 * @property integer $tag_id
 * @property integer $user_id
 */
class TagRel extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_tag_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'openid', 'wid'], 'required'],
            [['tag_id'], 'integer'],
            [['openid'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'user_id' => 'User ID',
        ];
    }

    public static function addTagUser($wid, $tag_id, $openids)
    {
        foreach ($openids as $oid)
        {
            $tgr = new self();
            $tgr->wid = $wid;
            $tgr->tag_id = $tag_id;
            $tgr->openid = $oid;
            $tgr->save();
        }

    }

    public function getTagUser($id)
    {

    }
}
