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
class Tomb extends \app\modules\grave\models\Tomb
{
    public function fields()
    {

        $fields = parent::fields();

        $other = [

            //参数 cover-size=50x50&
            'cover' => function($model){
                $size = Yii::$app->request->get('thumbSize');
                return self::$base_url . $model->getImg($size);
            }

        ];
        $fields = array_merge($fields, $other);
        unset($fields['thumb'], $fields['status']);
        return $fields;

    }

    /**
     * @return array
     * 参数 expand=images&image-size=100x100
     */
    public function extraFields()
    {
        return [
            'card' => function($model) {
                return $model->card;
            },
            'renew_fee' => function($model) {
                return \Yii::$app->getModule('grave')->params['goods']['fee']['renew'];
            },
            'memorial' => function($model) {
                return $model->memorial;
            }
        ];
    }

}
