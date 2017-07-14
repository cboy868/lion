<?php

namespace app\modules\api\models\common;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\shop\models\Cart;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 */
class Order extends \app\modules\order\models\Order
{

    /**
     * @return array
     * /**
     * @return array
     * 参数 expand=rels&cover-size=100x100
     */
    public function extraFields()
    {
        $req = Yii::$app->request;
        return [
            'rels' => function($model) use ($req){

                $size = Yii::$app->request->get('relThumbSize');
                $rels = $model->rels;
                $r = [];
                foreach ($rels as $rel) {
                    $r[$rel['id']] = [
                        'title' => $rel->title,
                        'cover' => $rel->goods? self::$base_url . $rel->goods->getCover($size) : ''
                    ];
                }
                return $r;
            },
        ];
    }


}
