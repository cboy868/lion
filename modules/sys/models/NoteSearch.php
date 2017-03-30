<?php

namespace app\modules\sys\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sys\models\Note;

/**
 * NoteSearch represents the model behind the search form about `app\modules\sys\models\Note`.
 */
class NoteSearch extends Note
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'res_id', 'user_id', 'status', 'created_at'], 'integer'],
            [['res_name', 'content'], 'safe'],
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
        $query = Note::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'res_id' => $this->res_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
