<?php
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
?>

<div class="page-content">
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 card-update">
				 <div class="card-form">

			    <?php $form = ActiveForm::begin(); ?>
			    <?php
			    	$form->fieldConfig['template'] = '{label}<div class="col-sm-5">{input}{hint}{error}</div>';
			    	$form->fieldConfig['labelOptions']['class'] = 'control-label col-sm-2';
			    	$form->fieldConfig['options']['class'] = 'form-g';
			    ?>
			    <?php if ($rels): ?>
			    	<?php $i=1; foreach ($rels as $rel): ?>
			    		
				    	<?= $form->field($rel, "[$rel->id]start")->textInput(['dt'=>'true','dt-year' => 'true','dt-month' =>'true'])->label('第'. $i.'次') ?>
			    		<?= $form->field($rel, "[$rel->id]end")->textInput(['dt'=>'true','dt-year' => 'true','dt-month' =>'true'])->label(false) ?>
			    		
				    <?php $i++;endforeach ?>
			    <?php endif ?>

				<div class="form-group" style="text-align: center;">
			            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary','style'=>'margin-top:20px;']) ?>
			    </div>
			    
			    <?php ActiveForm::end(); ?>

			</div>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
