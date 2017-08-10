<?php

namespace app\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\blog\models\Blog;

/**
 * BlogSearch represents the model behind the search form about `app\modules\blog\models\Blog`.
 */
class BlogSearch extends Blog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'thumb', 'sort', 'recommend', 'is_customer', 'is_top',
                'type', 'memorial_id', 'privacy', 'view_all', 'com_all', 'created_by',
                'created_at', 'updated_at', 'status','res'], 'integer'],
            [['title', 'summary', 'video', 'body', 'publish_at', 'ip'], 'safe'],
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
        $query = Blog::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => [
//                'pageSize' => 1,
//            ],
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
            'type' => $this->type,
            'memorial_id' => $this->memorial_id,
            'privacy' => $this->privacy,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'publish_at' => $this->publish_at,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'res' => $this->res
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
