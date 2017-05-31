<?php

namespace app\modules\news\controllers\home;

use app\modules\news\models\News;
use app\modules\news\models\NewsData;
use yii\data\Pagination;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;

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
    	if ($cid) {
    		$query->andWhere(['category_id'=>$cid]);
    	}

    	$count = $query->count();

		// 使用总数来创建一个分页对象
		$pagination = new Pagination(['totalCount' => $count, 'pageSize'=>6]);

    	$items = $query->offset($pagination->offset)
					    ->limit($pagination->limit)
					    ->asArray()
					    ->all();

		foreach ($items as $k => &$v) {
            $v['cover'] = Attachment::getById($v['thumb'], '600x450');
        }unset($v);

        return $this->render('index', [
        		'list' =>$items,
        		'pagination' => $pagination
        	]);
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

    private function text($model)
    {
        $body = NewsData::findOne($model->id);

        if (!$body) {
            return $this->error('您访问的数据出现问题，请稍后尝试');
        }
        $data = $model->toArray();

        $data['cover'] = Attachment::getById($data['thumb']);
        $data['body'] = $body->body;
        $data = array_merge($data, $this->preAndNext($model));
        return $this->render('text',$data);
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
