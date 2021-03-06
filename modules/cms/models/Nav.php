<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%cms_nav}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $show
 * @property integer $sort
 * @property integer $created_at
 */
class Nav extends \app\core\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cms_nav}}';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    Contact::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['show', 'sort', 'created_at'], 'integer'],
            [['name'], 'required'],
            [['name', 'url', 'title', 'keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名',
            'url' => '地址',
            'title' => '标题',
            'keywords' => '关键词',
            'description' => '描述',
            'show' => '是否显示',
            'sort' => '排序',
            'created_at' => 'Created At',
        ];
    }

    public static function navs1()
    {
        return self::find()->where(['show'=>1])->orderBy('sort asc')->asArray()->all();
    }
	
	public static function navs()
    {
        if (Yii::$app->params['i18n']['flag']) {
            $items = self::find()->where(['show'=>1])->orderBy('sort asc')->asArray()->all();

            $lg = LgNav::find()->where(['language'=>Yii::$app->language])
                ->indexBy('nav_id')
                ->asArray()
                ->all();

            foreach ($items as &$item) {
                if (!isset($lg[$item['id']])) {continue;}

                $item['title'] = $lg[$item['id']]['title'] ?
                    $lg[$item['id']]['title'] : $item['title'];
                $item['keywords'] = $lg[$item['id']]['keywords'] ?
                    $lg[$item['id']]['keywords'] : $item['keywords'];
                $item['description'] = $lg[$item['id']]['description'] ?
                    $lg[$item['id']]['description'] : $item['description'];

            }unset($item);


            return $items;


        } else {
            return self::find()->where(['show'=>1])->orderBy('sort asc')->asArray()->all();
        }
    }

    public static function nav($name)
    {
        // return self::find()->where(['name'=>$name])
    }

}
