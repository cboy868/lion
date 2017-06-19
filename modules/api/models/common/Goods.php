<?php

namespace app\modules\api\models\common;

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
class Goods extends \app\modules\shop\models\Goods
{
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
