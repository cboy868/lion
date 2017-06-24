<?php

namespace app\modules\news\controllers\home;

use app\core\helpers\ArrayHelper;
use app\core\models\TagRel;
use app\modules\news\models\News;
use app\modules\news\models\NewsData;
use app\modules\news\models\NewsPhoto;
use yii\data\Pagination;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;
use app\modules\news\models\Category;

/**
 * Class DefaultController
 * @package app\modules\news\controllers\home
 * @name 本分类列表及详情至少要分两种显示方式
 */
class DefaultController extends \app\core\web\HomeController
{
    public function actionIndex()
    {
    	$cid = \Yii::$app->request->get('cid');
    	$query = News::find()->where(['status'=>News::STATUS_NORMAL]);

    	$data = [];

    	if ($cid) {
    		$query->andWhere(['category_id'=>$cid]);
    		$category = Category::findOne($cid)->toArray();
    		$data['category'] = $category;
    	}
    	$data['cates'] = Category::find()->asArray()->all();

    	$count = $query->count();


		// 使用总数来创建一个分页对象
		$pagination = new Pagination(['totalCount' => $count, 'pageSize'=>10]);

    	$items = $query->offset($pagination->offset)
					    ->limit($pagination->limit)
					    ->asArray()
					    ->all();

		foreach ($items as $k => &$v) {
            $v['cover'] = NewsPhoto::getById($v['thumb'], '420x240');
            $v['tags'] = TagRel::getTagsByRes('news', $v['id']);
        }unset($v);

		$data['list'] = $items;
		$data['pagination'] = $pagination;

        return $this->render('index', $data);
    }

    public function actionView($id)
    {
    	$model = News::findOne($id);

    	if (!$model) {
    		return $this->error('文章不存在');
    	}

    	$method = News::types($model->type);

        $model->view_all = $model->view_all + 1;
        $model->save();

    	return $this->$method($model);
    }

    public function actionTags($id)
    {

        $data = TagRel::getResByTagId($id, 'news');
        $res = $data['provider'];

        $models = $res->getModels();

        $news_ids = ArrayHelper::getColumn($models, 'res_id');

        $news = News::find()->where(['id'=>$news_ids])->asArray()->all();

        foreach ($news as $k => &$v) {
            $v['cover'] = NewsPhoto::getById($v['thumb'], '880x350');
            $v['tags'] = TagRel::getTagsByRes('news', $v['id']);
        }unset($v);

        return $this->render('tags', [
            'list'=>$news,
            'pagination' => $res->getPagination(),
            'tag' => $data['tag']
        ]);
    }

    private function text($model)
    {
        $body = NewsData::findOne($model->id);

        if (!$body) {
            return $this->error('您访问的数据出现问题，请稍后尝试');
        }
        $data = $model->toArray();

        $data['cover'] = NewsPhoto::getById($data['thumb']);
        $data['body'] = $body->body;
        $data['tags'] = TagRel::getTagsByRes('news', $model->id);
        $cates = Category::find()->asArray()->all();
        $data = array_merge($data, $this->preAndNext($model));
        return $this->render('text',['data'=>$data, 'cates'=>$cates]);
    }

    private function image($model)
    {
        $data = $model->toArray();
        $data['cover'] = Attachment::getById($data['thumb']);
        //取所有图片
        $thumbs = AttachmentRel::getByRes('news', $id, '660x450');

        $data = [
            'data' => $data,
            'thumbs' => $thumbs
        ];
        $data['cates'] = Category::find()->asArray()->all();

        $data = array_merge($data, $this->preAndNext($model));

        return $this->render('image', $data);
    }

    private function video($model)
    {
        $data = $model->toArray();
        $data['cover'] = Attachment::getById($data['thumb']);
        $data = array_merge($data, $this->preAndNext($model));

        return $this->render('video', $data);
    }

    private function preAndNext($model)
    {
        $pre_id = News::find()->where(['<', 'id', $model->id])->max('id');
        $next_id = News::find()->where(['>', 'id', $model->id])->min('id');

        $data = [];
        if ($pre_id) {
            $data['pre'] = News::findOne($pre_id)->toArray();
        }

        if ($next_id) {
            $data['next'] = News::findOne($next_id)->toArray();
        }

        return $data;
    }


}
