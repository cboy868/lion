<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\InventoryPurchaseRel as InventoryPurchaseRelModel;

/**
 * InventoryPurchaseRel represents the model behind the search form about `app\modules\shop\models\InventoryPurchaseRel`.
 */
class InventoryPurchaseRel extends InventoryPurchaseRelModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'record_id', 'goods_id', 'sku_id', 'op_id', 'created_at', 'status'], 'integer'],
            [['unit_price', 'num', 'total', 'retail'], 'number'],
            [['unit', 'op_name', 'note'], 'safe'],
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
        $query = InventoryPurchaseRelModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'record_id' => $this->record_id,
            'goods_id' => $this->goods_id,
            'sku_id' => $this->sku_id,
            'unit_price' => $this->unit_price,
            'num' => $this->num,
            'total' => $this->total,
            'retail' => $this->retail,
            'op_id' => $this->op_id,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'op_name', $this->op_name])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
