<?php

namespace app\modules\sys\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sys\models\Msg;

/**
 * MsgSearch represents the model behind the search form about `app\modules\sys\models\Msg`.
 */
class MsgSearch extends Msg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'msg_type', 'res_id', 'tid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['msg', 'msg_time', 'res_name'], 'safe'],
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
        $query = Msg::find()->orderBy('id desc');

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
            'msg_type' => $this->msg_type,
            'msg_time' => $this->msg_time,
            'res_id' => $this->res_id,
            'tid' => $this->tid,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'msg', $this->msg])
            ->andFilterWhere(['like', 'res_name', $this->res_name]);

        return $dataProvider;
    }
}
