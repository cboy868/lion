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

    public function fields()
    {

        $fields = parent::fields();
        $other = [
            'add_date' => function($model){
                return date('Y-m-d H:i', $model->created_at);
            },
        ];

        $fields = array_merge($fields, $other);

        return $fields;

    }

}
