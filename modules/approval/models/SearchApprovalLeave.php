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
            [['approval_id'], 'integer'],
            [['year', 'start_day', 'end_day', 'start_time', 'end_time', 'finish_at',
                'type', 'desc', 'status', 'created_by', 'created_dtime', 'reviewed_by',
                'reviewed_dtime', 'genre'], 'safe'],
            [['hours','month'], 'number'],
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
            'start_day' => $this->start_day,
            'end_day' => $this->end_day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'hours' => $this->hours,
            'year' => $this->year,
            'month' => $this->month,
            'finish_at' => $this->finish_at,
            'type' => $this->type,
            'created_by' => $this->created_by,
            'reviewed_by' => $this->reviewed_by,
            'status' => $this->status,
            'genre' => $this->genre
        ]);

        $query->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
