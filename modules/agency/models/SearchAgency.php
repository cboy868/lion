<?php

namespace app\modules\agency\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\agency\models\Agency;

/**
 * SearchAgency represents the model behind the search form about `app\modules\agency\models\Agency`.
 */
class SearchAgency extends Agency
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_real', 'category', 'thumb', 'leader', 'guide', 'created_at', 'status'], 'integer'],
            [['title', 'mobile', 'phone', 'kefu_qq', 'addr', 'intro'], 'safe'],
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
        $query = Agency::find()->andWhere(['status'=>self::STATUS_NORMAL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_real' => $this->is_real,
            'category' => $this->category,
            'thumb' => $this->thumb,
            'leader' => $this->leader,
            'guide' => $this->guide,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'kefu_qq', $this->kefu_qq])
            ->andFilterWhere(['like', 'addr', $this->addr])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
