<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\InventoryStorageRel as InventoryStorageRelModel;

/**
 * InventoryStorageRel represents the model behind the search form about `app\modules\shop\models\InventoryStorageRel`.
 */
class InventoryStorageRel extends InventoryStorageRelModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'storage_id', 'goods_id', 'sku_id', 'total', 'created_at'], 'integer'],
            [['note'], 'safe'],
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
        $query = InventoryStorageRelModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'storage_id' => $this->storage_id,
            'goods_id' => $this->goods_id,
            'sku_id' => $this->sku_id,
            'total' => $this->total,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
