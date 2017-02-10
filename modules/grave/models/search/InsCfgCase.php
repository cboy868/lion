<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\InsCfgCase as InsCfgCaseModel;

/**
 * InsCfgCase represents the model behind the search form about `app\modules\grave\models\InsCfgCase`.
 */
class InsCfgCase extends InsCfgCaseModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cfg_id', 'num', 'width', 'height', 'status', 'sort'], 'integer'],
            [['img', 'add_time'], 'safe'],
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
        $query = InsCfgCaseModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cfg_id' => $this->cfg_id,
            'num' => $this->num,
            'width' => $this->width,
            'height' => $this->height,
            'status' => $this->status,
            'sort' => $this->sort,
            'add_time' => $this->add_time,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
