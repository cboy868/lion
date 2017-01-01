<?php

namespace app\modules\sys\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sys\models\Set;

/**
 * SetSearch represents the model behind the search form about `app\models\Set`.
 */
class SetSearch extends Set
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sname', 'svalue', 'svalues', 'sintro', 'stype', 'smodule'], 'safe'],
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
        $query = Set::find()->orderBy('smodule asc, sort asc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'sname', $this->sname])
            ->andFilterWhere(['like', 'svalue', $this->svalue])
            ->andFilterWhere(['like', 'svalues', $this->svalues])
            ->andFilterWhere(['like', 'sintro', $this->sintro])
            ->andFilterWhere(['like', 'stype', $this->stype])
            ->andFilterWhere(['like', 'smodule', $this->smodule]);
        return $dataProvider;
    }
}
