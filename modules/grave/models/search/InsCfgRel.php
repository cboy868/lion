<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\InsCfgRel as InsCfgRelModel;

/**
 * InsCfgRel represents the model behind the search form about `app\modules\grave\models\InsCfgRel`.
 */
class InsCfgRel extends InsCfgRelModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grave_id', 'cfg_id'], 'integer'],
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
        $query = InsCfgRelModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'grave_id' => $this->grave_id,
            'cfg_id' => $this->cfg_id,
        ]);

        return $dataProvider;
    }
}
