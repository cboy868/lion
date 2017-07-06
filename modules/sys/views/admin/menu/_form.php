<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\sys\models\AuthPermission;
use app\core\helpers\Url;
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->dropDownList($model->getMenus()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mod')->dropDownList(AuthPermission::getMods(),['prompt'=>'选择模块','class'=>'form-control mod']) ?>

    <?= $form->field($model, 'ctrl')->dropDownList(AuthPermission::getCtrls($model->mod),['prompt'=>'选择控制器','class'=>'form-control ctrl']) ?>

    <?= $form->field($model, 'auth_name')->dropDownList(AuthPermission::getMethods($model->ctrl),['prompt'=>'选择方法','class'=>'form-control method']) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>


<?php $this->beginBlock('auth') ?>  
$(function(){
    $('.mod').change(function(){
        var parent = $(this).val();
        getSelects(parent, 1);
    });

    $('.ctrl').change(function(){
        var parent = $(this).val();
        getSelects(parent, 2);
    });
})

function getSelects(parent, type)
{
    var data = {parent:parent, type:type};
    var url = "<?=Url::toRoute('items')?>";
    var html = '';
    $.get(url, data, function(xhr){
        if (xhr.status) {
            for (i in xhr.data) {
                html += '<option value="'+i+'">'+i+'</option>'
            };
            if (type == 1) {
                $('.ctrl').html(html);
                $('.ctrl').trigger('change');
            };
            if (type == 2) {
                $('.method').html(html);
            };
        };
    }, 'json');
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['auth'], \yii\web\View::POS_END); ?>  
