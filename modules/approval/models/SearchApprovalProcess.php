<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\ApprovalProcess;

/**
 * SearchApprovalProcess represents the model behind the search form about `app\modules\approval\models\ApprovalProcess`.
 */
class SearchApprovalProcess extends ApprovalProcess
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'eng_id', 'step_total', 'is_money', 'is_leave', 'create_user', 'created_at', 'status'], 'integer'],
            [['title', 'intro', 'can_user'], 'safe'],
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
        $query = ApprovalProcess::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'eng_id' => $this->eng_id,
            'step_total' => $this->step_total,
            'is_money' => $this->is_money,
            'is_leave' => $this->is_leave,
            'create_user' => $this->create_user,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'can_user', $this->can_user]);

        return $dataProvider;
    }
}
