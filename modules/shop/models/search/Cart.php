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
    public $uname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'goods_id', 'sku_id', 'num', 'created_at'], 'integer'],
            [['uname'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'uname' => '用户名',
        ] + parent::attributeLabels();
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
        $query->joinWith(['user']);

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
            'user_id' => $this->user_id,
            'type' => $this->type,
            'goods_id' => $this->goods_id,
            'sku_id' => $this->sku_id,
            'num' => $this->num,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->uname]);

        return $dataProvider;
    }
}
