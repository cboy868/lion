<?php

namespace api\common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;
use app\core\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%shop_goods}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $thumb
 * @property string $intro
 * @property string $unit
 * @property string $price
 * @property integer $num
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Goods extends ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DEL    = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'thumb', 'num', 'status', 'created_at', 'updated_at'], 'integer'],
            [['intro', 'skill', 'serial'], 'string'],
            [['price', 'original_price'], 'number'],
            // ['name', 'unique',  'message' => '此菜品已存在，请确定'],
            // [['name', 'price'], 'required'],
            [['name'], 'required'],
            [['name','pinyin'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 100]
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类',
            'name' => '商品名称',
            'thumb' => '商品封面',
            'intro' => '介绍',
            'skill' => '烹饪技巧',
            'unit' => '单位',
            'price' => '价格',//现价,活动,微信价之类
            'original_price' => '原价',
            'num' => '数量',
            'status' => '状态',
            'tags' => '标签/关键词',
            'recommend' => '是否推荐',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'serial' => '序列号',
            'pinyin' =>'拼音首字母'
        ];
    }


    public function getCategory()
    {
        return $this->hasOne(GoodsCategory::className(),['id'=>'category_id']);
    }

    public function getAttach()
    {
        return $this->hasOne(Attachment::className(), ['id'=>'thumb']);
    }

    public function getRecommend()
    {
        return $this->is_recommend ? '是' : '否';
    }


    public function getSku()
    {
        return $this->hasMany(GoodsSku::className(), ['goods_id'=>'id']);
    }

    // public function getTags()
    // {
        
    // }


    // public function getImgs($type='tiny')
    // {
    //     $imgs = $this->getAttach();
    // }

    public function getImgs($thumb=null)
    {
        return AttachmentRel::getByRes('goods', $this->id, $thumb);
    }

    public function getCover($size = '')
    {
        return Attachment::getById($this->thumb, $size);
    }

    public function getAvs()
    {
        return $this->hasMany(GoodsAvRel::className(), ['goods_id'=>'id']);
    }

    public function getAv()
    {

        $attr = [];
        $spec = [];
        foreach ($this->avs as $k => $v) {
            if ($v->attr->is_spec) {
                $spec[] = [
                    'attr_id' => $v->attr_id,
                    'attr_name' => $v->attr->name,
                    'attr_val' => $v->val->val,
                    // 'num'      => $v->num,
                    // 'price'    => $v->price
                ];
            } else {
                $attr[] = [
                    'attr_id' => $v->attr_id,
                    'attr_name' => $v->attr->name,
                    'attr_val' => $v->val->val,
                    // 'num'      => $v->num,
                    'value'    => $v->value
                ];
            }
        }

        $attr = ArrayHelper::index($attr, 'attr_id');

        return ['attr'=>$attr, 'spec'=>$spec];
    }

    public function getAvRels()
    {
        $attr = [];
        $spec = [];
        foreach ($this->avs as $k => $v) {

            $val[$v->attr_id][$v->av_id] = [
                'val' => $v->val->val,
                'id'  => $v->av_id
            ];

            if ($v->attr->is_spec) {
                $spec[$v->attr_id] = [
                    'attr_id' => $v->attr_id,
                    'attr_name' => $v->attr->name,
                    'child' => $val[$v->attr_id],
                ];
            } else {
                $attr[$v->attr_id] = [
                    'attr_id' => $v->attr_id,
                    'attr_name' => $v->attr->name,
                    'child' => $val[$v->attr_id],
                ];
            }
        }

        $attr = ArrayHelper::index($attr, 'attr_id');

        return ['attr'=>$attr, 'spec'=>$spec];
    }

    public static function getThumbs(array $goods_ids, $type="tiny")
    {
        $goods = self::find()->where(['id'=>$goods_ids])->select(['id', 'thumb'])->all();

        $goods_map = [];
        foreach ($goods as $k => $v) {
            $goods_map[$v['id']] = $v->getThumb();
        }

        return $goods_map;
    }

    /**
     * @name 下订单
     */
    public function order($user_id, $extra)
    {
        return Order::createGoods($user_id, $this, $extra);
    }

    public function fields()
    {

        $fields = parent::fields();
        $other = [
            'category_name' => function($model){
                return isset($model->category->name) ? $model->category->name : '';
            },
            'add_date' => function($model){
                return date('Y-m-d H:i:s', $model->created_at);
            },
            // 字段名为"email", 对应的属性名为"email_address"
            //参数 cover-size=50x50&
            'cover' => function($model){
                $size = Yii::$app->request->get('cover-size');
                if ($size) {
                    return self::BASE_URL . $model->getCover($size);
                }
                return self::BASE_URL . $model->cover;
            }

        ];

        $fields = array_merge($fields, $other);

        unset($fields['thumb']);
        unset($fields['sort']);
        unset($fields['status']);

        return $fields;

    }

    /**
     * @return array
     * 参数 expand=images&image-size=100x100
     */
    public function extraFields()
    {
        $req = Yii::$app->request;
        return [
            'image' => function($model) use ($req){
                $img_size = $req->get('image-size');
                $size = $img_size ? $img_size : null;
                $photos = $model->getImgs($size);

                $images = [];
                foreach ($photos as $v) {
                    $images[] = self::BASE_URL . $v['url'];
                }
                return $images;
            },
            'sku' => function($model) {
                return GoodsSku::find()->where(['goods_id'=>$model->id])
                                        ->indexBy('av')
                                        ->asArray()->all();
            },
            'spec' => function($model) {
                return $model->avRels;
            }
        ];
    }



}
