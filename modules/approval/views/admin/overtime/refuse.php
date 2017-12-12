<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 approval-leave-update">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'reason')->textarea(['rows' => 6])->label(false) ?>

                <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

                <div class="form-group">
                    <div class="pull-right col-sm-3">
                        <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
