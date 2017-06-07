<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\order\models\Delay;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\order\models\DelaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '延期付款管理';
$this->params['breadcrumbs'][] = ['label' => '订单管理', 'url' => ['/order/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  Html::a($this->title, ['index']) ?> 
            </h1>
        </div><!-- /.page-header -->


        <?php if (Yii::$app->session->has('success')): ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <strong>恭喜!</strong> <?=Yii::$app->session->getFlash('success')?>
            </div>
        <?php endif ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 delay-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid){
            if ($model->is_verified == -1) {
                return ['class'=>'alert alert-danger'];
            }

            if ($model->is_verified == 1) {
                return ['class'=>'alert alert-success'];
            }
        },

        'columns' => [
            'order_id',
            'user.username',
            'op.username',
            'price',
            'pre_dt',
            'pay_dt',
            // 'note:ntext',
            'created_by:date',
            [
                'label' => '结果',
                'value' => function($data){
                    return Delay::getVerfy($data->is_verified);
                }
            ],
            [
                'label' => '审核人',
                'value' => function($data){
                    return $data->verfyUser? $data->verfyUser->username : '';
                }
            ],
            'verified_at:date',
            'created_at:date',
            // 'updated_at',
            // 'status',

            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{delete} {verfy}',
                'buttons' => [

                    // 'more' => function($url, $model, $key) {
                    //     return '<button class="blue btn btn-white radius4 btn-minier dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">审批 <span class="caret"></span></button>';
                    //     // return Html::a('<span class="fa fa-check"></span>', $url, ['title' => '审核通过','aria-label'=>"审核通过", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                    // },
                    'verfy' => function($url, $model, $key) {
                        if ($model->is_verified != 0) {
                            return '';
                        }
                        $ok = Html::a('<span class="fa fa-check"></span>通过', $url . '&v=1', ['title' => '审核通过','aria-label'=>"审核通过", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                        $no = Html::a('<span class="fa fa-minus-square"></span>驳回', $url . '&v=-1', ['title' => '驳回','aria-label'=>"驳回", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );

                        $html = <<<HTML
<div class="dropdown" style="display:inline">
  <button class="btn btn-default dropdown-toggle btn-minier btn-white" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    审批
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li>{$ok}</li>
    <li>{$no}</li>
  </ul>
</div>
HTML;
                        return $html;
                    }

                ],
               'headerOptions' => ['width' => '150',"data-type"=>"html"]
            ]
        ],
    ]); ?>






                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>