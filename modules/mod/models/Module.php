<?php

namespace app\modules\mod\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\core\helpers\FileHelper;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property integer $id
 * @property string $module
 * @property string $name
 * @property string $dir
 * @property string $link
 * @property integer $order
 * @property integer $show
 * @property string $logo
 * @property integer $created_at
 */
class Module extends \yii\db\ActiveRecord
{

    const SHOW_NO = 0;
    const SHOW_YES = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module', 'name'], 'required'],
            [['order', 'show', 'created_at'], 'integer'],
            [['module', 'name', 'dir', 'link', 'logo'], 'string', 'max' => 255],
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

    public function getShowLabel()
    {
        $label = [
            self::SHOW_NO => '否',
            self::SHOW_YES => '是'
        ];

        return $label[$this->show];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module' => '模型',
            'name' => '模块名',
            'dir' => '目录',
            'link' => '连接地址',
            'order' => '排序',
            'show' => '是否显示',
            'showLabel' => '显示',
            'logo' => 'Logo',
            'created_at' => '添加时间',
        ];
    }


//     public static function createModel($model, $mod)
//     {

//         $ori_table = $model::tableName();
//         $table = str_replace('}}', '_' . $mod . '}}', $ori_table);


//         $class = '\\' . $model::className();

//         $table_name = $class::getTableSchema()->name . '_' . $mod;

//         $c = Yii::getAlias('@'.str_replace('\\', '/', $model));
//         $dir = dirname($c) . '/mods/';

//         $class = basename($c) . $mod;
//         $filename = $class . '.php';

//         $data = <<<'CLASS'
// <?php

// namespace app\modules\cms\models\mods;

// use app\modules\mod\models\Field;
// use app\core\helpers\ArrayHelper;


// class %s extends \%s
// {
//     public $fields;

//     public function init()
//     {

//         $mod = \Yii::$app->getRequest()->get('mod');
//         $fields = Field::find()->where(['table'=>"%s"])->asArray()->all();

//         $this->fields = ArrayHelper::map($fields, 'name', 'title');
//         parent::init();

//     }

//     public static function tableName()
//     {
//         return "%s";
//     }


//     public function attributeLabels()
//     {
//         $attr = parent::attributeLabels();

//         return $attr +$this->fields;
//     }


//     public function rules()
//     {
//         $rules = parent::rules();
//         return array_merge($rules, [[array_keys($this->fields), 'safe']]);
//     }
// }
// CLASS;


//         $data = sprintf($data, $class, $model, $table_name, $table);

//         FileHelper::createDirectory($dir);

//         if(!file_put_contents($dir . $filename, $data)) {
//             return false;
//         }

//         $search_filename = $class . 'Search.php';

//         if (is_file($c . 'Search.php')) {
//             $search = file_get_contents($c . 'Search.php');
//             $search = str_replace(basename($c), $class, $search);
//             $search = str_replace('models', 'models\\mods', $search);
//             file_put_contents($dir . $search_filename, $search);
//         }
//     }

    public static function createTable($table, $mod)
    {
        $sql = "CREATE TABLE %s LIKE %s";
        Yii::$app->db->createCommand(sprintf($sql, $table . '_' . $mod, $table))->execute();
    }

    public static function deleteTable($table, $mod)
    {
        $sql = "drop table " . $table . '_' . $mod;

        Yii::$app->db->createCommand($sql)->execute();
        
    }

    public static function delData($table, $mod)
    {
        $cate_sql = "DELETE FROM cms_category WHERE res_name = '".$table . $mod . "'";
        $field_sql = "DELETE FROM module_field WHERE `table` = '".$table .'_'. $mod . "'";

        Yii::$app->db->createCommand($cate_sql)->execute();
        Yii::$app->db->createCommand($field_sql)->execute();
    }

    // public static function deleteFile($model, $mod)
    // {

    //     // 类文件
    //     $c = Yii::getAlias('@'.str_replace('\\', '/', $model));
    //     $dir = dirname($c) . '/mods/';
    //     $class = basename($c) . $mod;
    //     $filename = $class . '.php';

    //     //查找文件
    //     $search_filename = $class . 'Search.php';


    //     // if (is_file($dir . $filename)) {
    //         @unlink($dir . $filename);
    //     // }

    //     // if (is_file($dir . $search_filename)) {
    //         @unlink($dir . $search_filename);
    //     // }

    // }

    public static function deleteMod($model)
    {
        $tables = Yii::$app->controller->module->params['table'][$model->module];

        foreach ($tables as $k => $mod) {
            self::deleteTable($k, $model->id);
            self::deleteFile($mod, $model->id);
        }

        self::delData($model->module, $mod);
    }


    public static function createModels($module)
    {
        $tables = Yii::$app->controller->module->params['table'][$module->module];

        foreach ($tables as $k => $model) {
            // self::createModel($model::className(), $module->id);
            self::createTable($k, $module->id);
        }

    }
}
