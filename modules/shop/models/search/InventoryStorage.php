<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\InventoryStorage as InventoryStorageModel;

/**
 * InventoryStorage represents the model behind the search form about `app\modules\shop\models\InventoryStorage`.
 */
class InventoryStorage extends InventoryStorageModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'op_id', 'created_at', 'status'], 'integer'],
            [['name', 'pos', 'op_name', 'mobile', 'thumb'], 'safe'],
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
        $query = InventoryStorageModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'op_id' => $this->op_id,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'pos', $this->pos])
            ->andFilterWhere(['like', 'op_name', $this->op_name])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'thumb', $this->thumb]);

        return $dataProvider;
    }
}
