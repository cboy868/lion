<?php

namespace app\modules\sys\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sys\models\OpLog;

/**
 * OpLogSearch represents the model behind the search form about `app\modules\sys\models\OpLog`.
 */
class OpLogSearch extends OpLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'user_id'], 'integer'],
            [['table_name', 'route', 'description'], 'safe'],
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
        $query = OpLog::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
