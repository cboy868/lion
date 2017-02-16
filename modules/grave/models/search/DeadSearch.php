<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Dead;

/**
 * DeadSearch represents the model behind the search form about `app\modules\grave\models\Dead`.
 */
class DeadSearch extends Dead
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'tomb_id', 'memorial_id', 'serial', 'gender', 'is_alive', 'is_adult', 'age', 'follow_id', 'is_ins', 'bone_type', 'bone_container', 'created_at', 'updated_at', 'status'], 'integer'],
            [['dead_name', 'second_name', 'dead_title', 'birth_place', 'birth', 'fete', 'desc', 'pre_bury', 'bury'], 'safe'],
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
        $query = Dead::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'tomb_id' => $this->tomb_id,
            'memorial_id' => $this->memorial_id,
            'serial' => $this->serial,
            'gender' => $this->gender,
            'birth' => $this->birth,
            'fete' => $this->fete,
            'is_alive' => $this->is_alive,
            'is_adult' => $this->is_adult,
            'age' => $this->age,
            'follow_id' => $this->follow_id,
            'is_ins' => $this->is_ins,
            'bone_type' => $this->bone_type,
            'bone_container' => $this->bone_container,
            'pre_bury' => $this->pre_bury,
            'bury' => $this->bury,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'dead_name', $this->dead_name])
            ->andFilterWhere(['like', 'second_name', $this->second_name])
            ->andFilterWhere(['like', 'dead_title', $this->dead_title])
            ->andFilterWhere(['like', 'birth_place', $this->birth_place])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
