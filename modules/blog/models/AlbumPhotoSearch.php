<?php

namespace app\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\blog\models\AlbumPhoto;

/**
 * AlbumPhotomSearch represents the model behind the search form about `app\modules\blog\models\AlbumPhoto`.
 */
class AlbumPhotoSearch extends AlbumPhoto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'album_id', 'sort', 'view_all', 'com_all', 'privacy', 'created_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'path', 'name', 'body', 'ext', 'ip'], 'safe'],
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
        $query = AlbumPhoto::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'album_id' => $this->album_id,
            'sort' => $this->sort,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'privacy' => $this->privacy,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
