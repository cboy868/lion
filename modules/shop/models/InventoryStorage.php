<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%inventory_storage}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $pos
 * @property integer $op_id
 * @property string $op_name
 * @property string $mobile
 * @property string $thumb
 * @property integer $created_at
 * @property integer $status
 */
class InventoryStorage extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_storage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'op_id'], 'required'],
            [['op_id', 'created_at', 'status'], 'integer'],
            [['name', 'pos', 'op_name', 'thumb'], 'string', 'max' => 200],
            [['mobile'], 'string', 'max' => 15],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    InventorySupplier::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '仓库名',
            'pos' => '位置',
            'op_id' => '管理员',
            'op_name' => '管理员',
            'mobile' => '手机号',
            'thumb' => '仓库图',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }

    public function add($goods_id, $sku_id, $num)
    {

        $rel = InventoryStorageRel::find()
            ->where(['goods_id'=>$goods_id, 'sku_id'=>$sku_id,'status'=>InventoryStorageRel::STATUS_NORMAL])
            ->one();
        if (!$rel) {
            $rel = new InventoryStorageRel();
            $rel->goods_id = $goods_id;
            $rel->sku_id = $sku_id;
            $rel->total = $num;
            $rel->storage_id = $this->id;
        } else {
            $rel->total += $num;
        }

        $rel->save();

    }
}
