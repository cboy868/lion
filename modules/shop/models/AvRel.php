<?php

namespace app\modules\shop\models;

use Yii;
use app\core\helpers\Url;
use app\core\helpers\Html;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%shop_av_rel}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $goods_id
 * @property integer $attr_id
 * @property integer $av_id
 * @property integer $num
 * @property integer $status
 */
class AvRel extends \app\core\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DEL    = -1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_av_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'goods_id', 'attr_id', 'num', 'status'], 'integer'],
            // [['av_id'], 'required'],
            [['av_id'], 'safe']

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类',
            'goods_id' => '商品',
            'attr_id' => '属性名',
            'av_id' => '属性值',
            'num' => 'Num',
            'status' => 'Status',
        ];
    }

    public function getAttr()
    {
        return $this->hasOne(Attr::className(), ['id' => 'attr_id']);
    }

    public function getVal()
    {
        return $this->hasOne(AttrVal::className(), ['id' => 'av_id']);
    }

    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }

    public function getAv($goods_model)
    {
        $attr = [];
        $spec = [];
        foreach ($goods_model->avs as $k => $v) {
            if ($v->attr->is_spec) {
                $spec[] = [
                    'attr_id' => $v->attr_id,
                    'attr_name' => $v->attr->name,
                    'attr_val' => $v->val->val,
                    'num'      => $v->num
                ];
            } else {
                $attr[] = [
                    'attr_id' => $v->attr_id,
                    'attr_name' => $v->attr->name,
                    'attr_val' => $v->val->val,
                    'num'      => $v->num
                ];
            }
        }

        return ['attr'=>$attr, 'spec'=>$spec];
    }

    /**
     * @name 重组post提交过来的数据
     * todo 如果规格选择不全，应该把规格类的全部删掉
     */
    public static function parsePost($category_id, $goods_id)
    {
        $result = [];
        $data = Yii::$app->getRequest()->post('AvRel');

        if (!$data) {
            return [];
        }

        $base = ['category_id'=>$category_id, 'goods_id'=>$goods_id];

        foreach ($data as $k => $v) {

            if (is_array($v)) {
                foreach ($v as $value) {
                    $result[$value] = [
                        'attr_id' => $k,
                        'av_id'   => $value,
                    ] + $base;
                }
            } else {
                if (!$v) continue;
                $result[$v] = [
                    'attr_id' => $k,
                    'av_id'   => $v,
                ] + $base;
            }
            
        }

        return $result;
    }


    public static function getGoodsRel($goods_id)
    {
        $av = self::getRelsByGoods($goods_id);
        $result = [];

        foreach ($av as $k => $v) {
            $result[$v->attr_id] = [
                'attr_id' => $v->attr_id,
                'av_id' => $v->av_id,
                'name' => $v->attr->name,
                'val'  => isset($result[$v->attr_id]['val']) ? $result[$v->attr_id]['val'] . $v->val->val . ',' : $v->val->val . ','
            ];
        }

        return $result;
    }

    /**
     * @name 按商品id 取属性值
     */
    public static function getRelsByGoods($goods_id, $is_array=false)
    {
        $query = self::find()->where(['goods_id'=>$goods_id, 'status'=>self::STATUS_ACTIVE]);

        if ($is_array) {
            $query->asArray();
        }

        return $query->all();
    }

    public static function attrs($category_id, $filters=[])
    {
        $list = self::find()->where(['category_id'=>$category_id])->andFilterWhere(['not in', 'attr_id', $filters])->all();

        $result = [];

        foreach ($list as $k => $v) {

            $val[$v->attr_id][$v->av_id] = [
                'val' => $v->val->val,
                'id'  => $v->av_id,
            ];

            $result[$v->attr_id] = [
                'name' => $v->attr->name,
                'id'   => $v->attr_id,
                "child" => $val[$v->attr_id],
            ];
        }

        $attr_ids = array_keys($result);

        $atrs = Attr::find()->where(['id'=>$attr_ids, 'is_spec'=>1, 'status'=>Attr::STATUS_ACTIVE])->asArray()->all();
        $atrs = ArrayHelper::getColumn($atrs, 'id');

        foreach ($result as $k => $v) {
            if (in_array($k, $atrs)) {
                unset($result[$k]);
            }
        }

        return $result;
    }   

    // public static function filterShicai()
    // {
    //     $list = self::find()->where(['attr_id'=>3])->all();
    //     $cates = \modules\shop\models\ValCategory::find()->asArray()->all();
    //     $cates = ArrayHelper::map($cates, 'id', 'name');



    //     $result = [];

    //     foreach ($list as $k => $v) {

    //         $val[$v->val->v_cate][$v->av_id] = [
    //             'val' => $v->val->val,
    //             'id'  => $v->av_id,
    //         ];

    //         $result[$v->val->v_cate] = [
    //             'name' => $cates[$v->val->v_cate],
    //             // 'id'   => $v->attr_id,
    //             "child" => $val[$v->val->v_cate],
    //         ];
    //     }


    //     $attr_ids = array_keys($result);

    //     $atrs = Attr::find()->where(['id'=>$attr_ids, 'is_spec'=>1, 'status'=>Attr::STATUS_ACTIVE])->asArray()->all();
    //     $atrs = ArrayHelper::getColumn($atrs, 'id');

    //     foreach ($result as $k => $v) {
    //         if (in_array($k, $atrs)) {
    //             unset($result[$k]);
    //         }
    //     }

    //     return $result;
    // }



    public static function attrFilter($text, $attr_id, $av_id, $scheme = false)
    {
       
       $filter = Yii::$app->getRequest()->get('filter');
       $filters = explode(',', $filter);
       if (in_array($av_id, $filters)) {
           return Html::a($text, '#', ['class'=>'button parse-search selected attr-filter', "data-attr"=>$attr_id, "data-av"=>$av_id]);
       }
       return Html::a($text, '#', ['class'=>'button parse-search attr-filter', "data-attr"=>$attr_id, "data-av"=>$av_id]);
    }

    
}
