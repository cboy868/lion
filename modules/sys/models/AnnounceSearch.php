<?php

namespace app\modules\sys\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sys\models\Announce;

/**
 * AnnounceSearch represents the model behind the search form about `app\modules\sys\models\Announce`.
 */
class AnnounceSearch extends Announce
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'type', 'view_num', 'created_at', 'status'], 'integer'],
            [['title', 'content', 'author', 'start', 'end'], 'safe'],
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
        $query = Announce::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'start' => $this->start,
            'end' => $this->end,
            'type' => $this->type,
            'view_num' => $this->view_num,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'author', $this->author]);

        return $dataProvider;
    }
}
