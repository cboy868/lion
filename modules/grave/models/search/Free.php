<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Free as FreeModel;

/**
 * Free represents the model behind the search form about `app\modules\grave\models\Free`.
 */
class Free extends FreeModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bury_type', 'max_num', 'status', 'created_at', 'op_id'], 'integer'],
            [['title', 'bury_date', 'note', 'op_user', 'op_mobile', 'stage'], 'safe'],
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
        $query = FreeModel::find();

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
            'bury_type' => $this->bury_type,
            'bury_date' => $this->bury_date,
            'max_num' => $this->max_num,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'op_id' => $this->op_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'op_user', $this->op_user])
            ->andFilterWhere(['like', 'op_mobile', $this->op_mobile])
            ->andFilterWhere(['like', 'stage', $this->stage]);

        return $dataProvider;
    }
}
