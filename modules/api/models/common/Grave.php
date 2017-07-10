<?php

namespace app\modules\api\models\common;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;
use app\core\helpers\ArrayHelper;
use app\modules\shop\models\Sku;
/**
 * This is the model class for table "{{%shop_goods}}".
 *
 * @property integer $updated_at
 */
class Grave extends \app\modules\grave\models\Grave
{
    public function fields()
    {
        $fields = parent::fields();

        $other = [
            //参数 cover-size=50x50&
            'cover' => function($model){
                $size = Yii::$app->request->get('cover-size');
                return self::$base_url . $model->getThumb($size);
            },
            'cnt' => function($model){
                $cnt = $model->staCount();
                $total = array_sum($cnt);

                $data = [
                    'not' => $cnt[\app\modules\grave\models\Tomb::STATUS_EMPTY],
                    'yet' => $total - $cnt[\app\modules\grave\models\Tomb::STATUS_EMPTY]
                ];

                return $data;
            }

        ];

        $fields = array_merge($fields, $other);

        unset($fields['thumb'], $fields['status']);

        return $fields;

    }

}
