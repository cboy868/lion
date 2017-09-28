<?php

namespace app\modules\grave\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\grave\models\FreeDead as FreeDeadModel;

/**
 * FreeDead represents the model behind the search form about `app\modules\grave\models\FreeDead`.
 */
class FreeDead extends FreeDeadModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'free_id', 'is_confirm', 'op_user', 'status', 'created_at'], 'integer'],
            [['contact_user', 'contact_mobile', 'dead', 'relation', 'confirm_at', 'note'], 'safe'],
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

        $query = FreeDeadModel::find()->where(['status'=>self::STATUS_NORMAL])
            ->orderBy('id desc');

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
            'free_id' => $this->free_id,
            'is_confirm' => $this->is_confirm,
            'op_user' => $this->op_user,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'confirm_at' => $this->confirm_at,
        ]);

        $query->andFilterWhere(['like', 'contact_user', $this->contact_user])
            ->andFilterWhere(['like', 'contact_mobile', $this->contact_mobile])
            ->andFilterWhere(['like', 'dead', $this->dead])
            ->andFilterWhere(['like', 'relation', $this->relation])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
