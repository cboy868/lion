<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Bury;

/**
 * BurySearch represents the model behind the search form about `app\modules\grave\models\Bury`.
 */
class BurySearch extends Bury
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tomb_id', 'user_id', 'dead_id', 'dead_num', 'bury_type', 'bury_user', 'bury_order', 'created_at', 'updated_at', 'status'], 'integer'],
            [['pre_bury_date', 'bury_date', 'bury_time', 'note', 'dead_name'], 'safe'],
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
        $query = Bury::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'dead_id' => $this->dead_id,
            'dead_num' => $this->dead_num,
            'bury_type' => $this->bury_type,
            'pre_bury_date' => $this->pre_bury_date,
            'bury_date' => $this->bury_date,
            'bury_time' => $this->bury_time,
            'bury_user' => $this->bury_user,
            'bury_order' => $this->bury_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => [self::STATUS_NORMAL, self::STATUS_OK],
        ]);

        $query->andWhere([
            'tomb_id' => \app\modules\grave\models\search\TombSearch::searchTomb($params)
        ]);

        $query->andFilterWhere(['like', 'note', $this->note])
                ->andFilterWhere(['like', 'dead_name', $this->dead_name]);

        return $dataProvider;
    }
}
