<?php

namespace app\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\order\models\OrderRel;

/**
 * OrderRelSearch represents the model behind the search form about `app\modules\order\models\OrderRel`.
 */
class OrderRelSearch extends OrderRel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'wechat_uid', 'type', 'category_id', 'goods_id', 'sku_id', 'order_id', 'num', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'sku_name', 'use_time', 'note'], 'safe'],
            [['price', 'price_unit'], 'number'],
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
        $query = OrderRel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'wechat_uid' => $this->wechat_uid,
            'type' => $this->type,
            'category_id' => $this->category_id,
            'goods_id' => $this->goods_id,
            'sku_id' => $this->sku_id,
            'order_id' => $this->order_id,
            'price' => $this->price,
            'price_unit' => $this->price_unit,
            'num' => $this->num,
            'use_time' => $this->use_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'sku_name', $this->sku_name])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
