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
    public $tag;
    public $type = 3;//文字 2图片 3video
    public $video_author;//视频作者
    public $video;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['category_id', 'type'], 'integer'],
            [['summary'], 'string'],
            [['title', 'subtitle', 'video'], 'string', 'max' => 255],
            [['author','video_author'], 'string', 'max' => 100],
            [['source', 'tag'], 'string', 'max' => 200],
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
            'video_author' => '图片作者',
            'source' => '来源',
            'thumb' => '封面图',
            'tag' => '标签',
            'video'=> '视频地址',
        ];
    }

}
