<?php

namespace app\modules\grave\controllers\admin;

use Yii;
use app\modules\grave\models\InsCfgValue;
use app\modules\grave\models\search\InsCfgValue as InsCfgValueSearch;
use app\core\web\BackController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\grave\models\InsCfgCase;
use app\modules\grave\helpers\InsHelper;


use app\modules\grave\models\Images;

/**
 * InsCfgValueController implements the CRUD actions for InsCfgValue model.
 */
class InsCfgValueController extends BackController
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

    /**
     * Lists all InsCfgValue models.
     * @return mixed
     */
    // public function actionIndex()
    // {
    //     $searchModel = new InsCfgValueSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }


    public function actionIndex($case_id)
    {

        $Image = new Images('inscfg');

        if (Yii::$app->request->isPost) {
            $this->saveData();
        }

        $model = InsCfgCase::findOne($case_id);
        $cfg = $model->cfg;

        $is_front = $cfg->is_front;

        $cfgs_tmp = InsCfgValue::find()->where(['case_id'=>$case_id])->asArray()->all();
        
        $cfgs = array();
        foreach ($cfgs_tmp as $k=>$v) {
            $cfgs[$v['mark']][$v['sort']] = $v;
        }

        $fields = $this->formShow();

        if (empty($is_front)) {
            $tpl = 'back';
        } else if ($is_front==1) {
            $tpl = 'front';
        } else if ($is_front == 2) {
            $tpl = 'cover';
        }

        return $this->render($tpl, [
            'cfgs' => $cfgs,
            'case' => $model,
            'cfg' => $cfg,
            'fields' => $fields
        ]);

    }

    public function saveData()
    {

        $post = Yii::$app->request->post();


        $data = $post['tpl'];
        $com = $post['all'];
        $time = date('Y-m-d H:i:s');

        $quer = InsCfgValue::find();

        foreach ($data as $k=>$v) {
            foreach ($v as $key=>$val) {
                if (empty($val['value'])) continue;
                $savedata = array(
                        'case_id' => $com['case_id'],
                        'mark' => $k,
                        'sort' => $val['sort'],
                        'x' => $val['x'],
                        'y' => $val['y'],
                        'size' => $val['size'],
                        'text' => $val['value'],
                        'color'=> isset($val['color']) ? $val['color'] : '#000000',
                        'direction'=> isset($val['direction']) ? $val['direction'] : 0,
                        'is_big' => isset($val['is_big'])? $val['is_big'] : 0
                        // 'add_time' => time()
                );

                // if ($savedata['is_big'] == 0) {
                //     p($savedata);
                // }

                $filter = array(
                    'case_id' => $savedata['case_id'],
                    'mark'   => $savedata['mark'],
                    'sort'   => $savedata['sort'],
                );

                if ($quer->where($filter)->one()){
                    $model = $quer->where($filter)->one();
                } else {
                    $model = new InsCfgValue();
                }
                $model->load($savedata,'');
                $model->save();

                // if ($model->is_big == 0) {
                //     p($model);
                //     p($model->getErrors());die;
                // }

            }

        }

        $Image = new Images('ins/inscfg');

        $tmp_path = trim(Yii::$app->request->post('imgpath'),'/');

        //$tmp_path = 'upload/inscription/tmp.png';
        $info = $Image->upload($tmp_path,array('desc'=>'模板样图'), date('Ymd') . '/' . uniqid());

        $url = $Image->getUrl();


        $model = InsCfgCase::findOne($com['case_id']);

        $model->load(['img'=>$url] + $com, '');

        $model->save();


        return true;
    }

    public function actionPic(){
        
        $font = './static/font/ins/STXINWEI.TTF';
        $data = $_POST['tpl'];
        $attr = $_POST['all'];
        $data = $this->handelData($data);
        $data = $this->inverseAlign($data, $attr['shape']);
        //竖碑时才这样弄

        $tmp_path = 'upload/ins/tmp/'.uniqid().'.png';
        if ($attr['shape'] == 'v') {
            $newdata = array();
            foreach ($data as $v) {
                $arr = $this->verText($v['text'],$v['x'], $v['y'], $v['size'], $v['color']);
                $newdata = array_merge($newdata, $arr);
            }
            $img_info = InsHelper::showImg($newdata, $attr['width'], $attr['height'], $font, $tmp_path, $attr['is_god']*1);
        } else {
            $img_info = InsHelper::showImg($data, $attr['width'], $attr['height'], $font, $tmp_path, $attr['is_god']*2);
        }
        

        return $this->json('/'.$tmp_path, null, 1);
    }

    public function verText($text, $startX=0, $startY=0, $fontsize, $color='#222222', $step=1.25, $shape="v"){
        preg_match_all( '/./u',$text,$tmp);

        $font_arr = array();


        if ($shape == 'v') {
            foreach($tmp[0] as $k=>$v) {
                $font_arr[$k] = array(
                    'text' => $v,
                    'size' => $fontsize,
                    'x'     => $startX,
                    'y'     => $startY + $k*($fontsize*$step),
                    'color'=> $color,
                );
            }
        } else {
            foreach($tmp[0] as $k=>$v) {
                $font_arr[$k] = array(
                    'text' => $v,
                    'size' => $fontsize,
                    'x'     => $startX + $k*($fontsize*$step),
                    'y'     => $startY,
                    'color'=> $color,
                );
            }
        }

        return $font_arr;
    }

    /**
     * 处理数据
     * 处理结果:把多维数组变为二维数组，传给绘图接口用
     */
    public function handelData($data){
        $newdata = array();
        foreach ($data as $k=>$v) {
            foreach ($v as $key=>$val) {
                if (empty($val['value'])) continue;
                $newdata[] = array(
                    'x' => $val['x'],
                    'y' => $val['y'],
                    'size' => $val['size'],
                    'text' => $val['value'],
                    'color'=> isset($val['color']) ? $val['color'] : '000000',
                    'direction'=> isset($val['direction']) ? $val['direction'] : 0
                );
            }
        }
        
        return $newdata;
    }
    
    /**
     * 
     * 处理反向对齐
     * @param unknown_type $data
     */
    private function inverseAlign($data, $shape){
        $dire = $shape=='h' ? 'x' : 'y';
        foreach ($data as $k=>&$v){
            if ($v['direction'] == 1) {
                $v[$dire] = $v[$dire] - mb_strlen($v['text'], 'utf-8') * $v['size'];
            }
        }unset($v);
        return $data;
    }


    public function formShow(){
        //这个应该是个全局的配置，所有的地方都应该是这一配置
        $data = array(
            'fields' => array('honorific'=>'尊称','tail'=>'之墓','inscribe'=>'落款',
                    'inscribe_date'=>'日期','born'=>'生日标签','die'=>'祭日标签',
                    'agelabel1'=>'享年标签','agelabel2'=>'享年岁标签','second_name_label'=>'圣名'
            ),
            'dead_fields' => array(
                'title'=>'关系','name'=>'名字','birth'=>'生日','fete'=>'祭日',
                'follow'=>'携子','age'=>'享年','second_name'=>'圣名'),
        );
      
        return $data;
    }

    public function actionRemove()
    {
        $get = Yii::$app->request->get();

        $filter = array(
            'case_id' => $get['case_id'],
            'mark'   => $get['key'],
            'sort'   => $get['sort'],
        );



        $model = InsCfgValue::find()->where($filter)->one();

        if($model->delete()) {
            return $this->json(null, null, 1);
        }

        return $this->json(null, '删除失败', 0);
    }


    /**
     * Displays a single InsCfgValue model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InsCfgValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InsCfgValue();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InsCfgValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InsCfgValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InsCfgValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InsCfgValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InsCfgValue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
