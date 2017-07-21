<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\order\models\Refund;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\order\models\RefundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '退款记录';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 退款申请', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <?=\app\core\widgets\Alert::widget();?>
        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 refund-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'order_id',
            'user.username',
            'fee',
            'pro',
            [
                'label' => '退款内容',
                'value' => function($model){
                    $intro = (array)json_decode($model->intro, true);

                    $str = '';
                    foreach ($intro as $k => $v) {
                        $str .= $v['name'] . $v['num'] . '个' . $v['price'].'元;<br/>';
                    }
                    return $str;
                },
                'format' => 'raw'
            ],
            'note:ntext',
            'created_at:datetime',
            // 'updated_at',
            // 'status',
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
                        if ($model->progress == Refund::PRO_WAIT) {
                            $ok = Html::a('<span class="fa fa-check"></span> 通过', $url . '&v=' . Refund::PRO_PASS, ['title' => '审核通过','aria-label'=>"审核通过", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                            $no = Html::a('<span class="fa fa-minus-square"></span> 驳回', $url . '&v=' . Refund::PRO_NOPASS, ['title' => '驳回','aria-label'=>"驳回", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
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

                        if ($model->progress == Refund::PRO_PASS) {
                            $html = Html::a('退款完成', $url . '&v=' . Refund::PRO_OK, ['title' => ' 退款完成','aria-label'=>" 退款完成", 'data-confirm'=>"您确定要执行此操作吗？", 'data-method'=>"post", 'data-pjax'=>"0"] );
                        }

                        return $html;
                    }
                ],
               'headerOptions' => ['width' => '100',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>