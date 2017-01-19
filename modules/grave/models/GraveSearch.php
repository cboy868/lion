<?php

namespace app\modules\grave\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Grave;

/**
 * GraveSearch represents the model behind the search form about `app\modules\grave\models\Grave`.
 */
class GraveSearch extends Grave
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'level', 'thumb', 'status', 'user_id', 'sort', 'is_leaf', 'created_at'], 'integer'],
            [['code', 'name', 'intro'], 'safe'],
            [['area_totle', 'area_use', 'price'], 'number'],
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
        $query = Grave::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pid' => $this->pid,
            'level' => $this->level,
            'thumb' => $this->thumb,
            'area_totle' => $this->area_totle,
            'area_use' => $this->area_use,
            'price' => $this->price,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'sort' => $this->sort,
            'is_leaf' => $this->is_leaf,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
