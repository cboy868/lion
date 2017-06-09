<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">
            <div class="col-xs-12 car-record-update">
                <div class="car-record-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'car_id')->dropDownList($model->cars(), ['prompt'=>'选择可用车辆'])->label('选择车辆'); ?>

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
