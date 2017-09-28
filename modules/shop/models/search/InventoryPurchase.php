<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\InventoryPurchase as InventoryPurchaseModel;

/**
 * InventoryPurchase represents the model behind the search form about `app\modules\shop\models\InventoryPurchase`.
 */
class InventoryPurchase extends InventoryPurchaseModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'supplier_id', 'op_id', 'checker_id', 'created_at', 'status'], 'integer'],
            [['op_name', 'ct_name', 'ct_mobile', 'checker_name', 'note'], 'safe'],
            [['total'], 'number'],
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
        $query = InventoryPurchaseModel::find()->orderBy('id desc');

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
            'supplier_id' => $this->supplier_id,
            'op_id' => $this->op_id,
            'checker_id' => $this->checker_id,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'op_name', $this->op_name])
            ->andFilterWhere(['like', 'ct_name', $this->ct_name])
            ->andFilterWhere(['like', 'ct_mobile', $this->ct_mobile])
            ->andFilterWhere(['like', 'checker_name', $this->checker_name])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
