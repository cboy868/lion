<?php

namespace app\modules\api\models\common;

use Yii;
use app\core\models\Attachment;
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
                $size = Yii::$app->request->get('coverSize');
                return self::$base_url . Attachment::getBySrc($model->image, $size);
            }

        ];

        $fields = array_merge($fields, $other);

        return $fields;

    }
}
