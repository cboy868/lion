<?php

namespace app\modules\shop\controllers\admin;

use Yii;
use app\modules\shop\models\Goods;
use app\modules\shop\models\search\Meal;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\shop\models\Category;
use app\modules\shop\models\Attr;
use app\modules\shop\models\AttrVal;
use app\modules\shop\models\AvRel;
use app\modules\shop\models\Mix;
use app\modules\shop\models\Sku;
use app\modules\shop\models\MixRel;
use app\modules\shop\models\Process;
use app\core\helpers\ArrayHelper;
use app\core\base\Upload;
use app\core\models\AttachmentRel;
use app\core\models\Attachment;
use app\modules\shop\models\Type;

/**
 * MealController implements the CRUD actions for Goods model.
 */
class MealController extends BackController
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
            // 'web-upload' => [
            //     'class' => 'app\core\web\UploadAction',
            // ],
            'pl-upload' => [
                'class' => 'app\core\web\PluploadAction',
            ],
            // 'ue-upload' => [
            //     'class' => 'app\core\widgets\ueditor\UeAction',
            // ],

        ];
    }

    /**
     * Lists all Goods models.
     * @return mixed
     * @name 餐饮管理 
     */
    public function actionIndex()
    {

        $queryParams = Yii::$app->request->queryParams;
        // p($queryParams);die;
        $searchModel = new Meal();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $cates = Category::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cates' => $cates
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     * @name 详情
     */
    public function actionView($id)
    {

        $av = AvRel::getGoodsRel($id);
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'av'    => $av,
            'imgs'  => AttachmentRel::getByRes('meal', $id, '100x100', [$model->thumb])
        ]);

    }

    /**
     * @name 修改
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //内容中如果有上传图片，则更新rel
            Yii::$app->db->createCommand()
                    ->update('{{%attachment_rel}}', ['res_id'=>$model->id], ['res_name'=>'meal', 'res_id'=>null, 'attach_id'=>$model->thumb])
                    ->execute();

            $price = Yii::$app->getRequest()->post('price');

            //更新 sku;
            if ($price) {
                $del = [];
                $skudel = [];
                foreach ($price as $k => $v) {
                    if (!$v) {
                        $skudel[] = $k;
                        $at = explode(':', $k);

                        $del[] = $at[1];
                    }
                }

                $price = array_filter($price);

                if (count($price)==0) {
                    $price['0:0'] = $model->price;
                }

                $av = array_keys($price);
                //找到已存在的，要更新
                $yet = Sku::find()->where(['goods_id'=>$id, 'av'=>$av])->asArray()->all();
                $yet = ArrayHelper::map($yet, 'av', 'price');

                if ($yet) {
                    foreach ($yet as $k => $v) {
                        $sku = Sku::find()->where(['av'=>$k, 'goods_id'=>$model->id])->one();
                        $sku->price = $price[$k];
                        $sku->save();
                    }
                }

                $add_sku = array_diff_key($price, $yet);

                if ($add_sku) {
                    $valnames = $this->valNames(array_keys($add_sku));
                    $valnames['0'] = $model->name;

                    $sku_model = new Sku;
                    foreach ($add_sku as $k => $v) {

                        //处理规格名
                        $spec = explode(';', $k);
                        $spe = [];
                        // $spec_attr = [];
                        $spec_name = '';
                        foreach ($spec as $ke => $va) {
                            $sub = explode(':', $va);
                            $spec_name .= $valnames[$sub[1]];
                        }

                        $sku_md[$k] = clone $sku_model;

                        $sku_md[$k]->goods_id = $model->id;
                        $sku_md[$k]->price = $v;
                        $sku_md[$k]->name = $spec_name;
                        $sku_md[$k]->av = $k;
                        $sku_md[$k]->save();
                    }
                }

                Sku::deleteAll(
                    [
                        'and', 'goods_id = :goods_id',
                        ['not in', 'av', array_keys($price)]
                    ],
                    [ ':goods_id' => $id]
                );
              
            }


            $av = AvRel::find()->where(['goods_id'=>$model->id])->indexBy('av_id')->asArray()->all();
            $postResult = AvRel::parsePost($model->category_id, $model->id);

            $new = array_diff_key($postResult, $av);

            AvRel::deleteAll(
                    [
                        'and', 'goods_id = :goods_id',
                        ['not in', 'av_id', array_keys($postResult)]
                    ],
                    [ ':goods_id' => $id]
                );
            
            if ($new) {
                Yii::$app->db->createCommand()->batchInsert(
                        AvRel::tableName(), 
                        ['attr_id','av_id', 'category_id', 'goods_id'], 
                        $new
                    )->execute();
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {

            #2 找出attr和spec
            $rel = AvRel::find()->where(['goods_id'=>$id, 'status'=>AvRel::STATUS_ACTIVE])->all();

            // $attr_sels = ArrayHelper::getColumn($rel, 'av_id');
            $attr_sels = ArrayHelper::map($rel, 'av_id', 'av_id', 'attr_id');


            $cate = Category::findOne($model->category_id);



            //获取此商家可用属性
            $attrs = Attr::find()->where([
                    'type_id'=>$cate->type_id, 
                    'status'=>Attr::STATUS_ACTIVE,
                    'is_spec' => Attr::SPEC_NO
                ])->all();

            // $mixs = Mix::find()->where(['status'=>Mix::STATUS_ACTIVE])->all();

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
            $skus = ArrayHelper::map($skus, 'av', 'price');


            return $this->render('update', [
                    'model' => $model,
                    'attrs' => $attrs,
                    'attr_sels' => $attr_sels,
                    // 'mixs'  => $mixs,
                    'specs' => $specs,
                    'tables' => ['data'=>$datas, 'labels'=>array_keys($avs)],
                    'skus'  => $skus
                ]);
        }
    }

    private function valNames($vs)
    {
        $vals = [];
        foreach ($vs as $k => $v) {
            $tmp = explode(';', $v);
            foreach ($tmp as $key => $val) {
                $t = explode(':', $val);
                array_push($vals, $t[1]);
            }
        }
        $vals = AttrVal::find()->where(['id'=>$vals])->asArray()->all();
        $valnames = ArrayHelper::map($vals, 'id', 'val');

        return $valnames;
    }



    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * 新加时，要添加的数据
     * 1､商品主信息
     * 2､属性
     * 3､规格
     * 4､sku
     * 5､制作方法
     * 6､材料
     * 最终选择拆开，把制作方法放在method中来处理，这时里只处理属性之类的商品内容
     * @return mixed
     * @name 添加菜品
     */
    public function actionCreate($category_id)
    {
        $model = new Goods();

        $req = Yii::$app->request;

        if ($model->load($req->post()) && $model->validate()) {

            $outerTransaction = Yii::$app->db->beginTransaction();

            try {
                $model->save();

                $price = Yii::$app->getRequest()->post('price');

                if ($price && count(array_filter($price))>0) {
                    $price = array_filter($price);
                    $sku_md = [];
                    $sku_model = new Sku;
                    foreach ($price as $k => $v) {

                        //处理规格名
                        $k = trim($k, ';');
                        $spec = explode(';', $k);

                        $spe = [];
                        // $spec_attr = [];
                        foreach ($spec as $ke => $va) {
                            $sub = explode(':', $va);
                            $spe[] = $sub[1];
                        }
                        $specs = AttrVal::find()->where(['id'=>$spe])->asArray()->all();
                        $spec_name = implode('',ArrayHelper::getColumn($specs, 'val'));

                        $sku_md[$k] = clone $sku_model;

                        $sku_md[$k]->goods_id = $model->id;
                        $sku_md[$k]->price = $v;

                        $sku_md[$k]->name = $spec_name;
                        $sku_md[$k]->av = $k;

                        $sku_md[$k]->save();
                    }

                } else {
                    $sku_model = new Sku;
                    $sku_model->goods_id = $model->id;
                    $sku_model->price = $model->price;
                    $sku_model->name = $model->name;
                    $sku_model->av = '0:0';
                    $sku_model->save();
                }

                $result = AvRel::parsePost($model->category_id, $model->id);

                if ($result) {
                    Yii::$app->db->createCommand()->batchInsert(
                        AvRel::tableName(), 
                        ['attr_id','av_id', 'category_id', 'goods_id'], 
                        $result
                    )->execute();
                }

                //内容中如果有上传图片，则更新rel
                Yii::$app->db->createCommand()
                        ->update('{{%attachment_rel}}', ['res_id'=>$model->id], ['res_name'=>'meal', 'res_id'=>null, 'attach_id'=>$model->thumb])
                        ->execute();
                
                $outerTransaction->commit();
            } catch (Exception $e) {
                echo $e->getMessage();
                $outerTransaction->rollBack();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }


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

        return $this->render('create', [
                'model' => $model,
                'attrs' => $attrs,
                'specs' => $specs,
                'tables' => ['data'=>$datas, 'labels'=>array_keys($avs)],
            ]);
    }

    
    /**
     * @name 制作方法
     */
    public function actionMethod($id)
    {

        $model = Goods::findOne($id);

        $req = Yii::$app->getRequest();

        if ($req->isPost) {

            $model = $this->findModel($id);
            $model->skill = $req->post('Goods')['skill'];
            $model->save();

            $zl = $req->post('zl');
            $fl = $req->post('fl');
            $this->dealMix($zl, $model->id, MixRel::TYPE_ZL);
            $this->dealMix($fl, $model->id, MixRel::TYPE_FL);

            $this->dealStep($model->id);

            $this->dealPic($model->id);

        }
        
        # 1､配料
        $mixs = Mix::find()->where(['status'=>Mix::STATUS_ACTIVE])->all();
        $rel = MixRel::find()->where(['goods_id'=>$model->id])->all();

        $mixrel = [];
        foreach ($rel as $k => $v) {
            $mixrel[$v['type']][] = $v;
        }

        for ($i=0; $i < 3; $i++) { 
            $mixrel[0][$i] = isset($mixrel[0][$i]) ? $mixrel[0][$i] : new MixRel();
            $mixrel[1][$i] = isset($mixrel[1][$i]) ? $mixrel[1][$i] : new MixRel();
        }

        # 2､步骤
        $process = Process::find()->where(['goods_id'=>$model->id])->orderBy('step asc')->indexBy('step')->all();


        foreach ($process as $k => &$v) {
            $v->img_url = Attachment::getById($v->thumb, '202x243', '/static/images/up.png');
        }unset($v);

        $cnt = count($process);

        if ($cnt < 3) {
           for ($i=$cnt+1; $i <= 3; $i++) { 
               $process[$i] = new Process();
           }
        }


        # 3､图片
        $pics = AttachmentRel::getModels('meal', $model->id, '100x100', 'pic');
        $cnt = count($pics);
        if ($cnt < 4) {
           for ($i=$cnt; $i < 4; $i++) { 
               $pics[$i] = new Attachment();
               $pics[$i]->url = '/static/images/up.png';
           }
        }


        return $this->render('method', [
                'model' => $model,
                'mixs'  => $mixs,
                'mixrel'=> $mixrel,
                'process' => $process,
                'pics' => $pics
            ]);
    }

    private function dealPic($goods_id)
    {
        $req = Yii::$app->getRequest();
        $pic = array_filter($req->post('pic'));

        AttachmentRel::deleteRes('meal', $goods_id, 'pic', $pic);

        if (count($pic)==0) {
            return ;
        }
        AttachmentRel::updateResId('meal', $pic, $goods_id);
        //内容中如果有上传图片，则更新rel
        // Yii::$app->db->createCommand()
        //         ->update('{{%attachment_rel}}', ['res_id'=>$goods_id], ['res_name'=>'meal', 'res_id'=>null, 'attach_id'=>$pic])
        //         ->execute();
    }

    /**
     * @name 处理步骤
     * todo 全部用ajax来处理要好一些，省很多事
     */
    private function dealStep($goods_id)
    {
        $req = Yii::$app->getRequest();
        $step = $req->post('step');

        $img = array_filter($step['img']);

        //暂时先删除所有的步骤,之后研究看ajax完善看是否好用
        Process::deleteAll(
                    [
                        'and', 'goods_id = :goods_id'
                    ],
                    [ ':goods_id' => $goods_id]
                );

        foreach ($img as $k => $v) {
            $model = new Process();
            $model->goods_id = $goods_id;
            $model->thumb = $v;
            $model->intro = $step['intro'][$k];
            $model->step = $k+1;
            $model->save();
        }

        AttachmentRel::updateResId('meal', $img, $goods_id);

    }

    private function dealMix($mix, $goods_id, $type)
    {
        $mix_id = array_filter($mix['mix_id']);
        $category = Mix::find()->where(['id'=>$mix_id])->select(['id', 'mix_cate'])->indexBy('id')->asArray()->all();

        MixRel::deleteAll(
                    [
                        'and', 'goods_id = :goods_id', 'type=:type'
                    ],
                    [ ':goods_id' => $goods_id, ':type'=>$type]
                );

        foreach ($mix_id as $k => $v) {
            $model = new MixRel();
            $data = [
                'mix_cate' => $category[$v]['mix_cate'],
                'mix_id' => $v,
                'measure' => $mix['measure'][$k],
                'goods_id' => $goods_id,
                'type' => $type
            ];
            $model->load($data, '');
            $model->save();
        }
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除菜品 
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

    /**
     * @name 推荐菜品
     */
    public function actionRecommend($id)
    {
        $model = Goods::findOne($id);
        
        $model->is_recommend += 1;

        if ($model->save()) {
            return $this->json(null, null, 1);
        } else {
            return $this->json(null, '推荐失败，请重试', 0);
        }
    }

    /**
     * @name 取消推荐
     */
    public function actionUnRecommend($id)
    {
        $model = Goods::findOne($id);
        

        $model->is_recommend = $model->is_recommend>0 ? ($model->is_recommend-1) : 0;


        if ($model->save()) {
            return $this->json(null, null, 1);
        } else {
            return $this->json(null, '推荐失败，请重试', 0);
        }
    }


    /**
     * @name 上传图片
     */
    public function actionCover()
    {
        $outerTransaction = Yii::$app->db->beginTransaction();

        try {
            
            $upload = Upload::getInstanceByName('thumb', 'meal');

            // $img_config = $upload->getConfig();
            // $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'thumb']);

            // if (isset($img_config['water'])) {//水印
            //     $upload->on(Up::EVENT_AFTER_UPLOAD, ['core\helpers\Image', 'water'], null, false);
            // }

            // if (isset($img_config['db']) && $img_config['db']) {//是否存入数据库
            //     $upload->on(Up::EVENT_AFTER_UPLOAD, ['common\models\Attachment', 'db']);
            // }

            $upload->save();

            $info = $upload->getInfo();

            $id = Yii::$app->getRequest()->post('id');
            $model = Goods::findOne($id);
            $model->thumb = $info['mid'];
            $model->save();

            Yii::$app->db->createCommand()
                ->update('{{attachment_rel}}', ['res_id' => $model->id], ['attach_id' => $info['mid']])
                ->execute();

            $outerTransaction->commit();
        } catch (Exception $e) {
            $outerTransaction->rollBack();

            return $this->json(null, '上传图片失败,请重试', 0);
        }
        return $this->json([
                'id'=>$model->id,
                'url'=> $info['path'] .'/36x36@'. $info['fileName']
            ], null, 1);
        // return $this->json(null, '上传图片失败', 1);
    }
}
