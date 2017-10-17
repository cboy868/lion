<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\ApprovalProcessStep;

/**
 * SearchApprovalProcessStep represents the model behind the search form about `app\modules\approval\models\ApprovalProcessStep`.
 */
class SearchApprovalProcessStep extends ApprovalProcessStep
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'process_id', 'step', 'created_at'], 'integer'],
            [['step_name', 'approval_user'], 'safe'],
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
        $query = ApprovalProcessStep::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'process_id' => $this->process_id,
            'step' => $this->step,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'step_name', $this->step_name])
            ->andFilterWhere(['like', 'approval_user', $this->approval_user]);

        return $dataProvider;
    }
}
