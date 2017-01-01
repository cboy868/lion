<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\Refund as RefundModel;

/**
 * Refund represents the model behind the search form about `app\modules\shop\models\Refund`.
 */
class Refund extends RefundModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'wechat_uid', 'progress', 'created_at', 'updated_at', 'status'], 'integer'],
            [['fee'], 'number'],
            [['intro', 'note', 'checkout_at'], 'safe'],
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
        $query = RefundModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'wechat_uid' => $this->wechat_uid,
            'fee' => $this->fee,
            'progress' => $this->progress,
            'checkout_at' => $this->checkout_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
