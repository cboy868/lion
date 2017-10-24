<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Portrait;

/**
 * PortraitSearch represents the model behind the search form about `app\modules\grave\models\Portrait`.
 */
class PortraitSearch extends Portrait
{

    public $start;
    public $end;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'guide_id', 'user_id', 'tomb_id', 'order_id',
                'order_rel_id', 'notice_id', 'type', 'status', 'updated_at',
                'created_at'], 'integer'],
            [['title', 'dead_ids', 'photo_original', 'photo_processed', 'confirm_at',
                'photo_confirm', 'use_at', 'up_at', 'note','start','end','confirm_by'], 'safe'],
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
        $query = Portrait::find()->where(['<>', 'status', Portrait::STATUS_DELETE])->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere([
            'tomb_id' => \app\modules\grave\models\search\TombSearch::searchTomb($params)//$this->searchTomb($params),
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'guide_id' => $this->guide_id,
            'user_id' => $this->user_id,
//            'goods_id' => $this->goods_id,
            'order_id' => $this->order_id,
            'order_rel_id' => $this->order_rel_id,
            'confrim_by' => $this->confirm_by,
            'confirm_at' => $this->confirm_at,
            'use_at' => $this->use_at,
            'up_at' => $this->up_at,
            'notice_id' => $this->notice_id,
            'type' => $this->type,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        if ($this->start) {
            $start = $this->start;
            $query->andFilterWhere(['>=', 'use_at', $start]);
        }

        if ($this->end) {
            $end = date('Y-m-d',strtotime('+1 day',strtotime($this->end)));
            $query->andFilterWhere(['<=', 'use_at', $end]);
        }


        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'dead_ids', $this->dead_ids])
            ->andFilterWhere(['like', 'photo_original', $this->photo_original])
            ->andFilterWhere(['like', 'photo_processed', $this->photo_processed])
            ->andFilterWhere(['like', 'photo_confirm', $this->photo_confirm])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
