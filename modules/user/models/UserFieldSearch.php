<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\user\models\UserField;

/**
 * UserFieldSearch represents the model behind the search form about `app\modules\user\models\UserField`.
 */
class UserFieldSearch extends UserField
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_show', 'order', 'created_at'], 'integer'],
            [['name', 'title', 'pop_note', 'html', 'option', 'default'], 'safe'],
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
        $query = UserField::find();

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'pop_note', $this->pop_note])
            ->andFilterWhere(['like', 'html', $this->html])
            ->andFilterWhere(['like', 'option', $this->option])
            ->andFilterWhere(['like', 'default', $this->default]);

        return $dataProvider;
    }
}
