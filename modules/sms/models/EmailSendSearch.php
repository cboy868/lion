<?php

namespace app\modules\sms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sms\models\EmailSend;

/**
 * EmailSendSearch represents the model behind the search form about `app\modules\sms\models\EmailSend`.
 */
class EmailSendSearch extends EmailSend
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at'], 'integer'],
            [['email', 'msg', 'time'], 'safe'],
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
        $query = EmailSend::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'time' => $this->time,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'msg', $this->msg]);

        return $dataProvider;
    }
}
