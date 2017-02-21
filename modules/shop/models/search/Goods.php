<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\Goods as GoodsModel;

/**
 * Goods represents the model behind the search form about `app\modules\shop\models\Goods`.
 */
class Goods extends GoodsModel
{

    public $sname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'thumb', 'is_recommend', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'intro', 'skill', 'unit', 'id', 'serial', 'sname'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GoodsModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        if (!($this->load($params) && $this->validate())) {

            return $dataProvider;
        }



        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'serial' => $this->serial,
            'thumb' => $this->thumb,
            'price' => $this->price,
            'is_recommend' => $this->is_recommend,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'skill', $this->skill])
            ->andFilterWhere(['like', 'unit', $this->unit]);

        return $dataProvider;
    }
    public function homeSearch($params)
    {
        $query = GoodsModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['psize']) ? $params['psize'] : 12,
            ],
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'thumb' => $this->thumb,
            'price' => $this->price,
            'is_recommend' => $this->is_recommend,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        if ($this->sname) {

            $query->andFilterWhere(['serial'=>$this->sname])
                  ->orFilterWhere(['like', 'name', $this->sname]);
        }


        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'skill', $this->skill])
            ->andFilterWhere(['like', 'unit', $this->unit]);

        return $dataProvider;
    }
}
