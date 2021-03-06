<?php

namespace app\modules\shop\controllers\admin;

use app\modules\shop\models\LgGoods;
use Yii;
use app\modules\shop\models\Goods;
use app\modules\shop\models\search\Goods as GoodsSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\shop\models\Category;
use app\core\helpers\Url;
use app\core\helpers\ArrayHelper;
use app\core\models\AttachmentRel;
use app\core\models\Attachment;
use app\core\models\TagRel;
use app\modules\shop\models\Type;
use app\modules\shop\models\Attr;
use app\modules\shop\models\AttrVal;
use app\modules\shop\models\AvRel;
use app\modules\shop\models\Sku;
use app\core\helpers\Pinyin;
use app\modules\shop\models\BagRel;
use yii\base\Model;
/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'web-upload' => [
                'class' => 'app\core\web\WebuploadAction',
            ],
            'ue-upload' => [
                'class' => 'app\core\widgets\Ueditor\UploadAction',
            ],
            'kupload' => [
                'class' => 'app\core\widgets\kindeditor\KindEditorAction',
            ]
        ];
    }


    /**
     * Lists all Goods models.
     * @return mixed
     * @name 产品管理
     */
    public function actionIndex($i18n=false, $id=null)
    {
        $searchModel = new GoodsSearch();

        $params = Yii::$app->request->queryParams;

        if (isset($params['category_id'])) {
            $params["Goods"]['category_id'] = $params['category_id'];
        }

        $dataProvider = $searchModel->search($params);
//
//        $models = $dataProvider->getModels();
//        $page = $dataProvider->getPagination();

        $cates = $this->getCates();


        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates'       => $cates,
            'i18n' => $i18n,
            'i18n_flag' => Yii::$app->params['i18n']['flag'],
            'current_cate' => Yii::$app->getRequest()->get('category_id')
        ];

        if (!empty($id)) {
            $data['model'] = Goods::findOne($id);
        }

        return $this->render('index', $data);
    }

    private function getCates()
    {
        $tree = Category::sortTree();

        foreach ($tree as $k => &$v) {
            $v['url'] = Url::toRoute(['index', 'category_id'=>$v['id']]);
        }

        $tree = \yii\helpers\ArrayHelper::index($tree, 'id');
        $tree = \app\core\helpers\Tree::recursion($tree,0,1);

        return $tree;
    }

    public function actionUpdateCate($id)
    {
        $model = Goods::findOne($id);


        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['/shop/admin/goods/update', 'id'=>$id]);
        }

        return $this->renderAjax('update-cate', ['model'=>$model]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     * @name 产品详情
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        //获取图片
        $imgs = AttachmentRel::getByRes('goods', $id);

        //获取属性
        $attrs = $model->getAv();

        //取sku
        $sku = $model->sku;
        $sku = ArrayHelper::index($sku, 'av');

        return $this->render('view', [
            'model' => $model,
            'imgs'  => $imgs,
            'avs'   => $attrs,
            'sku'   => $sku,
            // 'tags'  => $tags
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @name 添加商品
     */
    public function actionCreate($category_id)
    {

        $req = Yii::$app->request;

        $info = $req->post();

        // $this->layout =
        $model = new Goods();


        if ($model->load($info) && $model->save()) {
            $outerTransaction = Yii::$app->db->beginTransaction();

             try {

                if (!$model->serial) {
                   $serial = 'L%sT%s';
                    $model->serial = sprintf($serial, str_pad($model->category_id, 3, '0', STR_PAD_LEFT), str_pad($model->id, 4, '0', STR_PAD_LEFT));
                }
                $model->pinyin=Pinyin::py($model->name);
                $model->save();

                 $this->tagCreate($info['Goods']['tags'], $model->id);

                 if (isset($info['mid']) && count($info['mid']) > 0) {
                    $mids = $info['mid'];
                    $titles = $info['title'];

                    foreach ($mids as $k => $v) {
                        AttachmentRel::updateResId('goods', $v, $model->id, $titles[$k]);
                    }
                    $model->thumb = array_shift($mids);
                    $model->save();
                    
                }

                $sku = $req->post('sku');
                $price = $sku['price'];
                $num = $sku['num'];
                $original_price = $sku['original_price'];

                if ($num && count(array_filter($num))>0) {
                    $num = array_filter($num);
                    $sku_md = [];
                    $sku_model = new Sku;
                    $i = 1;;
                    foreach ($num as $k => $v) {

                        //处理规格名
                        $k = trim($k, ';');
                        $spec = explode(';', $k);

                        $spe = [];
                        foreach ($spec as $ke => $va) {
                            $sub = explode(':', $va);
                            $spe[] = $sub[1];
                        }
                        $specs = AttrVal::find()->where(['id'=>$spe])->asArray()->all();
                        $spec_name = implode('',ArrayHelper::getColumn($specs, 'val'));

                        $sku_md[$k] = clone $sku_model;

                        $sku_md[$k]->goods_id = $model->id;
                        $sku_md[$k]->price = $price[$k] ? $price[$k] : $model->price;
                        $sku_md[$k]->original_price = $original_price[$k] ? $original_price[$k] : $model->original_price;

                        $sku_md[$k]->name = $spec_name;
                        $sku_md[$k]->av = $k;
                        $sku_md[$k]->num = $num[$k];
                        $sku_md[$k]->serial = $model->serial . sprintf('P%s', str_pad($i,5,'0',STR_PAD_LEFT));
                        $sku_md[$k]->save();
                    }

                    $i++;

                } else {
                    $sku_model = new Sku;
                    $sku_model->goods_id = $model->id;
                    $sku_model->price = $model->price;
                    $sku_model->original_price = $model->original_price;
                    $sku_model->name = $model->name;
                    $sku_model->av = '0:0';
                    $sku_model->serial = $model->serial . sprintf('P%s', str_pad(1,5,'0',STR_PAD_LEFT));
                    $sku_model->save();
                }


                $result = AvRel::parsePost($model->category_id, $model->id);

                if ($result) {
                    Yii::$app->db->createCommand()->batchInsert(
                        AvRel::tableName(), 
                        ['attr_id','av_id','value', 'category_id', 'goods_id'], 
                        $result
                    )->execute();
                }

                $outerTransaction->commit();

             } catch (\Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
                 
             }

            $i18n = Yii::$app->params['i18n'];
            if ($i18n['flag']) {
                return $this->redirect(['index', 'i18n'=>true, 'id'=>$model->id]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {

        $cate = Category::findOne($category_id);

        //获取属性
        $attrs = Attr::find()->where([
                'type_id'=>$cate->type_id, 
                'status'=>Attr::STATUS_ACTIVE,
                'is_spec' => Attr::SPEC_NO
            ])->all();



        //规格
        $specs = Attr::find()->where([
                'type_id'=>$cate->type_id, 
                'status'=>Attr::STATUS_ACTIVE,
                'is_spec' => ATTR::SPEC_YES
            ])->indexBy('id')->all();

        //取此分类下的所有规格
        $avs = [];
        foreach ($specs as $k => $spec) {
            foreach ($spec->vals as $key => $val) {
                $avs[$spec->id][$val->id] = ArrayHelper::toArray($val);
            }
        }

        $datas = ArrayHelper::arrCombin($avs);

        $model->loadDefaultValues();
        $model->can_remote = $cate->can_remote;
        return $this->render('create', [
                'cate' => $cate,
                'model' => $model,
                'attrs' => $attrs,
                'specs' => $specs,
                'tags' => '',
                'tables' => ['data'=>$datas, 'labels'=>array_keys($avs)],
            ]);
        }
    }


    public function actionUpdateLg($id)
    {
        $model = $this->findModel($id);

        $params = Yii::$app->params['i18n'];

        $lgs = array_keys($params['languages']);
        $data['model'] = $model;

        $lg_models = LgGoods::find()->where(['language'=>$lgs])
                        ->andWhere(['goods_id'=>$model->id])
                        ->indexBy('language')
                        ->all();

        foreach ($lgs as $v) {
            if (!array_key_exists($v, $lg_models)) {
                $lg_models[$v] = new LgGoods();
                $lg_models[$v]->language = $v;
                $lg_models[$v]->goods_id = $id;
            }
        }

        if (Model::loadMultiple($lg_models, \Yii::$app->request->post()) && Model::validateMultiple($lg_models)) {

            foreach ($lg_models as $lg_model) {
                $lg_model->save(false);
            }

            return $this->redirect(['index']);
        }

        $data['lg_models'] = $lg_models;
        $data['languages'] = $params['languages'];
        return $this->render('update_lg', $data);
    }

    private function tagCreate($str, $id)
    {
        $str = str_replace('，', ',', $str);
        $tags = explode(',', $str);
        
        TagRel::addTagRel($tags, 'goods', $id);
    }

    public function actionRecommend($id)
    {
        $model = $this->findModel($id);
        $model->recommend = $model->recommend ? 0 : 1;
        if ($model->save()) {
            $note = $model->recommend ? '推荐成功' : '取消推荐成功';

            Yii::$app->session->setFlash('success',$note);
            return $this->json(null, null, 1);
        }


        $note = $model->recommend ? '推荐失败' : '取消推荐失败';
        Yii::$app->session->setFlash('error',$note);

        return $this->json(null, $note,0);
    }

    /**
     * @return array
     * @name 批量删除商品
     */
    public function actionBatchDel()
    {
        $post = Yii::$app->request->post();

        $ses = Yii::$app->getSession();

        if (empty($post['ids'])) {
            return $this->json(null, '请选择要删除的数据 ', 0);
        }

        $bag_rels = BagRel::find()->where(['goods_id'=>$post['ids']])->one();

        if ($bag_rels) {
            return $this->json(null, '存在打包品与此商品关联，请先删除对应打包品',0);
        }

        $outerTransaction = Yii::$app->db->beginTransaction();

        try{
            //删除商品
            Yii::$app->db->createCommand()
                ->delete(Goods::tableName(),[
                    'id' => $post['ids']
                ])->execute();

            //avrel
            Yii::$app->db->createCommand()
                ->delete(AvRel::tableName(),[
                    'goods_id' => $post['ids']
                ])->execute();

            //sku
            Yii::$app->db->createCommand()
                ->delete(Sku::tableName(),[
                    'goods_id' => $post['ids']
                ])->execute();

            $outerTransaction->commit();

        } catch (\Exception $e){
            $outerTransaction->rollBack();
            return $this->json(null, '删除失败', 0);
        }

        $ses->setFlash('success','数据批量删除成功');
        return $this->json();

    }



    public function actionTest()
    {

        // $this->layout = false;
        return $this->render('test');
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @name 修改产品详细
     */
    public function actionUpdate($id)
    {

        $req = Yii::$app->request;

        $model = $this->findModel($id);

        $info = $req->post();

        if ($model->load(Yii::$app->request->post()) ) {

            $outerTransaction = Yii::$app->db->beginTransaction();


            if (!$model->serial) {
                $serial = 'L%sT%s';
                $model->serial = sprintf($serial, str_pad($model->category_id, 3, '0', STR_PAD_LEFT), str_pad($model->id, 4, '0', STR_PAD_LEFT));
            }
            $model->pinyin=Pinyin::py($model->name);
            $model->save();

            try {
                $this->tagCreate($info['Goods']['tags'], $model->id);

                if (isset($info['mid']) && count($info['mid']) > 0) {
                    $mids = $info['mid'];
                    $titles = $info['title'];

                    foreach ($mids as $k => $v) {
                        AttachmentRel::updateResId('goods', $v, $model->id, $titles[$k]);
                    }
                    $model->thumb = array_shift($mids);
                    $model->save();
                    
                }

                $sku = $req->post('sku');
                $price = $sku['price'];
                $num = $sku['num'];

                $original_price = $sku['original_price'];

                Yii::$app->db->createCommand()->delete('{{%shop_sku}}', ['goods_id'=>$id])->execute();
                if ($num && count(array_filter($num))>0) {
                    $num = array_filter($num);

                    $sku_md = [];
                    $sku_model = new Sku;
                    $i = 1;
                    foreach ($num as $k => $v) {

                        //处理规格名
                        $k = trim($k, ';');
                        $spec = explode(';', $k);

                        $spe = [];
                        foreach ($spec as $ke => $va) {
                            $sub = explode(':', $va);
                            $spe[] = $sub[1];
                        }
                        $specs = AttrVal::find()->where(['id'=>$spe])->asArray()->all();
                        $spec_name = implode('',ArrayHelper::getColumn($specs, 'val'));

                        $sku_md[$k] = clone $sku_model;

                        $sku_md[$k]->goods_id = $model->id;
                        $sku_md[$k]->price = $price[$k] ? $price[$k] : $model->price;
                        $sku_md[$k]->original_price = $original_price[$k] ? $original_price[$k] : $model->original_price;

                        $sku_md[$k]->name = $spec_name;
                        $sku_md[$k]->av = $k;
                        $sku_md[$k]->num = $num[$k];
                        $sku_md[$k]->serial = $model->serial . sprintf('P%s', str_pad($i,5,'0',STR_PAD_LEFT));
                        $sku_md[$k]->save();

                        $i++;
                    }

                } else {
                    $sku_model = new Sku;
                    $sku_model->goods_id = $model->id;
                    $sku_model->price = $model->price;
                    $sku_model->original_price = $model->original_price;
                    $sku_model->name = $model->name;
                    $sku_model->av = '0:0';
                    $sku_model->serial = $model->serial . sprintf('P%s', str_pad(1,5,'0',STR_PAD_LEFT));
                    $sku_model->save();
                }


                $result = AvRel::parsePost($model->category_id, $model->id);
                if ($result) {

                    Yii::$app->db->createCommand()->delete('{{%shop_av_rel}}', ['goods_id'=>$id])->execute();

                    Yii::$app->db->createCommand()->batchInsert(
                        AvRel::tableName(), 
                        ['attr_id','av_id', 'value', 'category_id', 'goods_id'], 
                        $result
                    )->execute();
                }


                $outerTransaction->commit();

             } catch (Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
                 
             }


            // if (isset($info['mid']) && count($info['mid']) > 0) {
            //     $mids = $info['mid'];
            //     $titles = $info['title'];

            //     foreach ($mids as $k => $v) {
            //         AttachmentRel::updateResId('goods', $v, $model->id, $titles[$k]);
            //     }
            //     $model->thumb = array_shift($mids);
            //     $model->save();
            // }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {


            $tags = TagRel::getTagsByRes('goods', $model->id);
            $tags = implode(',', ArrayHelper::getColumn($tags, 'tag_name')) ;

            $cate = Category::findOne($model->category_id);


            //获取属性
            $attrs = Attr::find()->where([
                    'type_id'=>$cate->type_id, 
                    'status'=>Attr::STATUS_ACTIVE,
                    'is_spec' => Attr::SPEC_NO
                ])->all();


            //规格
            $specs = Attr::find()->where([
                    'type_id'=>$cate->type_id, 
                    'status'=>Attr::STATUS_ACTIVE,
                    'is_spec' => ATTR::SPEC_YES
                ])->indexBy('id')->all();


            //取此分类下的所有规格
            $avs = [];
            foreach ($specs as $k => $spec) {
                foreach ($spec->vals as $key => $val) {
                    $avs[$spec->id][$val->id] = ArrayHelper::toArray($val);
                }
            }

            $datas = ArrayHelper::arrCombin($avs);



            //找出sku价格写入到表单
            $skus = Sku::find()->where(['goods_id'=>$id])->asArray()->all();
            // $skus = ArrayHelper::map($skus, 'av', 'price');
            $skus = ArrayHelper::index($skus, 'av');

            #2 找出attr和spec
            $rel = AvRel::find()->where(['goods_id'=>$id, 'status'=>AvRel::STATUS_ACTIVE])->all();

            $attr_sels = ArrayHelper::map($rel, 'av_id', 'av_id', 'attr_id');


            //已上传图片
            $imgs = AttachmentRel::getByRes('goods', $id, '100x100');


            return $this->render('update', [
                'attr_sels' => $attr_sels,
                'model' => $model,
                'cate' => $cate,
                'attrs' => $attrs,
                'specs' => $specs,
                'skus'  => $skus,
                'tags'  => $tags,
                'imgs'  => $imgs,
                'tables' => ['data'=>$datas, 'labels'=>array_keys($avs)],
            ]);
        }
    }


    /**
     * @return array
     * @name 商品封面修改
     */
    public function actionCover()
    {
        $post = Yii::$app->getRequest()->post();

        $model = self::findModel($post['goods_id']);
        $model->thumb = $post['thumb'];
        if ($model->save()) {
            return $this->json();
        } 

        return $this->json(null, '修改封面失败', 0);

    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除产品
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return array
     * @name 删除商品图片
     */
    public function actionDelImg()
    {
        $post = Yii::$app->getRequest()->post();

        $model = Attachment::findOne($post['thumb']);
        $model->status = Attachment::STATUS_DEL;
        if ($model->save()) {
            return $this->json();
        }
        

        return $this->json(null, '图片删除失败', 0);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
