<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\AvRel as AvRelModel;

/**
 * AvRel represents the model behind the search form about `app\modules\shop\models\AvRel`.
 */
class AvRel extends AvRelModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'goods_id', 'attr_id', 'av_id', 'num', 'status'], 'integer'],
            [['price'], 'number'],
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
        $query = AvRelModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'goods_id' => $this->goods_id,
            'attr_id' => $this->attr_id,
            'av_id' => $this->av_id,
            'num' => $this->num,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
