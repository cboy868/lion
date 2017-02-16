<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\InsLog;

/**
 * InsLogSearch represents the model behind the search form about `app\modules\grave\models\InsLog`.
 */
class InsLogSearch extends InsLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ins_id', 'op_id', 'tomb_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['action', 'img', 'content'], 'safe'],
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
        $query = InsLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'ins_id' => $this->ins_id,
            'op_id' => $this->op_id,
            'tomb_id' => $this->tomb_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
