<?php

namespace app\modules\wechat\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\wechat\models\Wechat;

/**
 * WechatSearch represents the model behind the search form about `app\modules\wechat\models\Wechat`.
 */
class WechatSearch extends Wechat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'status', 'created_at'], 'integer'],
            [['token', 'access_token', 'encodingaeskey', 'name', 'original', 'appkey', 'appsecret'], 'safe'],
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
        $query = Wechat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'level' => $this->level,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'encodingaeskey', $this->encodingaeskey])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'original', $this->original])
            ->andFilterWhere(['like', 'appkey', $this->appkey])
            ->andFilterWhere(['like', 'appsecret', $this->appsecret]);

        return $dataProvider;
    }
}
