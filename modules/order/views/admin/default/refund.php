<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\order\models\Order */

$this->title = ' ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '退款';
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
				<?= Html::encode($this->title) ?>
				<small>
					退款处理
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 order-update">


				<div class="order-form">

				<?php 

					$ck = [];

					foreach ($model->rels as $k => $v) {
						$ck[$v->title] = $v->title;
					}
				 ?>


				    <?php $form = ActiveForm::begin(); ?>

				    <div class="form-group field-refund-intro has-success">
						<label class="control-label col-sm-2">退款内容</label>
						<div class="col-sm-10">

						<?php foreach ($model->rels as $k => $v): ?>
							<div style="margin-bottom:10px;">
							  <label><?=$v->title?></label>
							  <select class="form-control" name="item[<?=$v->id?>]" unit="<?=$v->price_unit?>" style="display: inline;width: auto;">
							  	<?php for($i=$v->num; $i>=0; $i--): ?>
							  		<option value="<?=$i?>"><?=$i?>个<?=($i * $v->price_unit)?>元</option>
							  	<?php endfor; ?>
							  </select>
							</div>
						<?php endforeach ?>

						</div>
					</div>

				    <?= $form->field($refund, 'fee')->textInput(['maxlength' => true, 'class'=>'tprice']) ?>

				    <?= $form->field($refund, 'note')->textarea(['rows' => 6]) ?>

					<div class="form-group">
				        <div class="col-sm-offset-2 col-sm-3">
				            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
				        </div>
				    </div>
				    
				    <?php ActiveForm::end(); ?>

				</div>


				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('refund') ?>  
$(function() {

	calPrice();

	$('select').change(function(){
		calPrice();
	});

});

function calPrice(){
	var total = 0;
	$('select option:selected').each(function(index){
		var price_unit = $(this).closest('select').attr('unit');
		var num = $(this).val();

		total += parseFloat(price_unit) * parseInt(num);
		$('.tprice').val(total);
	});
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['refund'], \yii\web\View::POS_END); ?>  
