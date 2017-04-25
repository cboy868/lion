<?php

use app\core\helpers\Html;
use app\core\helpers\ArrayHelper;
use app\core\widgets\ActiveForm;
use app\modules\shop\models\InventorySupplier;
use kartik\select2\Select2;
app\assets\ExtAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\InventoryPurchase */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .cuser{
        width:100px;
    }
</style>
<div class="inventory-purchase-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php 
        $form->fieldConfig['template'] = '{label}<div class="col-sm-11">{input}{hint}{error}</div>';
        $form->fieldConfig['labelOptions']['class'] = 'control-label col-sm-1';
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


    <?= $form->field($model, 'supplier_id')->dropDownList($sup, ['style'=>'width:50%', 'prompt'=>'选择供应商', 'options'=>$options, 'class'=>'supplier form-control']) ?>

    <?= $form->field($model, 'ct_name')->textInput(['maxlength' => true, 'style'=>'width:50%', 'class'=>'form-control ct_name']) ?>

    <?= $form->field($model, 'ct_mobile')->textInput(['maxlength' => true, 'style'=>'width:50%', 'class'=>'form-control ct_mobile']) ?>
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

    <?= $form->field($model, 'total')->textInput(['maxlength' => true, 'style'=>'width:30%']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'supply_at')->textInput(['dt'=>'true', 'style'=>'width:30%'])->label('供货日期'); ?>

    <?= $form->field($model, 'op_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'op_name')->hiddenInput(['maxlength' => true])->label(false) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
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
