<?php

namespace app\modules\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\cms\models\Post;

/**
 * PostSearch represents the model behind the search form about `app\modules\cms\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'category_id', 'thumb', 'view_all', 'com_all', 'recommend', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'subtitle', 'summary', 'ip', 'author'], 'safe'],
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
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author' => $this->author,
            'category_id' => $this->category_id,
            'created_by' => $this->created_by,
            'thumb' => $this->thumb,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'recommend' => $this->recommend,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
