<?php

namespace app\modules\api\models\common;

use app\core\models\Attachment;
use app\modules\grave\models\Dead;
use app\modules\grave\models\Tomb;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%memorial}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tomb_id
 * @property string $title
 * @property string $custom_title
 * @property string $cover
 * @property string $intro
 * @property integer $privacy
 * @property integer $view_all
 * @property integer $com_all
 * @property integer $tpl
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Memorial extends \app\modules\memorial\models\Memorial
{


    public function fields()
    {
        $fields = parent::fields();
        $other = [
            'add_date' => function($model){
                return date('Y-m-d H:i:s', $model->created_at);
            },
            // 字段名为"email", 对应的属性名为"email_address"
            //参数 cover-size=50x50&
            'cover' => function($model){
                $size = Yii::$app->request->get('thumbSize');
                if ($size) {
                    return self::$base_url . $model->getCover($size);
                }
                return self::$base_url . $model->cover;
            },

        ];

        $fields = array_merge($fields, $other);

        unset($fields['thumb']);
        unset($fields['status']);

        return $fields;
    }


}
