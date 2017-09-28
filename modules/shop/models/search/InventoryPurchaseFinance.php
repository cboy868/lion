<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\InventoryPurchaseFinance as InventoryPurchaseFinanceModel;

/**
 * InventoryPurchaseFinance represents the model behind the search form about `app\modules\shop\models\InventoryPurchaseFinance`.
 */
class InventoryPurchaseFinance extends InventoryPurchaseFinanceModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'purchase_id', 'refund_id', 'op_id', 'created_at', 'status'], 'integer'],
            [['amount'], 'number'],
            [['op_name', 'ct_name', 'ct_mobile', 'note'], 'safe'],
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
        $query = InventoryPurchaseFinanceModel::find()->orderBy('id desc');

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
            'purchase_id' => $this->purchase_id,
            'refund_id' => $this->refund_id,
            'amount' => $this->amount,
            'op_id' => $this->op_id,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'op_name', $this->op_name])
            ->andFilterWhere(['like', 'ct_name', $this->ct_name])
            ->andFilterWhere(['like', 'ct_mobile', $this->ct_mobile])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
