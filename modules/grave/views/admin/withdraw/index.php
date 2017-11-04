<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\grave\models\Withdraw;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\WithdrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '退墓记录';
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

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>

            <div class="col-xs-12 withdraw-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'tomb.tomb_no',
            'guide.username',
            'user.username',
//            'current_tomb_id',
            // 'refund_id',
             'ct_name',
             'ct_mobile',
            // 'ct_card',
             'ct_relation',
             'reson:ntext',
             'price',
            // 'in_tomb_id',
            [
                'label' => '迁入墓位',
                'value' => function($model) {
                    if ($model->in_tomb_id) {
                        return $model->inTomb->tomb_no;
                    }
                }
            ],
             'note:ntext',
             'type',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template' => '{delete} {verify}',
                'visibleButtons' =>[
                    'delete' =>Yii::$app->user->can('order/refund/delete'),
                    'verfy' =>Yii::$app->user->can('order/refund/verfy'),
                ],
                'buttons' => [
                    'verify' => function($url, $model, $key) {

                        $html = '';



                        if ($model->status==Withdraw::TYPE_DING_REFUND) {
                            $ok = Html::a('<span class="fa fa-check"></span> 通过', $url . '&v=' . Withdraw::TYPE_DING_REFUND_OK, ['title' => '审核通过','aria-label'=>"审核通过", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                            $no = Html::a('<span class="fa fa-minus-square"></span> 驳回', $url . '&v=' . Withdraw::TYPE_DING_REFUND_NO, ['title' => '驳回','aria-label'=>"驳回", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
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
                        }


                        if ($model->status==Withdraw::TYPE_ALL_REFUND) {
                            $ok = Html::a('<span class="fa fa-check"></span> 通过', $url . '&v=' . Withdraw::TYPE_ALL_REFUND_OK, ['title' => '审核通过','aria-label'=>"审核通过", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                            $no = Html::a('<span class="fa fa-minus-square"></span> 驳回', $url . '&v=' . Withdraw::TYPE_ALL_REFUND_NO, ['title' => '驳回','aria-label'=>"驳回", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
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
                        }



                        return $html;
                    }
                ],
                'headerOptions' => ['width' => '100',"data-type"=>"html"]
            ]
            // 'updated_at',
            // 'created_at',
//            [
//                'header' => '操作',
//                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{delete}',
//            ]

        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>