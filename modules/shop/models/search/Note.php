<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\Note;

/**
 * NoteSearch represents the model behind the search form about `modules\shop\models\Note`.
 */
class Note extends \app\modules\shop\models\Note
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mid', 'user_id', 'created_at', 'status'], 'integer'],
            [['intro', 'end'], 'safe'],
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

        $query->andFilterWhere(['mid'=>Yii::$app->user->identity->mid]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'mid' => $this->mid,
            'user_id' => $this->user_id,
            'end' => $this->end,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
