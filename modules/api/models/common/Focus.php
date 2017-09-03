<?php

namespace app\modules\api\models\common;

use Yii;
/**
 *
 */
class Focus extends \app\modules\focus\models\Focus
{
    public function fields()
    {

        $fields = parent::fields();

        $other = [
            'cover' => function($model){
                return self::$base_url . $model->image;
            }

        ];

        $fields = array_merge($fields, $other);

        return $fields;

    }
}
