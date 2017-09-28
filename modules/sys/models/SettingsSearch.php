<?php

namespace app\modules\sys\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sys\models\Settings;

/**
 * SettingsSearch represents the model behind the search form about `sys\models\Settings`.
 */
class SettingsSearch extends Settings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sname', 'svalue', 'svalues', 'sintro', 'stype', 'smodule'], 'safe'],
            [['sort'], 'integer'],
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
        $query = Settings::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'sname', $this->sname])
            ->andFilterWhere(['like', 'svalue', $this->svalue])
            ->andFilterWhere(['like', 'svalues', $this->svalues])
            ->andFilterWhere(['like', 'sintro', $this->sintro])
            ->andFilterWhere(['like', 'stype', $this->stype])
            ->andFilterWhere(['like', 'smodule', $this->smodule]);

        return $dataProvider;
    }
}
