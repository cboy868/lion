<?php

use yii\db\Migration;

class m161006_141200_module extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%module}}', [
            'id' => $this->primaryKey(),
            'module' =>$this->string(255)->notNull(),//模块
            'name' => $this->string(255)->notNull(), //模块名
            'dir' => $this->string(255), //静态文件目录
            'link' => $this->string(255), //连接地址
            'order'=> $this->smallInteger(4), //模块排序
            'show' => $this->smallInteger(1)->defaultValue(1), //是否在前台显示
            'logo' => $this->string(255), //logo
            'created_at' => $this->integer()->notNull(),//添加时间
        ], $tableOptions);

        $this->createTable('{{%module_field}}', [
            'id' => $this->primaryKey(),
            'table' =>$this->string(45)->notNull(),//表
            'name' => $this->string(255)->notNull(), //字段名
            'title' => $this->string(255), //显示的标题
            'pop_note' => $this->string(255), //添加时的提示信息
            'html'=> $this->string(100), //表现形式 input textarea之类
            'option' => $this->text(), //选项值，当html为select radio checkbox之类时的选择值
            'default' => $this->text(), //默认值
            'is_show' => $this->smallInteger(1)->defaultValue(1),//是否显示
            'order' => $this->smallInteger(1),//排序
            'created_at' => $this->integer()->notNull(),//添加时间
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%module}}');
        $this->dropTable('{{%module_field}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}



// INSERT INTO `module_code` (`id`, `module`, `type`, `code`) VALUES
// (1, 'post', 'model', 'namespace app\\modules\\cms\\models\\mods;\n\nuse app\\modules\\mod\\models\\Field;\nuse app\\core\\helpers\\ArrayHelper;\n\n\nclass Post{modstr} extends \\app\\modules\\cms\\models\\Post\n{\n    public $fields;\n\n    public function init()\n    {\n\n        $mod = \\Yii::$app->getRequest()->get(''mod'');\n        $fields = Field::find()->where([''table''=>"post_{modstr}"])->asArray()->all();\n\n        $this->fields = ArrayHelper::map($fields, ''name'', ''title'');\n        parent::init();\n\n    }\n\n    public static function tableName()\n    {\n        return "{{%post_{modstr}}}";\n    }\n\n\n    public function attributeLabels()\n    {\n        $attr = parent::attributeLabels();\n\n        return $attr +$this->fields;\n    }\n\n\n    public function rules()\n    {\n        $rules = parent::rules();\n        return array_merge($rules, [[array_keys($this->fields), ''safe'']]);\n    }\n}'),
// (2, 'post', 'search', 'namespace app\\modules\\cms\\models\\mods;\r\n\r\nuse Yii;\r\nuse yii\\base\\Model;\r\nuse yii\\data\\ActiveDataProvider;\r\nuse app\\modules\\cms\\models\\mods\\Post{modstr};\r\n\r\nclass Post{modstr}Search extends Post{modstr}\r\n{\r\n    /**\r\n     * @inheritdoc\r\n     */\r\n    public function rules()\r\n    {\r\n        return [\r\n            [[''id'', ''created_by'', ''category_id'', ''thumb'', ''view_all'', ''com_all'', ''recommend'', ''created_at'', ''updated_at'', ''status''], ''integer''],\r\n            [[''title'', ''subtitle'', ''summary'', ''ip'', ''author''], ''safe''],\r\n        ];\r\n    }\r\n\r\n    /**\r\n     * @inheritdoc\r\n     */\r\n    public function scenarios()\r\n    {\r\n        // bypass scenarios() implementation in the parent class\r\n        return Model::scenarios();\r\n    }\r\n\r\n    /**\r\n     * Creates data provider instance with search query applied\r\n     *\r\n     * @param array $params\r\n     *\r\n     * @return ActiveDataProvider\r\n     */\r\n    public function search($params)\r\n    {\r\n        $query = Post{modstr}::find();\r\n\r\n        $dataProvider = new ActiveDataProvider([\r\n            ''query'' => $query,\r\n        ]);\r\n\r\n        if (!($this->load($params) && $this->validate())) {\r\n            return $dataProvider;\r\n        }\r\n\r\n        $query->andFilterWhere([\r\n            ''id'' => $this->id,\r\n            ''author'' => $this->author,\r\n            ''category_id'' => $this->category_id,\r\n            ''created_by'' => $this->created_by,\r\n            ''thumb'' => $this->thumb,\r\n            ''view_all'' => $this->view_all,\r\n            ''com_all'' => $this->com_all,\r\n            ''recommend'' => $this->recommend,\r\n            ''created_at'' => $this->created_at,\r\n            ''updated_at'' => $this->updated_at,\r\n            ''status'' => $this->status,\r\n        ]);\r\n\r\n        $query->andFilterWhere([''like'', ''title'', $this->title])\r\n            ->andFilterWhere([''like'', ''subtitle'', $this->subtitle])\r\n            ->andFilterWhere([''like'', ''summary'', $this->summary])\r\n            ->andFilterWhere([''like'', ''ip'', $this->ip]);\r\n\r\n        return $dataProvider;\r\n    }\r\n}'),
// (3, 'post', 'data', 'namespace app\\modules\\cms\\models\\mods;\r\n\r\nuse app\\modules\\mod\\models\\Field;\r\nuse app\\core\\helpers\\ArrayHelper;\r\n\r\n\r\nclass PostData{modstr} extends \\app\\modules\\cms\\models\\PostData\r\n{\r\n    public $fields;\r\n\r\n    public function init()\r\n    {\r\n\r\n        $mod = \\Yii::$app->getRequest()->get(''mod'');\r\n        $fields = Field::find()->where([''table''=>"post_data_{modstr}"])->asArray()->all();\r\n\r\n        $this->fields = ArrayHelper::map($fields, ''name'', ''title'');\r\n        parent::init();\r\n\r\n    }\r\n\r\n    public static function tableName()\r\n    {\r\n        return "{{%post_data_{modstr}}}";\r\n    }\r\n\r\n\r\n    public function attributeLabels()\r\n    {\r\n        $attr = parent::attributeLabels();\r\n\r\n        return $attr +$this->fields;\r\n    }\r\n\r\n\r\n    public function rules()\r\n    {\r\n        $rules = parent::rules();\r\n        return array_merge($rules, [[array_keys($this->fields), ''safe'']]);\r\n    }\r\n}'),
// (4, 'album', 'model', 'namespace app\\modules\\cms\\models\\mods;\r\n\r\nuse app\\modules\\mod\\models\\Field;\r\nuse app\\core\\helpers\\ArrayHelper;\r\n\r\n\r\nclass Album{modstr} extends \\app\\modules\\cms\\models\\Album\r\n{\r\n    public $fields;\r\n\r\n    public function init()\r\n    {\r\n\r\n        $mod = \\Yii::$app->getRequest()->get(''mod'');\r\n        $fields = Field::find()->where([''table''=>"album_{modstr}"])->asArray()->all();\r\n\r\n        $this->fields = ArrayHelper::map($fields, ''name'', ''title'');\r\n        parent::init();\r\n\r\n    }\r\n\r\n    public static function tableName()\r\n    {\r\n        return "{{%album_{modstr}}}";\r\n    }\r\n\r\n\r\n    public function attributeLabels()\r\n    {\r\n        $attr = parent::attributeLabels();\r\n\r\n        return $attr +$this->fields;\r\n    }\r\n\r\n\r\n    public function rules()\r\n    {\r\n        $rules = parent::rules();\r\n        return array_merge($rules, [[array_keys($this->fields), ''safe'']]);\r\n    }\r\n}'),
// (5, 'album', 'search', 'namespace app\\modules\\cms\\models\\mods;\n\nuse Yii;\nuse yii\\base\\Model;\nuse yii\\data\\ActiveDataProvider;\nuse app\\modules\\cms\\models\\mods\\Album{modstr};\n\nclass Album{modstr}Search extends Album{modstr}\n{\n    public function rules()\n    {\n        return [\n            [[''id'', ''created_by'', ''category_id'', ''thumb'', ''sort'', ''view_all'', ''com_all'', ''photo_num'', ''recommend'', ''created_at'', ''updated_at'', ''status''], ''integer''],\n            [[''title'', ''intro'', ''author''], ''safe''],\n        ];\n    }\n\n    public function scenarios()\n    {\n        // bypass scenarios() implementation in the parent class\n        return Model::scenarios();\n    }\n\n    public function search($params)\n    {\n        $query = Album{modstr}::find();\n\n        $dataProvider = new ActiveDataProvider([\n            ''query'' => $query,\n        ]);\n\n        if (!($this->load($params) && $this->validate())) {\n            return $dataProvider;\n        }\n\n        $query->andFilterWhere([\n            ''id'' => $this->id,\n            ''author'' => $this->author,\n            ''category_id'' => $this->category_id,\n            ''thumb'' => $this->thumb,\n            ''sort'' => $this->sort,\n            ''view_all'' => $this->view_all,\n            ''com_all'' => $this->com_all,\n            ''photo_num'' => $this->photo_num,\n            ''recommend'' => $this->recommend,\n            ''created_by'' => $this->created_by,\n            ''status'' => $this->status,\n        ]);\n\n        $query->andFilterWhere([''like'', ''title'', $this->title]);\n\n        return $dataProvider;\n    }\n}');

