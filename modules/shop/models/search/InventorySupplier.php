<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\InventorySupplier as InventorySupplierModel;

/**
 * InventorySupplier represents the model behind the search form about `app\modules\shop\models\InventorySupplier`.
 */
class InventorySupplier extends InventorySupplierModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ct_sex', 'created_by', 'created_at', 'status'], 'integer'],
            [['cp_name', 'cp_phone', 'addr', 'ct_name', 'ct_mobile', 'qq', 'wechat', 'note'], 'safe'],
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
        $query = InventorySupplierModel::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'ct_sex' => $this->ct_sex,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'cp_name', $this->cp_name])
            ->andFilterWhere(['like', 'cp_phone', $this->cp_phone])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'ct_name', $this->ct_name])
            ->andFilterWhere(['like', 'ct_mobile', $this->ct_mobile])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
