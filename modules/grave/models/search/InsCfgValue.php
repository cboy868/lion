<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\InsCfgValue as InsCfgValueModel;

/**
 * InsCfgValue represents the model behind the search form about `app\modules\grave\models\InsCfgValue`.
 */
class InsCfgValue extends InsCfgValueModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'case_id', 'sort', 'size', 'x', 'y', 'direction'], 'integer'],
            [['mark', 'color', 'text', 'add_time'], 'safe'],
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
        $query = InsCfgValueModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'case_id' => $this->case_id,
            'sort' => $this->sort,
            'size' => $this->size,
            'x' => $this->x,
            'y' => $this->y,
            'direction' => $this->direction,
            'add_time' => $this->add_time,
        ]);

        $query->andFilterWhere(['like', 'mark', $this->mark])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
