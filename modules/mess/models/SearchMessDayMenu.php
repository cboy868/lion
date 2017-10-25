<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessDayMenu;

/**
 * SearchMessDayMenu represents the model behind the search form about `app\modules\mess\models\MessDayMenu`.
 */
class SearchMessDayMenu extends MessDayMenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'menu_id', 'type', 'is_special', 'mess_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['day_time'], 'safe'],
            [['real_price', 'check_price'], 'number'],
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
        $query = MessDayMenu::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'day_time' => $this->day_time,
            'menu_id' => $this->menu_id,
            'real_price' => $this->real_price,
            'check_price' => $this->check_price,
            'type' => $this->type,
            'is_special' => $this->is_special,
            'mess_id' => $this->mess_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
