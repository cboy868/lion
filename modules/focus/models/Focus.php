<?php

namespace app\modules\focus\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\focus\models\Category;
use app\core\models\Attachment;
/**
 * This is the model class for table "{{%focus}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $link
 * @property string $intro
 * @property string $image
 * @property integer $category_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class Focus extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = -1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%focus}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['id', 'category_id', 'status'], 'integer'],
            [['intro'], 'string'],
            [['link'], 'url'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'link'], 'string', 'max' => 255],
            [['image'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'link' => '链接',
            'intro' => '描述',
            'image' => '图片',
            'category_id' => '分类ID',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public static function getStatus($status=null)
    {
        $arr = [
            self::STATUS_DELETE => '禁用',
            self::STATUS_ACTIVE => '正常'
        ];

        if (isset($status) && array_key_exists($status, $arr)) {
            return $arr[$status];
        }
        return $arr;
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id'=>'category_id']);
    }

    public function updateCategoryThumb()
    {
        $category = $this->category;

        if (!$category->thumb) {
            $category->thumb = $this->image;
            $category->save();
        }

        return true;
    }

    public static function getFocusByCategory($category, $rows=5, $size=null)
    {

        $list = self::find()->where(['category_id'=>$category, 'status'=>self::STATUS_ACTIVE])
                            ->limit($rows)
                            ->orderBy('sort asc')
//                            ->asArray()
                            ->all();
        $result = [];
        foreach ($list as $k => $v) {
            $dir = dirname($v['image']);
            $filename = basename($v['image']);
            // $v['image'] = $dir . '/' . $size . "@" . $filename;

            $result[$k] = $v->toArray();

            $result[$k]['cover'] = Attachment::getBySrc($v['image'], $size);
        };

        return $result;
    }

    public function getImg($type=null)
    {
        if ($type) {
            $path = dirname($this->image);
            $filename = basename($this->image);
            return $path . '/' . $type . '@' . $filename;
        }

        return $this->image;
    }
}
