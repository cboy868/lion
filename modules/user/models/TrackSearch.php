<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\user\models\Track;

/**
 * TrackSearch represents the model behind the search form about `app\modules\user\models\Track`.
 */
class TrackSearch extends Track
{
    public $user_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'res_id', 'user_id', 'y', 'm', 'd', 'h', 'w', 'created_at'], 'integer'],
            [['res_name', 'ip'], 'safe'],
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
        $query = Track::find()->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'res_id' => $this->res_id,
            'user_id' => $this->user_id,
            'y' => $this->y,
            'm' => $this->m,
            'd' => $this->d,
            'h' => $this->h,
            'w' => $this->w,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
