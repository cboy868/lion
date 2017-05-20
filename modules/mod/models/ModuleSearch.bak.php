<?php

namespace app\modules\mod\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mod\models\Module;

/**
 * ModuleSearch represents the model behind the search form about `app\modules\mod\models\Module`.
 */
class ModuleSearch extends Module
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order', 'show', 'created_at'], 'integer'],
            [['module', 'name', 'dir', 'link', 'logo'], 'safe'],
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
        $query = Module::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order' => $this->order,
            'show' => $this->show,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'dir', $this->dir])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}
