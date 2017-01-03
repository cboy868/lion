<?php

namespace app\modules\cms\models\mods;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\cms\models\mods\Album6;

/**
 * Album6Search represents the model behind the search form about `app\modules\cms\models\mods\Album6`.
 */
class Album6Search extends Album6
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'category_id', 'thumb', 'sort', 'view_all', 'com_all', 'photo_num', 'recommend', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'intro', 'author'], 'safe'],
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
        $query = Album6::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author' => $this->author,
            'category_id' => $this->category_id,
            'thumb' => $this->thumb,
            'sort' => $this->sort,
            'view_all' => $this->view_all,
            'com_all' => $this->com_all,
            'photo_num' => $this->photo_num,
            'recommend' => $this->recommend,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
