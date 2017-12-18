<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\Tomb;

/**
 * TombSearch represents the model behind the search form about `app\modules\grave\models\Tomb`.
 */
class TombSearch extends Tomb
{
    public $customer_name; //<=====就是加在这里
    public $mobile; //<=====就是加在这里
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'grave_id', 'row', 'col', 'hole', 'user_id', 'customer_id',
                'agent_id', 'agency_id', 'guide_id', 'thumb', 'created_at', 'status'], 'integer'],
            [['special', 'tomb_no', 'sale_time', 'note', 'customer_name','mobile'], 'safe'],
            [['price', 'cost', 'area_total', 'area_use'], 'number'],
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
        $query = Tomb::find()->joinWith(['customer'])
            ->where(['not in','grave_tomb.status',[Tomb::STATUS_DELETE,Tomb::STATUS_RETURN]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('row asc, col asc'),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        $dataProvider->setSort([
            'attributes' => [
                /*  下面这段是加入的 */
                /*=============*/
                'customer_name' => [
                    'asc' => ['customer.name' => SORT_ASC],
                    'desc' => ['customer.name' => SORT_DESC],
                    'label' => '客户'
                ],
                /*=============*/
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'grave_tomb.id' => $this->id,
            'grave_id' => $this->grave_id,
            'row' => $this->row,
            'col' => $this->col,
            'hole' => $this->hole,
            'price' => $this->price,
            'cost' => $this->cost,
            'area_total' => $this->area_total,
            'area_use' => $this->area_use,
            'user_id' => $this->user_id,
            'agent_id' => $this->agent_id,
            'agency_id' => $this->agency_id,
            'grave_tomb.guide_id' => $this->guide_id,
            'sale_time' => $this->sale_time,
            'grave_tomb.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'special', $this->special])
            ->andFilterWhere(['like', 'tomb_no', $this->tomb_no])
            ->andFilterWhere(['like', 'note', $this->note]);
        $query->andFilterWhere(['like', '{{%grave_customer}}.name', $this->customer_name]) ;//<=====加入这句
        $query->andFilterWhere(['like', '{{%grave_customer}}.mobile', $this->mobile]) ;//<=====加入这句

        return $dataProvider;
    }

    public function searchWork($params)
    {
        $query = Tomb::find()->joinWith(['customer'])
            ->where(['not in','grave_tomb.status',[Tomb::STATUS_DELETE,Tomb::STATUS_RETURN]])
            ->orderBy('id desc');

        if (count($params)==0) {
            $query->andWhere(['<', 'grave_tomb.id', 0]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('row asc, col asc'),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        $dataProvider->setSort([
            'attributes' => [
                /*  下面这段是加入的 */
                /*=============*/
                'customer_name' => [
                    'asc' => ['customer.name' => SORT_ASC],
                    'desc' => ['customer.name' => SORT_DESC],
                    'label' => '客户'
                ],
                /*=============*/
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'grave_tomb.id' => $this->id,
            'grave_id' => $this->grave_id,
            'row' => $this->row,
            'col' => $this->col,
            'grave_tomb.guide_id' => $this->guide_id,
            'grave_tomb.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', '{{%grave_customer}}.name', $this->customer_name]) ;//<=====加入这句
        $query->andFilterWhere(['like', '{{%grave_customer}}.mobile', $this->mobile]) ;//<=====加入这句

        return $dataProvider;
    }




    public function minCol($params)
    {
        $query = Tomb::find();

        $query->andFilterWhere([
            'id' => $this->id,
            'grave_id' => $this->grave_id,
            'row' => $this->row,
            'col' => $this->col,
            'status' => $this->status,
        ]);

        return $query->min('col');
    }


    public static function searchTomb($params)
    {
        $searchModel = new self();
        $dataProvider = $searchModel->search($params);
        $models = $dataProvider->getModels();
        if (!$dataProvider) {
            return false;
        }

        $tomb_id = [];
        foreach ($models as $k => $v) {
            array_push($tomb_id, $v->id);
        }
        return $tomb_id;
    }

    public function searchMember($params)
    {
        $query = Tomb::find()->where(['<>','grave_tomb.status',Tomb::STATUS_DELETE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('row asc, col asc'),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'grave_tomb.id' => $this->id,
            'grave_id' => $this->grave_id,
            'row' => $this->row,
            'col' => $this->col,
            'hole' => $this->hole,
            'price' => $this->price,
            'cost' => $this->cost,
            'area_total' => $this->area_total,
            'area_use' => $this->area_use,
            'user_id' => $this->user_id,
            'agent_id' => $this->agent_id,
            'agency_id' => $this->agency_id,
            'grave_tomb.guide_id' => $this->guide_id,
            'sale_time' => $this->sale_time,
            'grave_tomb.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'special', $this->special])
            ->andFilterWhere(['like', 'tomb_no', $this->tomb_no])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }


}
