<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Ins;

/**
 * InsSearch represents the model behind the search form about `app\modules\grave\models\Ins`.
 */
class InsSearch extends Ins
{

    public $guide;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'guide_id', 'user_id', 'tomb_id', 'op_id', 'shape', 'is_tc', 'font', 'big_num',
                'small_num', 'new_small_num', 'new_big_num', 'is_confirm', 'confirm_by', 'version',
                'paint', 'is_stand', 'status', 'updated_at', 'created_at'], 'integer'],
            [['position', 'content', 'img', 'confirm_date', 'pre_finish', 'finish_at', 'note', 'guide'], 'safe'],
            [['paint_price', 'letter_price', 'tc_price'], 'number'],
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
        $query = Ins::find();
        $query->joinWith(['guide']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'guide_id' => $this->guide_id,
            'user_id' => $this->user_id,
            'op_id' => $this->op_id,
            'shape' => $this->shape,
            'is_tc' => $this->is_tc,
            'font' => $this->font,
            'is_confirm' => $this->is_confirm,
            'confirm_date' => $this->confirm_date,
            'confirm_by' => $this->confirm_by,
            'pre_finish' => $this->pre_finish,
            'finish_at' => $this->finish_at,
            'version' => $this->version,
            'paint' => $this->paint,
            'is_stand' => $this->is_stand,
            'paint_price' => $this->paint_price,
            'letter_price' => $this->letter_price,
            'tc_price' => $this->tc_price,
            'status' => $this->status,
        ]);


        if (isset($params['TombSearch']['grave_id']) && $params['TombSearch']['grave_id']) {
            $query->andWhere([
                'tomb_id' => \app\modules\grave\models\search\TombSearch::searchTomb($params)//$this->searchTomb($params),
            ]);
        }

        $query->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', '{{%user}}.username', $this->guide]);

        return $dataProvider;
    }
}
