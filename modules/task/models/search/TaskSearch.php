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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cate_id', 'grave_id', 'res_id', 'user_id', 'order_rel_id', 'op_id', 'status', 'created_at'], 'integer'],
            [['res_name', 'title', 'content', 'pre_finish', 'finish'], 'safe'],
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
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cate_id' => $this->cate_id,
            'grave_id' => $this->grave_id,
            'res_id' => $this->res_id,
            'user_id' => $this->user_id,
            'order_rel_id' => $this->order_rel_id,
            'op_id' => $this->op_id,
            'pre_finish' => $this->pre_finish,
            'finish' => $this->finish,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
