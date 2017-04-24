<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\InventoryPurchaseRefund as InventoryPurchaseRefundModel;

/**
 * InventoryPurchaseRefund represents the model behind the search form about `app\modules\shop\models\InventoryPurchaseRefund`.
 */
class InventoryPurchaseRefund extends InventoryPurchaseRefundModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'purchase_rel_id', 'op_id', 'created_at', 'status'], 'integer'],
            [['num', 'amount'], 'number'],
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
        $query = InventoryPurchaseRefundModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'purchase_rel_id' => $this->purchase_rel_id,
            'num' => $this->num,
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
