<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 bury-create">
                <div class="bury-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'note')->textarea(['rows' => 6])->label(false) ?>

                    <div class="form-group">
                            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>