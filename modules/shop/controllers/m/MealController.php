<?php

namespace app\modules\shop\controllers\m;

use yii;
use yii\data\Pagination;
use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;


use app\modules\shop\models\Category;
use app\modules\shop\models\Sku;
use app\modules\shop\models\Note;
use app\modules\shop\models\Goods;
use app\modules\shop\models\MixRel;
use app\modules\shop\models\Process;

class MealController extends Controller
{
	/**
	 * @name 点餐页面
	 */
    public function actionIndex()
    {


    	$notes = Note::all();
        $cates = Category::find()->orderBy('sort asc')->asArray()->indexBy('id')->all();
        $goods = $this->search($cates);
        $mix = MixRel::rels();

        $result = [];
        foreach ($goods as $k => $v) {
            $result[$v['category_id']][] = $v;

        }

        return $this->render('index', [
                'cates' => $cates,
                'notes' => $notes,
                'goods' => $result,
                'get'   => $_GET,
                'mix'   => $mix
            ]);

    }

    public function actionView($id)
    {

        $meal = Goods::findOne($id);

        // p($meal);die;

        $rel = MixRel::find()->where(['goods_id'=>$id])->all();
        $process = Process::find()->where(['goods_id'=>$id])->orderBy('step asc')->asArray()->all();

        foreach ($process as $k => &$v) {
            $v['thumb'] = Attachment::getById($v['thumb']);

        }unset($v);

        $rels = [];
        foreach ($rel as $k => &$v) {
            $rels[$v['type']][$v['mix_id']] = ArrayHelper::toArray($v);
            $rels[$v['type']][$v['mix_id']]['mix_name'] = $v->mix->name;
        }unset($v);




        $meal['thumb'] = Attachment::getById($meal['thumb']);

    	return $this->render('view',[
            'meal' => $meal,
            'rel' => $rels,
            'process' => $process
        ]);
    }


    public function actionProfile()
    {
    	return $this->render('profile');
    }


    public function actionSetting()
    {
    	return $this->render('setting');
    }



    protected function search($cates)
    {
        $goods_ids = $this->parseFilter();

        $category_id = Yii::$app->getRequest()->get('cate');

        if (!$category_id) {
            $cate = array_shift($cates);
            $category_id = $_GET['cate'] = $cate['id'];
        }


        $query = Goods::find()->where(['status'=>Goods::STATUS_ACTIVE])
                              // ->andWhere(['category_id'=>$category_id])
                              ->andFilterWhere(['id'=>$goods_ids]);
        $countQuery = clone $query;

        $pages = new Pagination(['totalCount'=>$countQuery->count(), 'pageSize'=> 500]);
    
        $goods = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        $thumbs = ArrayHelper::getColumn($goods, 'thumb');
        $thumbs = Attachment::find()->where(['id'=>$thumbs])->indexBy('id')->asArray()->all();


        $goods_ids = ArrayHelper::getColumn($goods, 'id');
        //根据goods找sku
        $sku = Sku::find()->where(['goods_id'=>$goods_ids])->asArray()->all();
        $sku = ArrayHelper::index($sku, 'id', 'goods_id');

        
        foreach ($goods as &$v) {

            $v['sku'] = isset($sku[$v['id']]) ? $sku[$v['id']] :'';
            $v['thumb'] = Attachment::getById($v['thumb'], '100x100', '');
            

            // if (empty($v['cover'])) {
            //     $v['img'] = '';
            //     continue;
            // }
            // $co = $thumbs[$v['cover']];
            // $v['img'] = $co['path'] . '/small_' . $co['name'];
        }unset($v);


        return $goods;

    }

    public function parseFilter()
    {
        $filter = Yii::$app->getRequest()->get('filter');

        if (!$filter) {
            return ;
        }

        $filters = explode(',', $filter);

        $datas = AvRel::find()->where(['av_id'=>$filters])->select('goods_id')->distinct('goods_id')->asArray()->all();

        if ($datas) {
            return ArrayHelper::getColumn($datas, 'goods_id');
        } else {
            return false;
        }


    }
}
