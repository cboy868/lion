<?php

namespace app\modules\memorial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\memorial\models\Memorial;

/**
 * MemorialSearch represents the model behind the search form about `app\modules\memorial\models\Memorial`.
 */
class MemorialSearch extends Memorial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'tomb_id', 'privacy', 'view_all', 'com_all', 'tpl', 'status', 'updated_at', 'created_at'], 'integer'],
            [['title', 'thumb', 'intro'], 'safe'],
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
        $query = Memorial::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'tomb_id' => $this->tomb_id,
            'privacy' => $this->privacy,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'tpl' => $this->tpl,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
