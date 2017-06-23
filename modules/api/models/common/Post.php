<?php

namespace app\modules\api\models\common;

use app\modules\cms\models\PostImage;

/**
 * This is the model class for table "{{%post}}".
 * @property PostData[] $postDatas
 */
class Post extends \app\modules\cms\models\Post
{
    public function getCover($size='')
    {
        return PostImage::getById($this->thumb, $size);
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
                    return self::$base_url . $model->getCover($size);
                }
                return self::$base_url . $model->cover;
            }

        ];

        $fields = array_merge($fields, $other);

        unset($fields['thumb']);
        unset($fields['status']);

        return $fields;

    }
}
