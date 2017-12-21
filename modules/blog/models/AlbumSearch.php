<?php

namespace app\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\blog\models\Album;

/**
 * AlbumSearch represents the model behind the search form about `app\modules\blog\models\Album`.
 */
class AlbumSearch extends Album
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'thumb', 'sort', 'recommend', 'is_customer', 'is_top',
                'memorial_id', 'privacy', 'view_all', 'com_all', 'num', 'created_by',
                'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'summary', 'body', 'ip'], 'safe'],
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
        $query = Album::find()->orderBy('id desc');

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
            'thumb' => $this->thumb,
            'sort' => $this->sort,
            'recommend' => $this->recommend,
            'is_customer' => $this->is_customer,
            'is_top' => $this->is_top,
            'memorial_id' => $this->memorial_id,
            'privacy' => $this->privacy,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'num' => $this->num,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }

    public function searchHome($params)
    {
        $query = Album::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sort' => $this->sort,
            'recommend' => $this->recommend,
            'is_customer' => $this->is_customer,
            'is_top' => $this->is_top,
            'memorial_id' => $this->memorial_id,
            'privacy' => $this->privacy,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'num' => $this->num,
            'created_by' => $this->created_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }

    public function searchMemorial($params)
    {
        $query = Album::find()->orderBy('id desc');
        $query->where(['<>', 'memorial_id', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 16,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sort' => $this->sort,
            'recommend' => $this->recommend,
            'is_customer' => $this->is_customer,
            'is_top' => $this->is_top,
            'memorial_id' => $this->memorial_id,
            'privacy' => $this->privacy,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'num' => $this->num,
            'created_by' => $this->created_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
