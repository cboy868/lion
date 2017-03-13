<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;

use app\core\widgets\Area\Select;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\client\models\Client */
/* @var $form yii\widgets\ActiveForm */

$users = \app\modules\user\models\User::staffs();
$agents =\app\modules\user\models\User::agents();
?>
<style type="text/css">
    .help-block{
        margin-bottom: 0;
        margin-top: 0;
    }
</style>
<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <table class="table table-striped table-bordered table-condensed">
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
            <td><?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('<font color="red">名字(*)</font>') ?></td>
            <td><?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?></td>

            <td><?= $form->field($model, 'gender')->radioList($model->gender()) ?></td>

        </tr>
        <tr>
            <td><?= $form->field($model, 'email')->textInput() ?></td>
            <td><?= $form->field($model, 'wechat')->textInput(['maxlength' => true]) ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'age')->textInput() ?></td>
            <td><?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'come_from')->dropDownList($from, ['prompt'=> '选择客户来源']) ?></td>
            <td></td>
        </tr>
        <tr>
        <?php $form->fieldConfig['labelOptions']['class']='control-label col-sm-1';
              $form->fieldConfig['template']='{label}<div class="col-sm-10">{input}{hint}{error}</div>';
         ?>
            <td colspan="2"><?= $form->field($model, 'note')->textarea(['rows' => 6]) ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="form-group">
                    <label class="control-label col-sm-1" for="customer-addr"></label>
                    <div class="col-sm-10">
                      <?= Select::widget([
                        'pro_name' => 'Client[province_id]',
                        'city_name' => 'Client[city_id]',
                        'zone_name' => 'Client[zone_id]',
                        'pro'=>$model->province_id,
                        'city'=>$model->city_id,
                        'zone'=>$model->zone_id,
                      ]);?>
                    </div>
                  </div>
                <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
            </td>
        </tr>
    </table>
    

    

    

    

    

    


    

    

    
    




	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
