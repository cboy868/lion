<?php

namespace app\modules\shop\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%shop_note}}".
 *
 * @property integer $id
 * @property integer $mid
 * @property string $intro
 * @property integer $user_id
 * @property string $end
 * @property integer $created_at
 * @property integer $status
 */
class Note extends \app\core\models\Note
{
    
    static $res_name = 'shop';

    public static function all()
    {
        return self::find()->where(['res_name'=>self::$res_name])
                             ->andFilterWhere(['>=' , 'end', date('Y-m-d')])
                             ->andFilterWhere(['<=', 'start', date('Y-m-d')])
                             ->all();
    }


}
