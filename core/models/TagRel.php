<?php

namespace app\core\models;

use Yii;
use yii\db\Query;
use yii\behaviors\TimestampBehavior;
use app\core\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%tag_rel}}".
 *
 * @property string $res_id
 * @property string $res_name
 * @property string $tag_id
 */
class TagRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag_rel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_id', 'tag_id'], 'integer'],
            [['res_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'res_id' => '资源id',
            'res_name' => '资源类型',
            'tag_id' => 'tag id',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ],
        ];
    }

    /**
     * 示例
     * $provider = TagRel::getResByTag('测试', 'blog'); 反回provider 对象
     * $model = $provider->getModels();  所有数据对象
     * $page = $provider->getPagiation(); 分页对象
     * echo LinkPager::widget([
     *      'pagination' => $page //页面分页显示
     * ]);
     */
    public static function getResByTag($tag_name, $res_name)
    {
        $tag_model = Tag::find()->where(['tag_name'=>$tag_name])->one();

        if(!$tag_model) return null;
        $query = self::find();
        $query->andFilterWhere([
            'res_name'=>$res_name,
            'tag_id'=>$tag_model->id
        ]);

        $provider = new ActiveDataProvider([
            'query' =>$query,
            'pagination' => ['pageSize'=>1]
        ]);

        return $provider;
    }

    public static function getTagsByRes($res_name, $res_id)
    {
        $query = (new Query)->select('t.id,t.tag_name')
                ->from(['r' => '{{%tag_rel}}'])
                ->leftJoin(['t'=>'{{%tag}}'], 't.id=r.tag_id')
                ->where([
                    'r.res_name' => $res_name,
                    'r.res_id'=>$res_id
                ]);
        return $query->all();
    }

    public static function getReleted($res_name, $res_id)
    {
        $tags = self::find()->where(['res_name'=>$res_name, 'res_id'=>$res_id])->asArray()->all();
        $tag_ids = ArrayHelper::getColumn($tags, 'tag_id');

        $res = self::find()->where(['res_name'=>$res_name, 'tag_id'=>$tags])
                            ->andWhere(['<>', 'res_id', $res_id])
                            ->asArray()
                            ->all();

        return ArrayHelper::getColumn($res, 'res_id');        

    }

    /**
     * 添加tag
     * $tag_names array
     */
    public static function addTagRel($tag_names, $res_name, $res_id)
    {

        $transaction = Yii::$app->db->beginTransaction();
        
        try {
            $query = (new Query)->select(['r.res_id', 't.tag_name', 't.id'])
                    ->from(['t' => '{{%tag}}'])
                    ->leftJoin(['r'=>'{{%tag_rel}}'], 't.id=r.tag_id')
                    ->where([
                        'r.res_name' => $res_name,
                        'r.res_id'=>$res_id
                    ]);

            $ori_tags = $query->all();
            $ori_tag_names = ArrayHelper::map($ori_tags, 'id', 'tag_name');

            $delete_tags = array_diff($ori_tag_names, $tag_names); //待删除的tag
            foreach ($delete_tags as $k=>$v) {
                self::delRes($res_id, $res_name, $k);
            }
           
            $new_tags = array_diff($tag_names, $ori_tag_names); //待增加的tag
            foreach ($new_tags as $v) {
                if (empty($v)) continue;
                self::addRel($res_id, $res_name,trim($v));
            }
           
            $transaction->commit();
        } catch(Exception $e) {
            $transaction->rollBack();
        }
    }

    public static function delRes($res_id, $res_name, $tag_id)
    {

        $condition = 'res_id='.$res_id.' and res_name="'.$res_name.'" and tag_id=' .$tag_id;
        $flag = \Yii::$app->db->createCommand()->delete('{{%tag_rel}}', $condition)->execute();

        if ($flag !==false) {
            $model = Tag::findOne($tag_id);
            $model->num--;
            $model->save();
        }       

        return true;
    }

    public static function addRel($res_id, $res_name, $tag_name)
    {
        $tag_model = Tag::addTag($tag_name);

        $model = new static;

        $model->tag_id = $tag_model->id;
        $model->res_name = $res_name;
        $model->res_id = $res_id;

        $model->save();

        return $model;
    }

    public static function getRes($tag_id)
    {
        $model = Tag::findOne($tag_id);

        $lists = TagRel::find()->where(['tag_id'=>$tag_id])
                               ->select('res_id')
                               ->asArray()
                               ->distinct()
                               ->all();
        return $lists;

    }
}
