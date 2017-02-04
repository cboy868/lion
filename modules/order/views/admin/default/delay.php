<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\modules\order\models\Pay;
use app\core\widgets\ActiveForm;

use app\assets\JqueryuiAsset;

/* @var $this yii\web\View */
/* @var $model app\modules\order\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '订单延期';

JqueryuiAsset::register($this);
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?=$model->id?>号订单申请延期</h1>
        </div>
        <!-- /.page-header -->

        <div class="row">


        <?php if (Yii::$app->session->has('success')): ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <strong>恭喜!</strong> <?=Yii::$app->session->getFlash('success')?>
            </div>
        <?php endif ?>
            <div class="col-xs-12">
                <div class="orderlist">
                    <table class="table table-striped table-hover table-bordered table-condensed" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                            <th width="15%">订单号：</th>
                            <td><code><?=$model->id?></code></td>
                        </tr>
                        <tr>
                            <th>下单用户：</th>
                            <td colspan="3"><?=$model->user->username?></td>
                        </tr>
                            <tr><th>操作员：</th>
                            <td colspan="3">manage</td>
                        </tr>
                        <tr>
                            <th>应付款：</th>
                            <td colspan="3"><?=$model->price?> 元</td>
                        </tr>
                        <tr>
                            <th>已支付：</th>
                            <td colspan="3"><?=$model->getTotalPay()?> 元</td>
                        </tr>
                        <tr>
                            <th>未支付：</th>
                            <td colspan="3"><?=$model->price - $model->getTotalPay()?> 元</td>
                        </tr>
                        <tr>
                            <th>下单时间：</th>
                            <td><?=date('Y-m-d H:i', $model->created_at)?></td>
                        </tr>
                    </tbody></table>
                </div>    
            </div>


            <div class="col-xs-8">
                <h4>请填写以下信息</h4>
                <div class="well">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($delay, 'pre_dt')->textInput(['id'=>'dt']) ?>

                    <?= $form->field($delay, 'note')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-3">
                            <?=  Html::submitButton('提交申请', ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                    </div>
                    
                    <?php ActiveForm::end(); ?>

                </div>

            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('order') ?>  
$(function() {
    $( "#dt" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:'yy-mm-dd',
      //numberOfMonths: 2,
      regional:'zh-TW'
    });
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['order'], \yii\web\View::POS_END); ?>  
