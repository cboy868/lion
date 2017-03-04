<?php

namespace app\modules\task\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\task\models\Goods;

/**
 * GoodsSearch represents the model behind the search form about `app\modules\task\models\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'info_id', 'res_id', 'msg_type', 'trigger'], 'integer'],
            [['res_name', 'msg', 'msg_time'], 'safe'],
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
        $query = Goods::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'info_id' => $this->info_id,
            'res_id' => $this->res_id,
            'msg_type' => $this->msg_type,
            'trigger' => $this->trigger,
        ]);

        $query->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'msg', $this->msg])
            ->andFilterWhere(['like', 'msg_time', $this->msg_time]);

        return $dataProvider;
    }
}
