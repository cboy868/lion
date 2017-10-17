<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\ApprovalGoods;

/**
 * SearchApprovalGoods represents the model behind the search form about `app\modules\approval\models\ApprovalGoods`.
 */
class SearchApprovalGoods extends ApprovalGoods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'approval_id', 'num', 'created_at', 'status'], 'integer'],
            [['title', 'intro', 'unit', 'unit_price'], 'safe'],
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
        $query = ApprovalGoods::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'approval_id' => $this->approval_id,
            'num' => $this->num,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'unit_price', $this->unit_price]);

        return $dataProvider;
    }
}
