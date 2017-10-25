<?php

namespace app\modules\api\models\common;

use Yii;
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
                if (!$cnt) {
                    return [
                        'not' =>0,
                        'yet' => 0
                    ];
                }

                $total = array_sum($cnt);

                $data = [
                    'not' => isset($cnt[\app\modules\grave\models\Tomb::STATUS_EMPTY]) ?
                        $cnt[\app\modules\grave\models\Tomb::STATUS_EMPTY] : 0,
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
