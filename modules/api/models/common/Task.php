<?php

namespace app\modules\api\models\common;

use Yii;
/**
 * This is the model class for table "{{%shop_goods}}".
 *
 * @property integer $updated_at
 */
class Task extends \app\modules\task\models\Task
{
    public function extraFields()
    {
        $req = Yii::$app->request;
        return [
            'tomb' => function($model) use ($req){

                if ($model->res_name == 'tomb') {
                    return Tomb::findOne($model->res_id);
                }
                return [];
            },
        ];
    }

}
