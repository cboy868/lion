<?php

namespace app\modules\shop\models;

use Yii;
use app\modules\shop\models\Mix;

/**
 * This is the model class for table "{{%foods_mix_cate}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $level
 * @property string $code
 * @property string $name
 * @property integer $cover
 * @property string $body
 * @property integer $sort
 * @property integer $is_leaf
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $created_at
 * @property integer $status
 */
class MixCate extends \app\core\models\Category
{
    public $covert;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_mix_cate}}';
    }



    public function getMixs()
    {
        return $this->hasMany(Mix::className(), ['cate_id' => 'id']);
    }


}
