<?php

namespace app\modules\approval\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\approval\models\ApprovalCam;

/**
 * SearchApprovalCam represents the model behind the search form about `app\modules\approval\models\ApprovalCam`.
 */
class SearchApprovalCam extends ApprovalCam
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'approval_id', 'pay_type', 'op_id', 'created_at', 'status', 'cam_user'], 'integer'],
            [['cam_no', 'note'], 'safe'],
            [['amount', 'paid'], 'number'],
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
        $query = ApprovalCam::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'approval_id' => $this->approval_id,
            'pay_type' => $this->pay_type,
            'op_id' => $this->op_id,
            'amount' => $this->amount,
            'paid' => $this->paid,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'cam_user' => $this->cam_user,
        ]);

        $query->andFilterWhere(['like', 'cam_no', $this->cam_no])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
