<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\ApprovalLeave;

/**
 * SearchApprovalLeave represents the model behind the search form about `app\modules\approval\models\ApprovalLeave`.
 */
class SearchApprovalLeave extends ApprovalLeave
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'approval_id', 'created_at', 'status'], 'integer'],
            [['start_time', 'end_time', 'note'], 'safe'],
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
        $query = ApprovalLeave::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'approval_id' => $this->approval_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
