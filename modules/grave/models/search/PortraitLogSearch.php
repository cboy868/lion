<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\PortraitLog;

/**
 * PortraitLogSearch represents the model behind the search form about `app\modules\grave\models\PortraitLog`.
 */
class PortraitLogSearch extends PortraitLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'portrait_id', 'op_id', 'tomb_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['action', 'img', 'note'], 'safe'],
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
        $query = PortraitLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'portrait_id' => $this->portrait_id,
            'op_id' => $this->op_id,
            'tomb_id' => $this->tomb_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
