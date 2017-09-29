<?php

use app\core\helpers\Html;
use app\core\helpers\ArrayHelper;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="inventory-storage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pos')->textInput(['maxlength' => true]) ?>

    <?php 
        $users = \app\modules\user\models\User::staffs();

        $options = [];
        foreach ($users as $k => $v) {
            $options[$v['id']]['mobile'] = $v['mobile'];
            $options[$v['id']]['name'] = $v['username'];
        }
     ?>

<?php 
echo $form->field($model, 'op_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map($users, 'id', 'username'),
    'options' => [
        'placeholder' => '选择仓库管理员',
        'class' => 'opuser',
        'options' => $options
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('管理员');

     ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true, 'class'=> 'opmobile form-control']) ?>
    <?= $form->field($model, 'op_name')->hiddenInput(['maxlength' => true, 'class'=> 'opname'])->label(false) ?>
	<div class="form-group">
        <div class="col-sm-offset-1 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>


<?php $this->beginBlock('cate') ?>  
$(function(){
    $('.opuser').change(function(e){
        e.preventDefault();
        var mobile = $("option:selected", this).attr('mobile');
        var name = $("option:selected", this).attr('name');
        $('.opname').val(name);
        $('.opmobile').val(mobile);
    });
})  

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
