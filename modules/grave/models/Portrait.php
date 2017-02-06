<?php

namespace app\modules\grave\models;

use Yii;

/**
 * This is the model class for table "{{%grave_portrait}}".
 *
 * @property integer $id
 * @property integer $guide_id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property string $title
 * @property integer $goods_id
 * @property integer $order_id
 * @property integer $order_rel_id
 * @property string $dead_ids
 * @property string $photo_original
 * @property string $photo_processed
 * @property integer $confrim_by
 * @property string $confirm_at
 * @property string $photo_confirm
 * @property string $use_at
 * @property string $up_at
 * @property integer $notice_id
 * @property integer $type
 * @property string $note
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Portrait extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grave_portrait}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guide_id', 'user_id', 'tomb_id', 'updated_at', 'created_at'], 'required'],
            [['guide_id', 'user_id', 'tomb_id', 'goods_id', 'order_id', 'order_rel_id', 'confrim_by', 'notice_id', 'type', 'status', 'updated_at', 'created_at'], 'integer'],
            [['confirm_at', 'use_at', 'up_at'], 'safe'],
            [['note'], 'string'],
            [['title', 'photo_confirm'], 'string', 'max' => 200],
            [['dead_ids', 'photo_original', 'photo_processed'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guide_id' => 'Guide ID',
            'user_id' => 'User ID',
            'tomb_id' => 'Tomb ID',
            'title' => 'Title',
            'goods_id' => 'Goods ID',
            'order_id' => 'Order ID',
            'order_rel_id' => 'Order Rel ID',
            'dead_ids' => 'Dead Ids',
            'photo_original' => 'Photo Original',
            'photo_processed' => 'Photo Processed',
            'confrim_by' => 'Confrim By',
            'confirm_at' => 'Confirm At',
            'photo_confirm' => 'Photo Confirm',
            'use_at' => 'Use At',
            'up_at' => 'Up At',
            'notice_id' => 'Notice ID',
            'type' => 'Type',
            'note' => 'Note',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
