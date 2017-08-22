<?php

namespace app\modules\memorial\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class OrderForm extends Model
{

    public $use_time;
    public $num=1;
    public $sku_id;
    public $note;

    public function rules()
    {
        return [
            [['use_time', 'num', 'sku_id'], 'required'],
            [['num', 'sku_id'], 'integer'],
            [['use_time','note'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'use_time' => '日期',
            'num' => '数量',
            'sku_id' => '规格',
            'note' => '留言'
        ];
    }
}
