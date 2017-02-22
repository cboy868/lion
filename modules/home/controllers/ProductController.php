<?php

namespace app\modules\home\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods;
use app\modules\shop\models\search\Goods as GoodsSearch;
use app\core\models\Attachment;
use app\core\models\AttachmentRel;
use app\core\models\TagRel;
use app\modules\shop\models\AvRel;
use app\modules\shop\models\Message;
use app\modules\home\models\MsgForm;

class ProductController extends \app\core\web\HomeController
{
   
   public $layout = 'home.php';
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $cates = $this->getCates();
        $attrs = AvRel::attrs();

        return $this->render('@app/web/theme/site/product/index', [
            'cates'       => $cates,
            'attrs' => $attrs,
        ]);

    }


    public function actionView($id)
    {

        $model = Goods::findOne($id);

        $goods = $model->toArray();

        // $goods['small'] = Attachment::getById($goods['thumb'], '50*50');
        // $goods['middle'] = Attachment::getById($goods['thumb'], '425x350');
        // $goods['big'] = Attachment::getById($goods['thumb'], '600x730');

        $attr = $this->getAttr($model);

        $imgs = AttachmentRel::getByRes('goods', $id);


        $rels = $this->getSeries($id);


        return $this->render('view', [
            'data'=>$goods, 
            'attr'=> $attr['attr'], 
            'imgs'=>$imgs,
            'series' => $rels
            ]);
    }

    public function actionMsg($id)
    {

        $goods = Goods::findOne($id);
        $model = new MsgForm();
        $msg = Yii::$app->params['msg'];
        $msgs = explode("\r\n", $msg);

        $result = [];
        foreach ($msgs as $k => $v) {
            if (!$v) {
                continue;
            }
            $result[$v] = $v;
        }


        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['view', 'id' => $id]);
        } else {

            $model->title = '我对“'.$goods->name.'”很感兴趣';
            $model->goods_id = $id;
            return $this->render('msg', [
                'model' => $model,
                'shortmsg' => $result
            ]);
        }
    }

    /**
     * @name 取系列产品
     */
    private function getSeries($goods_id)
    {
        $rels = TagRel::getReleted('goods', $goods_id);

        $models = Goods::find()->where(['id'=>$rels])->asArray()->all();

        foreach ($models as &$v) {
            $v['img'] = Attachment::getById($v['thumb'], '200x200');
        }unset($v);


        return $models;
    }

    /**
     * @name 获取属性 
     */
    private function getAttr($model)
    {
        return AvRel::getAv($model);
    }


    private function getCates()
    {
        $tree = Category::sortTree();

        foreach ($tree as $k => &$v) {
            $v['url'] = Url::toRoute(['index', 'Goods[category_id]'=>$v['id']]);
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }



}
