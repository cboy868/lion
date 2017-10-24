<?php

namespace app\modules\task\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\task\models\Task;

/**
 * TaskSearch represents the model behind the search form about `app\modules\task\models\Task`.
 */
class TaskSearch extends Task
{
    public $start;
    public $end;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cate_id', 'res_id', 'user_id', 'order_rel_id', 'op_id', 'status', 'created_at'], 'integer'],
            [['res_name', 'title', 'content', 'pre_finish', 'finish','start','end'], 'safe'],
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
        $query = Task::find()->orderBy('id desc');

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
            'id' => $this->id,
            'cate_id' => $this->cate_id,
            'res_id' => $this->res_id,
            'user_id' => $this->user_id,
            'order_rel_id' => $this->order_rel_id,
            'op_id' => $this->op_id,
            'finish' => $this->finish,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        if ($this->start) {
            $start = $this->start;
            $query->andFilterWhere(['>=', 'pre_finish', $start]);
        }

        if ($this->end) {
            $end = date('Y-m-d',strtotime('+1 day',strtotime($this->end)));
            $query->andFilterWhere(['<=', 'pre_finish', $end]);
        }

        $query->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
