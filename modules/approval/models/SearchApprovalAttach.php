<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\ApprovalAttach;

/**
 * SearchApprovalAttach represents the model behind the search form about `app\modules\approval\models\ApprovalAttach`.
 */
class SearchApprovalAttach extends ApprovalAttach
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'approve_id', 'created_at', 'status'], 'integer'],
            [['title', 'url', 'ext'], 'safe'],
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
        $query = ApprovalAttach::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'approve_id' => $this->approve_id,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'ext', $this->ext]);

        return $dataProvider;
    }
}
