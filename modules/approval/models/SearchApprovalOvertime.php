<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\ApprovalOvertime;

/**
 * SearchApprovalOvertime represents the model behind the search form about `app\modules\approval\models\ApprovalOvertime`.
 */
class SearchApprovalOvertime extends ApprovalOvertime
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'approval_id', 'status', 'created_by', 'reviewed_by'], 'integer'],
            [['year', 'start_day', 'end_day', 'start_time', 'end_time', 'leave', 'type', 'desc', 'reason', 'created_date', 'reviewed_date'], 'safe'],
            [['hours'], 'number'],
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
        $query = ApprovalOvertime::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'approval_id' => $this->approval_id,
            'start_day' => $this->start_day,
            'end_day' => $this->end_day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'hours' => $this->hours,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'reviewed_by' => $this->reviewed_by,
            'reviewed_date' => $this->reviewed_date,
        ]);

        $query->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'leave', $this->leave])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
