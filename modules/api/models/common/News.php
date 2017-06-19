<?php

namespace app\modules\api\models\common;

use Yii;
use yii\behaviors\TimestampBehavior;


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
class News extends \app\modules\news\models\News
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
            },
            'body' => function($model){
                return $model->type == self::TYPE_TEXT ? $model->body->body : '';
            },

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
                if ($model->type == self::TYPE_IMAGE) {
                    $photos = NewsPhoto::find()->where(['news_id'=>$model->id, 'status'=>NewsPhoto::STATUS_ACTIVE])
                        ->all();
                    $images = [];
                    $img_size = $req->get('image-size');
                    $size = $img_size ? $img_size : null;
                    foreach ($photos as $v) {
                        $images[$v['id']] = self::BASE_URL . NewsPhoto::getById($v['id'], $size);
                    }
                    return $images;
                }
                return [];
            },
        ];
    }
}
