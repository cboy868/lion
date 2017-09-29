<?php

use app\core\helpers\Html;
use app\core\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\shop\models\InventorySupplier;
use kartik\select2\Select2;

\app\assets\ExtAsset::register($this);
?>
<style type="text/css">
    .cuser{
        width:100px;
    }
</style>
<div class="inventory-purchase-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
//        $form->fieldConfig['template'] = '{label}<div class="col-sm-11">{input}{hint}{error}</div>';
//        $form->fieldConfig['labelOptions']['class'] = 'control-label col-sm-1';
     ?>
     <?php 

        $sup = InventorySupplier::find()->where(['status'=>InventorySupplier::STATUS_NORMAL])->all();
        $options = [];
        foreach ($sup as $k => $v) {
            $options[$v['id']]['ct_mobile'] = $v['ct_mobile'];
            $options[$v['id']]['ct_name'] = $v['ct_name'];
        }

        $sup = ArrayHelper::map($sup, 'id', 'cp_name');

     ?>

    <table class="noborder table">
        <tr>
            <td>
                <?= $form->field($model, 'supplier_id')->dropDownList($sup, ['prompt'=>'选择供应商', 'options'=>$options, 'class'=>'supplier form-control']) ?>
            </td>
            <td>
                <?= $form->field($model, 'ct_name')->textInput(['maxlength' => true, 'class'=>'form-control ct_name']) ?>

            </td>
            <td>
                <?= $form->field($model, 'ct_mobile')->textInput(['maxlength' => true, 'class'=>'form-control ct_mobile']) ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php
                $users = \app\modules\user\models\User::staffs();

                $options = [];
                foreach ($users as $k => $v) {
                    $options[$v['id']]['mobile'] = $v['mobile'];
                    $options[$v['id']]['name'] = $v['username'];
                }
                ?>

                <?php
                echo $form->field($model, 'checker_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($users, 'id', 'username'),
                    'options' => [
                        'placeholder' => '选择验收员',
                        'class' => 'cuser',
                        'options' => $options,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('验收员');

                ?>
                <?= $form->field($model, 'checker_name')->hiddenInput(['maxlength' => true, 'class'=>'cname'])->label(false) ?>

            </td>
            <td>
                <?= $form->field($model, 'total')->textInput(['maxlength' => true,]) ?>

            </td>
            <td>
                <?= $form->field($model, 'supply_at')->textInput(['dt'=>'true',])->label('供货日期'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
                <?= $form->field($model, 'op_id')->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'op_name')->hiddenInput(['maxlength' => true])->label(false) ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group">
                    <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary']) ?>
                </div>
            </td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('cate') ?>  
$(function(){
    $('.cuser').change(function(e){
        e.preventDefault();
        var name = $("option:selected", this).attr('name');
        $('.cname').val(name);
    });

    $('.supplier').change(function(e){
        e.preventDefault();
        var name = $("option:selected", this).attr('ct_name');
        var mobile = $("option:selected", this).attr('ct_mobile');
        $('.ct_name').val(name);
        $('.ct_mobile').val(mobile);
    });
})  

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
