<?php

namespace app\modules\sys\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%image_config}}".
 *
 * @property integer $id
 * @property string $res_name
 * @property integer $is_thumb
 * @property integer $thumb_mode
 * @property string $thumb_config
 * @property integer $is_water
 * @property string $water_image
 * @property string $water_text
 * @property integer $water_opacity
 * @property integer $water_pos
 * @property integer $created_at
 */
class ImageConfig extends \app\core\db\ActiveRecord
{

    public static $resname = [
        'common' => '公共',
        'goods' => '商品',
        'focus' => '焦点图',
        'post'  => '文章',
        'album' => '图集',
        'avatar'=> '头像'
    ];

    public static $water_pos = [
        -1 => '关闭',
        0 => '随机',
        1 => '#1',
        2 => '#2',
        3 => '#3',
        4 => '#4',
        5 => '#5',
        6 => '#6',
        7 => '#7',
        8 => '#8',
        9 => '#9'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_thumb', 'thumb_mode', 'water_mod', 'water_opacity', 'water_pos', 'created_at'], 'integer'],
            [['thumb_config'], 'string'],
            [['res_name'], 'required'],
            [['res_name'], 'string', 'max' => 100],
            [['water_image', 'water_text'], 'string', 'max' => 255],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'res_name' => '类型',
            'is_thumb' => '是否缩略',
            'thumb_mode' => '缩略方式',
            'thumb_config' => '缩略配置',
            'water_mod' => '水印形式',
            'water_image' => '水印图片',
            'water_text' => '水印文字',
            'water_opacity' => '不透明度',
            'water_pos' => '水印位置',//0随机,1-9 9宫格 
            'created_at' => '添加时间',
        ];
    }

    public static function writeFile()
    {
        $list = self::find()->asArray()->all();

        $config = [];

        foreach ($list as $v) {
            $config['image'][$v['res_name']] = [
                'water' => $v['water_pos'] != -1 ? 1 : 0,
                'water_mod' => $v['water_mod'] == 1 ? 'image' : 'text',
                'water_image' => $v['water_image'],
                'water_text'  => $v['water_text'],
                'water_pos'   => $v['water_pos'],
                // 'thumb' => explode(',', $v['thumb_config'])
            ];


            if ($v['thumb_config']) {
                $config['image'][$v['res_name']]['thumb'] = explode(',', $v['thumb_config']);
            }
        };


        $content = var_export($config, true);
        $content = '<?php return ' . $content . ';';

        $path = Yii::getAlias('@app/config/thumb.php');
        @file_put_contents($path, $content);
    }
}

