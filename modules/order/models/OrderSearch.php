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

    public $start;
    public $end;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'wechat_uid', 'type', 'progress', 'created_at', 'updated_at', 'status'], 'integer'],
            [['price', 'origin_price'], 'number'],
            [['note', 'uname','start','end'], 'safe'],
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
        $query = Order::find()->orderBy('id desc');
        $query->joinWith(['user']);

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


        if ($this->start) {
            $start = strtotime($this->start);
            $query->andFilterWhere(['>', '{{%order}}.created_at', $start]);
        }

        if ($this->end) {
            $end = strtotime('+1 day',strtotime($this->end));
            $query->andFilterWhere(['<', '{{%order}}.created_at', $end]);
        }


        $query->andFilterWhere(['like', '{{%user}}.username', $this->uname]);
        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }

    public function searchMember($params)
    {
        $query = Order::find()->orderBy('id desc');
        $query->andWhere(['user_id'=>Yii::$app->user->id]);

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
            '{{%order}}.id' => $this->id,
            'price' => $this->price,
            'origin_price' => $this->origin_price,
            'type' => $this->type,
            'progress' => $this->progress,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status
        ]);


        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
