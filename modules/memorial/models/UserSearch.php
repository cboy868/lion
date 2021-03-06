<?php

namespace app\modules\memorial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\memorial\models\User;

/**
 * UserSearch represents the model behind the search form about `app\modules\memorial\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'memorial_id', 'status', 'created_at'], 'integer'],
            [['relation', 'note'], 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'memorial_id' => $this->memorial_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'relation', $this->relation])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
