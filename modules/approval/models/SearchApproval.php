<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\Approval;

/**
 * SearchApproval represents the model behind the search form about `app\modules\approval\models\Approval`.
 */
class SearchApproval extends Approval
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'process_id', 'progress', 'nowstep', 'status', 'eng_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'intro', 'create_user'], 'safe'],
            [['total', 'yet_money', 'pay'], 'number'],
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
        $query = Approval::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pid' => $this->pid,
            'process_id' => $this->process_id,
            'total' => $this->total,
            'yet_money' => $this->yet_money,
            'pay' => $this->pay,
            'progress' => $this->progress,
            'nowstep' => $this->nowstep,
            'status' => $this->status,
            'eng_id' => $this->eng_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'create_user', $this->create_user]);

        return $dataProvider;
    }
}
