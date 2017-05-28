<?php

namespace app\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\order\models\Delay;

/**
 * DelaySearch represents the model behind the search form about `app\modules\order\models\Delay`.
 */
class DelaySearch extends Delay
{
    public $uname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'user_id', 'created_by', 'is_verified', 'verified_by', 'verified_at', 'created_at', 'updated_at', 'status'], 'integer'],
            [['price'], 'number'],
            [['pre_dt', 'pay_dt', 'note', 'uname'], 'safe'],
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


    public function attributeLabels()
    {
        return [
            'uname' => '申请人',
        ] + parent::attributeLabels();
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
        $query = Delay::find()->orderBy('id desc');
        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'pre_dt' => $this->pre_dt,
            'pay_dt' => $this->pay_dt,
            'created_by' => $this->created_by,
            'is_verified' => $this->is_verified,
            'verified_by' => $this->verified_by,
            'verified_at' => $this->verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);
        $query->andFilterWhere(['like', 'user.username', $this->uname]);

        return $dataProvider;
    }
}
