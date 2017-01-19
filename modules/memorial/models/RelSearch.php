<?php

namespace app\modules\memorial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\memorial\models\Rel;

/**
 * RelSearch represents the model behind the search form about `app\modules\memorial\models\Rel`.
 */
class RelSearch extends Rel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'memorial_id', 'res_id', 'created_at'], 'integer'],
            [['res_name', 'res_title', 'res_user', 'res_cover'], 'safe'],
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
        $query = Rel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'memorial_id' => $this->memorial_id,
            'res_id' => $this->res_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'res_title', $this->res_title])
            ->andFilterWhere(['like', 'res_user', $this->res_user])
            ->andFilterWhere(['like', 'res_cover', $this->res_cover]);

        return $dataProvider;
    }
}
