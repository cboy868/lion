<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Dead;
use app\modules\grave\models\search\TombSearch;

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
            [['id', 'user_id', 'tomb_id', 'memorial_id', 'serial', 'gender', 'is_alive', 'is_adult', 'age', 'follow_id', 'is_ins', 'bone_type', 'bone_box', 'created_at', 'updated_at', 'status'], 'integer'],
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

        $query = Dead::find()->andWhere(['<>', 'tomb_id', 0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
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
            'bone_box' => $this->bone_box,
            'pre_bury' => $this->pre_bury,
            'bury' => $this->bury,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);


        if ($params['TombSearch']['grave_id']) {
            $query->andWhere([
                'tomb_id' => \app\modules\grave\models\search\TombSearch::searchTomb($params)//$this->searchTomb($params),
            ]);
        }
        $query->andFilterWhere(['like', 'dead_name', trim($this->dead_name)])
            ->andFilterWhere(['like', 'second_name', $this->second_name])
            ->andFilterWhere(['like', 'dead_title', $this->dead_title])
            ->andFilterWhere(['like', 'birth_place', $this->birth_place])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }

    // public function searchTomb($params)
    // {
    //     $searchModel = new TombSearch();
    //     $dataProvider = $searchModel->search($params);
    //     $models = $dataProvider->getModels();
    //     if (!$dataProvider) {
    //         return false;
    //     }

    //     $tomb_id = [];
    //     foreach ($models as $k => $v) {
    //         array_push($tomb_id, $v->id);
    //     }
    //     return $tomb_id;
    // }
}
