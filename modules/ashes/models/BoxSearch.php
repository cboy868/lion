<?php

namespace app\modules\ashes\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\ashes\models\Box;

/**
 * BoxSearch represents the model behind the search form about `app\modules\ashes\models\Box`.
 */
class BoxSearch extends Box
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'log_id', 'box_no', 'area_id', 'row', 'col', 'status'], 'integer'],
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
        $query = Box::find()->andWhere(['status'=>[self::STATUS_EMPTY,self::STATUS_FULL]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'log_id' => $this->log_id,
            'box_no' => $this->box_no,
            'area_id' => $this->area_id,
            'row' => $this->row,
            'col' => $this->col,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
