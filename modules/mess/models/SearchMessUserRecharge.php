<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessUserRecharge;

/**
 * SearchMessUserRecharge represents the model behind the search form about `app\modules\mess\models\MessUserRecharge`.
 */
class SearchMessUserRecharge extends MessUserRecharge
{

    public $start;
    public $end;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'op_id', 'created_at'], 'integer'],
            [['price'], 'number'],
            [['start','end'], 'safe'],
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
        $query = MessUserRecharge::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'op_id' => $this->op_id,
            'price' => $this->price,
        ]);

        if ($this->start) {
            $query->andFilterWhere(['>=', 'created_at', strtotime($this->start)]);
        }

        if ($this->end) {
            $end = strtotime('+1 day',strtotime($this->end));
            $query->andFilterWhere(['<=', 'created_at', $end]);
        }

        return $dataProvider;
    }
}
