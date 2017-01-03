<?php

namespace app\modules\sys\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sys\models\ImageConfig;

/**
 * ImageConfigSearch represents the model behind the search form about `app\modules\sys\models\ImageConfig`.
 */
class ImageConfigSearch extends ImageConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_thumb', 'thumb_mode', 'is_water', 'water_opacity', 'water_pos', 'created_at'], 'integer'],
            [['res_name', 'thumb_config', 'water_image', 'water_text'], 'safe'],
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
        $query = ImageConfig::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_thumb' => $this->is_thumb,
            'thumb_mode' => $this->thumb_mode,
            'is_water' => $this->is_water,
            'water_opacity' => $this->water_opacity,
            'water_pos' => $this->water_pos,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'res_name', $this->res_name])
            ->andFilterWhere(['like', 'thumb_config', $this->thumb_config])
            ->andFilterWhere(['like', 'water_image', $this->water_image])
            ->andFilterWhere(['like', 'water_text', $this->water_text]);

        return $dataProvider;
    }
}
