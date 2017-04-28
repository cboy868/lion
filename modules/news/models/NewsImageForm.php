<?php

namespace app\modules\news\models;


use Yii;
use yii\base\Model;
/**
 * ContactForm is the model behind the contact form.
 */
class NewsImageForm extends Model
{
    public $category_id;
    public $title;
    public $subtitle;
    public $summary;
    public $author;
    public $source;
    public $thumb;
    public $tag;
    public $type = 2;//文字 2图片 3video
    public $pic_author;//图片作者
    public $images;
    public $id=0;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['category_id', 'type', 'id'], 'integer'],
            [['summary'], 'string'],
            [['title', 'subtitle'], 'string', 'max' => 255],
            [['author','pic_author'], 'string', 'max' => 100],
            [['source', 'tag'], 'string', 'max' => 200],
            [['thumb', 'images'], 'safe']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'category_id' => '分类',
            'title'     => '标题',
            'subtitle' => '副标题',
            'summary' => '概要',
            'author' => '作者',
            'pic_author' => '图片作者',
            'source' => '来源',
            'thumb' => '封面图',
            'tag' => '标签',
        ];
    }

    public function save()
    {

        $model = new News();
        $post = Yii::$app->request->post();
        $uname = Yii::$app->user->identity->username;
        $model->category_id = $this->category_id;
        $model->title = $this->title;
        $model->subtitle = $this->subtitle;
        $model->summary = $this->summary;
        $model->author = $this->author ? $this->author : $uname;
        $model->source = $this->source;
        $model->thumb = $this->thumb;
        // $model->tag = $this->tag;
        $model->pic_author = $this->pic_author ? $this->pic_author : $uname;
        $model->type = $this->type;
        $model->created_by = Yii::$app->user->id;


        if (isset($post['cover'])) {
            $model->thumb = $post['cover'];
        } else if(isset($post['mid'])){
            $model->thumb = $post['mid'][0];
        } else {
            $model->thumb = 0;
        }

        $model->save();

        if (isset($post['mid'])) {

            $title = $post['title'];
            $intro = $post['intro'];
            $mid = $post['mid'];

            foreach ($mid as $k => $v) {
                $data[$v] = [
                    'news_id' => $model->id,
                    'title' => isset($title[$k]) ? $title[$k] : '',
                    'body'  => isset($intro[$k]) ? $intro[$k] : '',
                ];

                $pt = NewsPhoto::findOne($v);
                if ($pt) {
                    $pt->load($data[$v], '');
                    $pt->save();
                }
            }
        }

        return $model;
    }

}
