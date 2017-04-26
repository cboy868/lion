<?php

namespace app\core\models;

use Yii;
use yii\behaviors\TimestampBehavior;

use app\core\traits\TreeTrait;
use app\core\models\Attachment;
/**
 * This is the model class for table "{{%shop_category}}".
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
class Category extends \app\core\db\ActiveRecord
{
    use TreeTrait;

    const STATUS_ACTIVE = 1;
    const STATUS_DEL = -1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'level', 'sort', 'is_leaf', 'created_at', 'status'], 'integer'],
            [['body', 'seo_description'], 'string'],
            [['name'], 'required'],
            [['code', 'name', 'seo_title', 'seo_keywords', 'thumb'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '父id',
            'level' => '层级',
            'code' => 'Code',
            'name' => '分类名称',
            'thumb' => '封面',
            'body' => '描述',
            'seo_title' => 'Seo 标题',
            'seo_keywords' => 'Seo 关键词',
            'seo_description' => 'Seo 描述',
            'created_at' => '添加时间',
            'status' => '状态',
        ];
    }

    public function getCover($size='')
    {
        return Attachment::getById($this->thumb, $size);
    }

    /**
     * @name 取出所有可做父组的节点，用于父级选择
     */
    public static function pids($except=null)
    {
        $query = self::find()->where(['status'=>self::STATUS_NORMAL]);

        if ($except) {
            $query->andWhere(['<>', 'id', $except]);
        }

        $records = $query->asArray()->all();
        $tree = ArrayHelper::recursion($records, 0, 2);

        $result = [];
        foreach ($tree as $k => $v) {
            $result[$v['id']] = $v['html'] . $v['name'];
        }

        return $result;
    }

    
}
