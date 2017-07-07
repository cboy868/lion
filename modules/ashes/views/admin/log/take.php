<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

\app\assets\ExtAsset::register($this);
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-12 area-create">

                <div class="take-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($log, 'out_user')->textInput() ?>

                    <?= $form->field($log, 'out_time')->textInput(['dt'=>'true']) ?>

                    <?= $form->field($log, 'note')->textarea(['rows' => 6]) ?>

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






