<?php

namespace app\modules\cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%links}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property string $logo
 * @property string $intro
 * @property integer $status
 * @property integer $created_at
 */
class Links extends \app\core\db\ActiveRecord
{

    public $logot;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%links}}';
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
            [['intro'], 'string'],
            [['status', 'created_at'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
            [['link', 'logot'], 'string', 'max' => 255],
            [['logo', 'logot'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名字',
            'link' => '链接',
            'logo' => 'Logo',
            'intro' => '介绍',
            'status' => '状态',
            'created_at' => '添加时间',
        ];
    }

    public function getCover($size, $default="/static/images/up.png")
    {
        if (isset($this->logo) && !empty($this->logo)) {
            return \app\core\models\Attachment::getById($this->logo, $size, $default);
        }

        return '';
    }

}
