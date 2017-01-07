<?php

namespace app\modules\cms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\cms\models\Favor;

/**
 * FavorSearch represents the model behind the search form about `app\modules\cms\models\Favor`.
 */
class FavorSearch extends Favor
{
    public $uname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'res_id', 'created_at'], 'integer'],
            [['res_name', 'title', 'res_url', 'uname'], 'safe'],
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

        $query = Favor::find();
        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'res_id' => $this->res_id,
            'res_name' => $this->res_name,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            // ->andFilterWhere(['like', 'res_url', $this->res_url])
            ->andFilterWhere(['like', '{{%user}}.username', $this->uname]);

        return $dataProvider;
    }
}
