<?php

namespace app\modules\shop\controllers\home;

use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;
use yii\data\Pagination;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;

class DefaultController extends \app\core\web\HomeController
{
	/**
	 * @name 商品聚合页面
	 */
    public function actionIndex()
    {
        $cid = \Yii::$app->request->get('id');
        $query = Goods::find()->where(['status' => Goods::STATUS_ACTIVE]);
        if ($cid) {
            $query->andWhere(['category_id'=>$cid]);
        }

        $cnt = $query->count();
        $pagination = new Pagination(['totalCount'=>$cnt, 'pageSize'=>24]);
        $list = $query->offset($pagination->offset)
                      ->limit($pagination->limit)
                      ->asArray()
                      ->all();

        foreach ($list as $k => &$v) {
            $v['cover'] = Attachment::getById($v['thumb'], '160x120');
        }unset($v);


        if ($cid) {
            $cate = Category::findOne($cid)->toArray();
            return $this->render('list', [//如果有分类预定，则只显示此分类下的商品
                'list' => $list,
                'cate' => $cate,
                'pagination' => $pagination
            ]);
        }

        return $this->render('index', [
                'list' => $list,
                'pagination' => $pagination
            ]);
    }

    /**
     * @name 商品列表页面
     */
    public function actionList()
    {
        return $this->render('list');
    }

    /**
     * @name 商品详情页面
     */
    public function actionView($id)
    {
        $model = Goods::findOne($id)->toArray();

        $model['cover'] = Attachment::getById($model['thumb']);

        //取所有图片
        $thumbs = AttachmentRel::getByRes('goods', $id, '660x450');

        $pre_id = Goods::find()->where(['<', 'id', $id])->max('id');
        $next_id = Goods::find()->where(['>', 'id', $id])->min('id');

        $data = [
            'data' => $model,
            'thumbs' => $thumbs,
        ];

        if ($pre_id) {
            $data['pre'] = Goods::findOne($pre_id)->toArray();
        } 

        if ($next_id) {
            $data['next'] = Goods::findOne($next_id)->toArray();
        }
        return $this->render('view', $data);
    }
}
