<?php

namespace app\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * OrderSearch represents the model behind the search form about `app\modules\order\models\Order`.
 */
class OrderSearch extends Order
{

    public $uname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'wechat_uid', 'type', 'progress', 'created_at', 'updated_at', 'status'], 'integer'],
            [['price', 'origin_price'], 'number'],
            [['note', 'uname'], 'safe'],
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
        $query = Order::find();
        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            '{{%order}}.id' => $this->id,
            // 'wechat_uid' => $this->wechat_uid,
            'price' => $this->price,
            'origin_price' => $this->origin_price,
            'type' => $this->type,
            'progress' => $this->progress,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status
        ]);


        $query->andFilterWhere(['like', '{{%user}}.username', $this->uname]);
        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
