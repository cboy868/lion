<?php

namespace app\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\shop\models\Cart as CartModel;

/**
 * Cart represents the model behind the search form about `app\modules\shop\models\Cart`.
 */
class Cart extends CartModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'goods_id', 'sku_id', 'num', 'created_at'], 'integer'],
            [['wechat_uid'], 'safe'],
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
        $query = CartModel::find();

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
            'id' => $this->id,
            'type' => $this->type,
            'goods_id' => $this->goods_id,
            'sku_id' => $this->sku_id,
            'num' => $this->num,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'wechat_uid', $this->wechat_uid]);

        return $dataProvider;
    }
}
