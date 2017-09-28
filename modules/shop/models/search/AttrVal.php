<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AttrValSearch represents the model behind the search form about `shop\models\AttrVal`.
 */
class AttrVal extends \app\modules\shop\models\AttrVal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'attr_id', 'cover', 'status'], 'integer'],
            [['val'], 'safe'],
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
    public function search($params, $id=null)
    {
        $query = AttrVal::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $query->andFilterWhere(['attr_id'=>$id]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            // 'category_id' => $this->category_id,
            // 'attr_id' => $this->attr_id,
            'cover' => $this->cover,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'val', $this->val]);

        return $dataProvider;
    }
}
