<?php

namespace app\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\order\models\Discount;

/**
 * DiscountSearch represents the model behind the search form about `app\modules\order\models\Discount`.
 */
class DiscountSearch extends Discount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'rel_id', 'op_id', 'leader', 'updated_at', 'created_at', 'status'], 'integer'],
            [['discount', 'reduce', 'ori_price', 'price'], 'number'],
            [['intro'], 'safe'],
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
        $query = Discount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'rel_id' => $this->rel_id,
            'discount' => $this->discount,
            'reduce' => $this->reduce,
            'ori_price' => $this->ori_price,
            'price' => $this->price,
            'op_id' => $this->op_id,
            'leader' => $this->leader,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
