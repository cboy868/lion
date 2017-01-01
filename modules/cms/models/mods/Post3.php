<?php

namespace app\modules\cms\models\mods;

use app\modules\mod\models\Field;
use app\core\helpers\ArrayHelper;


class Post3 extends \app\modules\cms\models\Post
{
    public $fields;

    public function init()
    {

        $mod = \Yii::$app->getRequest()->get('mod');
        $fields = Field::find()->where(['table'=>"post_3"])->asArray()->all();

        $this->fields = ArrayHelper::map($fields, 'name', 'title');
        parent::init();

    }

    public static function tableName()
    {
        return "{{%post_3}}";
    }


    public function attributeLabels()
    {
        $attr = parent::attributeLabels();

        return $attr +$this->fields;
    }


    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules, [[array_keys($this->fields), 'safe']]);
    }
}