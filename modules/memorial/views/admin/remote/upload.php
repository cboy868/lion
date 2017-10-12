<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
				<?= Html::encode($this->title) ?>
				<small>
					修改详细信息
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 remote-update">
                <div class="remote-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'video')->hiddenInput(['maxlength' => true, 'class'=>'videourl'])->label(false) ?>

                    <?=\app\core\widgets\Videoup\Videoup::widget([
                        'options' => [
                            'res_name' => 'remote'
                        ]
                    ])?>

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
