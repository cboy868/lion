<?php

namespace app\modules\shop\models;

use Yii;
use app\modules\shop\models\Category;
use app\modules\shop\models\AttrVal;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%shop_attr}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $body
 * @property integer $status
 */
class Attr extends \app\core\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DEL    = -1;

    const SPEC_YES = 1;
    const SPEC_NO  = 0;

    const MULTI_YES = 1;
    const MULTI_NO  = 0;
    const MULTI_SELF = 2;//自输入

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_attr}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'status', 'is_multi', 'is_spec'], 'integer'],
            [['type_id', 'name'], 'required'],
            [['body'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => '类型',
            'name' => '属性名',
            'typeName' => '类型名',
            'body' => '简介',
            'status' => '状态',
            'is_multi' => '可选多项',
            'is_spec' => '是否是规格',
            'multi' => '多选',
            'spec' =>'是规格',
            'cate' => '分类'
        ];
    }

    public function getTypeName()
    {
        return $this->type->title;
    }

    public function getMulti()
    {
        $mul = [
            self::MULTI_SELF => '自输入',
            self::MULTI_NO => '否',
            self::MULTI_YES => '是'
        ];

        return $mul[$this->is_multi];
    }

    public function getSpec()
    {
        return $this->is_spec ? '是' : '否';
    }


    public function getType()
    {
        return $this->hasOne(Type::className(),['id'=>'type_id']);
    }

    public function getVals()
    {
        return $this->hasMany(AttrVal::className(), ['attr_id'=>'id']);
    }
    // public function getRel()
    // {
    //     return $this->hasOne(AvRel::className(), ['attr_id'=>'id']);
    // }

    public static function getStatus($status = null)
    {
        $arr = [
            self::STATUS_ACTIVE => '正常',
            self::STATUS_DEL    => '删除'
        ];

        if (is_null($status)) {
            return $arr;
        } else {
            return $arr[$status];
        }
    }

    public static function getValMap($attr_id)
    {
        $vals = AttrVal::find()->where(['attr_id'=>$attr_id, 'status'=>AttrVal::STATUS_ACTIVE])->orderBy('val asc')->asArray()->all();

        $vals = ArrayHelper::index($vals, 'id', 'v_cate');
        $result = [];

        $v_cates = ValCategory::find()->asArray()->all();
        $v_cates = ArrayHelper::map($v_cates, 'id', 'name');
        $v_cates[0] = '';

        foreach ($vals as $k => &$v) {
            $k = empty($k) ? 0 : $k;
            $result[$v_cates[$k]] = ArrayHelper::map($v, 'id', 'val');
        }unset($v);

        return $result;
    }

}
