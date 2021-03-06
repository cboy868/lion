<?php

namespace app\modules\wechat\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\wechat\models\User;
use app\modules\wechat\models\TagRel;

/**
 * UserSearch represents the model behind the search form about `app\modules\wechat\models\User`.
 */
class UserSearch extends User
{
    public $tagid;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'user_id', 'sex', 'subscribe', 'subscribe_at', 'created_at'], 'integer'],
            [['openid', 'nickname', 'remark', 'language', 'city', 'province', 'country', 'headimgurl',
                'realname', 'mobile', 'birth', 'addr', 'tagid'], 'safe'],
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
        $query = User::find()->orderBy('id desc');
        $query->joinWith(['tagRel']);

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
            'gid' => $this->gid,
            'user_id' => $this->user_id,
            'sex' => $this->sex,
            'subscribe' => $this->subscribe,
            'subscribe_at' => $this->subscribe_at,
            'created_at' => $this->created_at,
            'birth' => $this->birth,
            TagRel::tableName() . '.tag_id'=>$this->tagid

        ]);

        $query->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
//            ->andFilterWhere(['like', 'remark', $this->remark])
//            ->andFilterWhere(['like', 'language', $this->language])
//            ->andFilterWhere(['like', 'city', $this->city])
//            ->andFilterWhere(['like', 'province', $this->province])
//            ->andFilterWhere(['like', 'country', $this->country])
//            ->andFilterWhere(['like', 'headimgurl', $this->headimgurl])
            ->andFilterWhere(['like', 'realname', $this->realname])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'addr', $this->addr]);

//        echo $query->createCommand()->getRawSql();
        return $dataProvider;
    }
}
