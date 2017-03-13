<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;

use kartik\select2\Select2;

\app\assets\ExtAsset::register($this);
\app\assets\DateTimeAsset::register($this);
$users = \app\modules\user\models\User::staffs();
$agents =\app\modules\user\models\User::agents();
?>
<style type="text/css">
    .help-block{
        margin-bottom: 0;
        margin-top: 0;
    }
</style>
<div class="reception-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'client_id')->hiddenInput()->label(false) ?>


    <table class="table table-striped table-bordered table-condensed">
        <tr>
            <td><?= $form->field($model, 'type')->dropDownList(Yii::$app->controller->module->params['reception_type'], ['prompt'=>'请选择接待方式']) ?></td>
        </tr>
        <tr>
            <td>
                 <?php 
                    echo $form->field($model, 'guide_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($users, 'id', 'username'),
                        'options' => [
                            'placeholder' => '选择接待员  ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('接待员');

                ?>
            </td>
            <td>
                <?php 
                    echo $form->field($model, 'agent_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($agents, 'id', 'username'),
                        'options' => [
                            'placeholder' => '选择业务员  ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('接待员');

                ?>
            </td>
        </tr>

        <tr>
            <td><?= $form->field($model, 'car_number')->textInput() ?></td>
            <td><?= $form->field($model, 'person_num')->textInput() ?></td>
        </tr>

        <tr>
            <td><?= $form->field($model, 'start')->textInput(['class'=>'dt form-control']) ?></td>
            <td><?= $form->field($model, 'end')->textInput(['class'=>'dt form-control']) ?></td>
        </tr>

        <tr>
            <td><?= $form->field($model, 'is_success')->radioList([0=>'否',1=>'是'], ['prompt'=>'未购买原因']) ?></td>
            <td><?= $form->field($model, 'un_reason')->dropDownList(Yii::$app->controller->module->params['unreason'], ['prompt'=>'未购买原因'])->hint('如未成交，请选择') ?></td>
        </tr>

        <tr>
        <?php $form->fieldConfig['labelOptions']['class']='control-label col-sm-1';
              $form->fieldConfig['template']='{label}<div class="col-sm-10">{input}{hint}{error}</div>';
         ?>
            <td colspan="2"><?= $form->field($model, 'note')->textarea(['rows' => 6]) ?></td>
        </tr>

    </table>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('foo') ?>  
  $(function(){
    $.datetimepicker.setLocale('ch');
    $('.dt').datetimepicker({
      timepicker:true, 
      format:"Y-m-d H:i",
      step:30,
      weeks:true,
    })

  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  




