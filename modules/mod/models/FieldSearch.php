<?php

namespace app\modules\mod\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mod\models\Field;

/**
 * FieldSearch represents the model behind the search form about `app\modules\mod\models\Field`.
 */
class FieldSearch extends Field
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_show', 'order', 'created_at'], 'integer'],
            [['table', 'name', 'title', 'pop_note', 'html', 'option', 'default'], 'safe'],
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
        $query = Field::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_show' => $this->is_show,
            'order' => $this->order,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'table', $this->table])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'pop_note', $this->pop_note])
            ->andFilterWhere(['like', 'html', $this->html])
            ->andFilterWhere(['like', 'option', $this->option])
            ->andFilterWhere(['like', 'default', $this->default]);

        return $dataProvider;
    }
}
