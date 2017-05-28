<?php

namespace app\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\news\models\News;

/**
 * NewsSearch represents the model behind the search form about `app\modules\news\models\News`.
 */
class NewsSearch extends News
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'thumb', 'sort', 'view_all', 'com_all', 'recommend', 'is_top', 'type', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'subtitle', 'summary', 'author', 'pic_author', 'video_author', 'source', 'video'], 'safe'],
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
        $query = News::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'thumb' => $this->thumb,
            'sort' => $this->sort,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'recommend' => $this->recommend,
            'is_top' => $this->is_top,
            'type' => $this->type,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'pic_author', $this->pic_author])
            ->andFilterWhere(['like', 'video_author', $this->video_author])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'video', $this->video]);

        return $dataProvider;
    }
}
