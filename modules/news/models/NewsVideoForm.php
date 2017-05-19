<?php

namespace app\modules\news\models;


use Yii;
use yii\base\Model;
/**
 * ContactForm is the model behind the contact form.
 */
class NewsVideoForm extends Model
{
    public $category_id;
    public $title;
    public $subtitle;
    public $summary;
    public $author;
    public $source;
    public $thumb;
    public $type = 3;//文字 2图片 3video
    public $video_author;//视频作者
    public $video;
    public $tags;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'video'], 'required'],
            [['category_id', 'type'], 'integer'],
            [['summary'], 'string'],
            [['title', 'subtitle', 'video'], 'string', 'max' => 255],
            [['author','video_author'], 'string', 'max' => 100],
            [['source', 'tags'], 'string', 'max' => 200],
            [['thumb'], 'safe']
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
            'video_author' => '视频作者',
            'source' => '来源',
            'thumb' => '封面图',
            'video'=> '视频地址',
            'tags' => '标签/关键词',
        ];
    }



    /**
     * @name 保存
     */
    public function save()
    {
        $model = new News();

        $uname = Yii::$app->user->identity->username;

        $model->category_id = $this->category_id;
        $model->title = $this->title;
        $model->subtitle = $this->subtitle;
        $model->summary = $this->summary;
        $model->author = $this->author ? $this->author : $uname;
        $model->video_author = $this->video_author ? $this->video_author : $uname;
        $model->source = $this->source;
        $model->thumb = $this->thumb;
        // $model->tag = $this->tag;
        $model->type = $this->type;
        $model->created_by = Yii::$app->user->id;
        $model->video = $this->video;
        $model->save();

        return $model;

    }

}


