<?php

namespace app\modules\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\cms\models\Nav;

/**
 * NavSearch represents the model behind the search form about `app\modules\cms\models\Nav`.
 */
class NavSearch extends Nav
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'show', 'sort', 'created_at'], 'integer'],
            [['name', 'url', 'title', 'keywords', 'description'], 'safe'],
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
        $query = Nav::find()->orderBy('sort asc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'show' => $this->show,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
