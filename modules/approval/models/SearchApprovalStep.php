<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\ApprovalStep;

/**
 * SearchApprovalStep represents the model behind the search form about `app\modules\approval\models\ApprovalStep`.
 */
class SearchApprovalStep extends ApprovalStep
{

    public $tit;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'approval_id', 'step', 'progress', 'created_at'], 'integer'],
            [['step_name', 'approval_user', 'note', 'tit'], 'safe'],
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
        $query = ApprovalStep::find()->joinWith('approval');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'approval_id' => $this->approval_id,
            'step' => $this->step,
            'approval_step.progress' => $this->progress,
            'created_at' => $this->created_at,
            'approval_user' => $this->approval_user
        ]);

        $query->andFilterWhere(['like', 'step_name', $this->step_name])
            ->andFilterWhere(['like', 'note', $this->note])
        ->andFilterWhere(['like', 'approval.title', $this->tit]);

        return $dataProvider;
    }
}
