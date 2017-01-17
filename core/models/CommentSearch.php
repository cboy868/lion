<?php

namespace app\core\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\core\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `app\core\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from', 'to', 'res_id', 'pid', 'privacy', 'status', 'created_at'], 'integer'],
            [['res_name', 'content'], 'safe'],
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
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'res_id' => $this->res_id,
            'pid' => $this->pid,
            'privacy' => $this->privacy,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
