<?php

namespace app\modules\mess\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\mess\models\MessReceptionMenu;

/**
 * SearchMessReceptionMenu represents the model behind the search form about `app\modules\mess\models\MessReceptionMenu`.
 */
class SearchMessReceptionMenu extends MessReceptionMenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day_menu_id', 'type', 'reception_id', 'status', 'created_at'], 'integer'],
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
        $query = MessReceptionMenu::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'day_menu_id' => $this->day_menu_id,
            'type' => $this->type,
            'reception_id' => $this->reception_id,
            'real_price' => $this->real_price,
            'num' => $this->num,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
