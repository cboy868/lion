<?php

namespace app\modules\news\controllers\home;

use app\modules\news\models\News;
use app\modules\news\models\NewsData;
use yii\data\Pagination;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;

class DefaultController extends \app\modules\home\controllers\DefaultController
{
    public function actionIndex()
    {
    	$cid = \Yii::$app->request->get('id');
    	$query = News::find()->where(['status'=>News::STATUS_NORMAL]);
    	if ($cid) {
    		$query->andWhere(['category_id'=>$cid]);
    	}

    	$count = $query->count();

		// 使用总数来创建一个分页对象
		$pagination = new Pagination(['totalCount' => $count]);


    	$items = $query->offset($pagination->offset)
					    ->limit($pagination->limit)
					    ->asArray()
					    ->all();


		foreach ($items as $k => &$v) {
            $v['cover'] = Attachment::getById($v['thumb'], '600x450');
        }unset($v);

        return $this->render('index', [
        		'list' =>$items,
        		'page' => $pagination
        	]);
    }

    public function actionView($id)
    {
    	$model = News::findOne($id);

    	if (!$model) {
    		return $this->error('文章不存在');
    	}
    	$body = NewsData::findOne($id);

    	$data = $model->toArray();

    	$data['cover'] = Attachment::getById($data['thumb']);
    	$data['body'] = $body->body;

        //取所有图片
        $thumbs = AttachmentRel::getByRes('news', $id, '660x450');

        $pre_id = News::find()->where(['<', 'id', $id])->max('id');
        $next_id = News::find()->where(['>', 'id', $id])->min('id');

        $data = [
            'data' => $data,
            'thumbs' => $thumbs
        ];

        if ($pre_id) {
            $data['pre'] = News::findOne($pre_id)->toArray();
        } 

        if ($next_id) {
            $data['next'] = News::findOne($next_id)->toArray();
        }

        $model->view_all = $model->view_all + 1;
        $model->save();

        return $this->render('view', $data);
    }
}
