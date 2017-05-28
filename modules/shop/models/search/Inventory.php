<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\Inventory as InventoryModel;

/**
 * Inventory represents the model behind the search form about `app\modules\shop\models\Inventory`.
 */
class Inventory extends InventoryModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'sku_id', 'op_id', 'created_at', 'status'], 'integer'],
            [['record', 'actual', 'diff_num', 'diff_amount'], 'number'],
            [['op_date', 'note'], 'safe'],
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
        $query = InventoryModel::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'goods_id' => $this->goods_id,
            'sku_id' => $this->sku_id,
            'record' => $this->record,
            'actual' => $this->actual,
            'op_id' => $this->op_id,
            'op_date' => $this->op_date,
            'diff_num' => $this->diff_num,
            'diff_amount' => $this->diff_amount,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
