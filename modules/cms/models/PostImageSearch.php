<?php

namespace app\modules\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AlbumImageSearch represents the model behind the search form about `app\modules\cms\models\AlbumImage`.
 */
class PostImageSearch extends PostImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'post_id', 'mod', 'author_id', 'sort', 'view_all', 'com_all', 'created_at', 'status'], 'integer'],
            [['title', 'path', 'name', 'desc', 'ext'], 'safe'],
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
        $query = PostImage::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('sort asc'),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'post_id' => $this->post_id,
            'mod' => $this->mod,
            'author_id' => $this->author_id,
            'sort' => $this->sort,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'ext', $this->ext]);

        return $dataProvider;
    }
}
