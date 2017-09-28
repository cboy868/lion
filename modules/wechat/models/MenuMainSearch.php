<?php

namespace app\modules\wechat\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\wechat\models\MenuMain;

/**
 * MenuMainSearch represents the model behind the search form about `app\modules\wechat\models\MenuMain`.
 */
class MenuMainSearch extends MenuMain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'is_active', 'gender', 'tag', 'client_platform_type', 'language', 'created_at', 'wid'], 'integer'],
            [['name', 'country', 'province', 'city'], 'safe'],
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
        $query = MenuMain::find();

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
            'wid'=> $this->wid,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'gender' => $this->gender,
            'tag' => $this->tag,
            'client_platform_type' => $this->client_platform_type,
            'language' => $this->language,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city]);

        return $dataProvider;
    }
}
