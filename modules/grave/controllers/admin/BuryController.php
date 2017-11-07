<?php

namespace app\modules\grave\controllers\admin;

use app\modules\grave\models\Card;
use app\modules\grave\models\Dead;
use app\modules\grave\models\OrderRel;
use Yii;
use app\modules\grave\models\Bury;
use app\modules\grave\models\search\BurySearch;
use app\core\web\BackController;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\grave\models\Tomb;
use app\core\libs\Fpdf;
/**
 * BuryController implements the CRUD actions for Bury model.
 */
class BuryController extends BackController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'confirm' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Bury models.
     * @return mixed
     * @name 安葬记录
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $params['BurySearch']['status'] = Bury::STATUS_OK;
        $searchModel = new BurySearch();
        $dataProvider = $searchModel->search($params);

        if (isset($params['excel']) && $params['excel']){
            return $this->excel($dataProvider);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function excel($dp)
    {

        $columns = [
            'tomb.tomb_no',
            'user.username',
            'dead_name',
            // 'dead_num',
            // 'bury_type',
            'pre_bury_date',
            'bury_date',
            'bury_time',
            'buser.username',
            // 'bury_order',
            'note:ntext',
            'created_at:datetime',
        ];

        $options = [
            'title'=>'安葬记录',
            'filename'=>'bury',
            'pageTitle'=>'安葬记录'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }

    /**
     * @return string
     * @name 预葬记录
     */
    public function actionPre()
    {
        $searchModel = new BurySearch();

        $params = Yii::$app->request->queryParams;

        $params['BurySearch']['status'] = Bury::STATUS_NORMAL;

        $dataProvider = $searchModel->search($params);

        if (isset($params['excel']) && $params['excel']){
            return $this->preExcel($dataProvider);
        }

        return $this->render('pre', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function preExcel($dp)
    {

        $columns = [
            'tomb.tomb_no',
            'user.username',
            'dead_name',
            // 'dead_num',
            // 'bury_type',
            [
                'label' => '预葬日期',
                'value' => function($model){
                    return substr($model->pre_bury_date, 0, 10);
                }
            ],
            // 'bury_order',
            'note:ntext',
            'created_at:datetime',
        ];

        $options = [
            'title'=>'预葬记录',
            'filename'=>'prebury',
            'pageTitle'=>'预葬记录'
        ];
        \app\core\libs\Export::export($dp, $columns, $options);
    }

    /**
     * @name 排序
     */
    public function actionSort($id)
    {
        $model = Bury::findOne($id);
        $maxSort = Bury::find()->where(['status'=>Bury::STATUS_NORMAL])
                            ->andWhere(['like', 'pre_bury_date', date('Y-m-d')])
                            ->max('bury_order');

        $maxSort = $maxSort ? $maxSort : 0;


        $model->bury_order = $maxSort+1;

        if ($model->save()) {
            return $this->json(['sort'=>$model->bury_order]);
        }

        return $this->json(null, '排序失败,请联系管理员', 0);

    }

    /**
     * @name 打印桌签
     */
    public function actionSign($id)
    {
        $bury = $this->findModel($id);
        $dead_ids = explode(',',$bury->dead_id);

        $deads = Dead::find()->where(['id'=>$dead_ids])->orderBy('serial asc')->all();

        $num = '';
        $content = [];
        $top=0;
        foreach ($deads as $k=>$dead) {
            $sex = $dead->gender == 1 ? '先生' : '女士';
            $num = $dead->serial.'、';
            $top = 20 +$k*30;
            $content[] = ['content'=>$dead->dead_name, "y" => $top,"x" => 40,"b" => true ,"font_size" => 68];
            $content[] = ['content'=>$sex, "y" => $top+2,"x" => 130,"b" => true ,"font_size" => 48];
        }
        $num = trim($num, '、');

        $tpl = $this->module->params['deadSign'];

        $str = $tpl;
        $str['a'] = sprintf($tpl['a'], $num, $bury->tomb->tomb_no);

        $content = array_merge([
            ["content" => $str['a'], "y" => $top+20,"x" => 30,"b" => true ,"font_size" => 18],
            ["content" => $str['b'], "y" => $top+30,"x" => 40,"b" => false ,"font_size" => 18],
            ["content" => $str['c'], "y" => $top+40,"x" => 60,"b" => false ,"font_size" => 18],
        ],$content);

        $result = Fpdf::content($content);

        $pdf = new Fpdf('P','mm','A4');
        $pdf->AddPage();
        $pdf->AddGBFont('simkai','STXINWEI'); //这个一定要有，否则无法使用 $pdf->SetFont();

        foreach($result as $v){
            $pdf->setXY($v['x'],$v['y']);
            $pdf->SetFont($v['font'],$v['b'],$v['font_size']);
            $pdf->cell(10,10, $v['content']);
        }

        ob_end_clean();
        $pdf->Output();
    }

    /**
     * @return string|\yii\web\Response
     * @name 明日安葬逝者编号
     */
    public function actionSerial()//明日使用人排序
    {
        $pres = Bury::find()->where(['status'=>Bury::STATUS_NORMAL])
                            ->andWhere(['like', 'pre_bury_date', date("Y-m-d",strtotime("+1 day"))])
                            ->all();

        if (!$pres) {
            Yii::$app->session->setFlash('error', '明日没有待安葬的逝者');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $dead_str = '';
        foreach ($pres as $v){
            $dead_str .= $v->dead_id .',';
        }

        $dead_ids = explode(',', $dead_str);
        $deads = Dead::find()->where(['id'=>$dead_ids])
                            ->andWhere(['serial'=>null])
                            ->orderBy('id asc')
                            ->all();
        $max_serial = Dead::find()->where(['status'=>Dead::STATUS_NORMAL])->max('serial');

        foreach ($deads as $dead) {
            $dead->serial = ++$max_serial;
            $dead->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionNote($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['pre']);
        } else {
            return $this->renderAjax('note', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single Bury model.
     * @param integer $id
     * @return mixed
     *
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Bury model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Bury();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing Bury model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * @name 确认安葬
     */
    public function confirmBury()
    {
        $post = Yii::$app->request->post();

        $bury = Bury::findOne($post['id']);
        $bury->status = Bury::STATUS_OK;

        $tomb = Tomb::findOne($bury['tomb_id']);
        $tomb->afterBuryConfirm();


        if ($bury->save()) {
            return $this->json();
        }

        return $this->json(null, '确认安葬出错，请联系管理员', 0);
    }


    public function actionConfirm($id)//这个方法不应该是这样，应该是弹出窗口，选择完安葬员及礼仪再ok，暂时先这样吧
    {
        $bury = Bury::findOne($id);
        $bury->status = Bury::STATUS_OK;
        if ($bury->save()) {


            $params = Yii::$app->getModule('grave')->params['tomb_card'];

            if ($params['start'] == 'bury') {
                $order_rel = OrderRel::find()->where(['status'=>OrderRel::STATUS_NORMAL])
                    ->andWhere(['tid'=>$bury->tomb_id])
                    ->andWhere(['goods_id'=>$params['goods_id']])
                    ->one();
                $order_rel_id = isset($order_rel->id) ? $order_rel->id : 0;

                Card::initCard($bury->tomb_id, $order_rel_id);
            }

            $tomb = Tomb::findOne($bury['tomb_id']);
            $tomb->afterBuryConfirm();

            Yii::$app->session->setFlash('success', '确认安葬成功');
//            return $this->json();
        }


        return $this->redirect('pre');

        //return $this->render('confirm');
    }
    /**
     * Deletes an existing Bury model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @name 删除
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Bury::STATUS_DELETE;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bury model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bury the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bury::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
