<?php

namespace app\modules\focus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\focus\models\Focus;

/**
 * FocusSearch represents the model behind the search form about `app\modules\focus\models\Focus`.
 */
class FocusSearch extends Focus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'status'], 'integer'],
            [['title', 'link'], 'safe'],
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
        $query = Focus::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('sort asc'),
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
