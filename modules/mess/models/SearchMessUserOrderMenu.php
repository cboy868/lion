<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessUserOrderMenu;

/**
 * SearchMessUserOrderMenu represents the model behind the search form about `app\modules\mess\models\MessUserOrderMenu`.
 */
class SearchMessUserOrderMenu extends MessUserOrderMenu
{
    public $start;
    public $end;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mess_id', 'user_id', 'day_menu_id', 'menu_id', 'type',
                'is_pre', 'is_over', 'is_mobile', 'created_at', 'updated_at'], 'integer'],
            [['day_time','start','end'], 'safe'],
            [['real_price', 'num'], 'number'],
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
        $query = MessUserOrderMenu::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'mess_id' => $this->mess_id,
            'user_id' => $this->user_id,
            'day_menu_id' => $this->day_menu_id,
            'menu_id' => $this->menu_id,
            'real_price' => $this->real_price,
            'num' => $this->num,
            'type' => $this->type,
            'is_pre' => $this->is_pre,
            'is_over' => $this->is_over,
            'is_mobile' => $this->is_mobile,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);


        if ($this->start) {
            $start = $this->start;
            $query->andFilterWhere(['>=', 'day_time', $start]);
        }

        if ($this->end) {
            $end = date('Y-m-d',strtotime($this->end));
            $query->andFilterWhere(['<=', 'day_time', $end]);
        }

        return $dataProvider;
    }
}
