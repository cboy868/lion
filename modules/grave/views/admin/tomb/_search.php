<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\TombSearch */
/* @var $form yii\widgets\ActiveForm */
\app\assets\JqueryUiAsset::register($this);
?>

<div class="tomb-search">

    <?php $form = ActiveForm::searchBegin(); 
        $form->action = Url::toRoute(['list']);

    ?>

    <div class="selgroup" style="margin-bottom:20px;">
    <?php 


        $gs = Grave::find()->where(['<>', 'status', Grave::STATUS_DELETE])
                           ->where(['pid'=>0])
                           ->asArray()
                           ->all();

        $options = [];
        foreach ($gs as $k => $v) {
            $options[$v['id']]['leaf'] = $v['is_leaf'];
        }

     ?>
        <input class="grave_id"  type="hidden" />
        <?= $form->field($model, 'grave_id')->dropDownList(Grave::selTree(['pid'=>0]), ['class'=>'form-control input-sm selg', 'prompt'=>'--选择墓区--', 'options' => $options]); ?>
    </div>

    <?= $form->field($model, 'row')->textInput(['class'=>'form-control srow']) ?>

    <?= $form->field($model, 'col')->textInput(['class'=>'form-control scol']) ?>

     <?php //echo $form->field($model, 'tomb_no'); ?>

    <?= $form->field($model, 'customer_id')->textInput(['class'=>'form-control scus']) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm bsearch', 'type'=>'button']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php $this->beginBlock('cate') ?>  
$(function(){

    $(".srow, .scol, scus").blur(function(e){
        e.preventDefault();

        if ($('.grave_id').val() != '') {
            $('.bsearch').trigger('click');
        }
        
    });
    
    $('.bsearch').click(function(e){
        e.preventDefault();
        var da = $(this).closest('form').serialize();
        var grave_id = $('.grave_id').val();

        console.log("<?=Url::toRoute(['list'])?>?grave_id="+ grave_id + '&' + da);
        $('.tfram').load("<?=Url::toRoute(['list'])?>?grave_id="+ grave_id + '&' + da);

    });
    $(document).on('change', '.selg', function(e){
        e.preventDefault();

        var leaf = $(this).find("option:selected").attr('leaf');
        var grave_id = $(this).val();
        var that = this;


        if (leaf == 1) {
            // $('.tfram').attr('src', "<?=Url::toRoute(['list'])?>?grave_id=" + grave_id)

            $('.grave_id').val(grave_id);
            $('.tfram').load("<?=Url::toRoute(['list'])?>?grave_id=" + grave_id);
            return ;
            // location.href = "<?=Url::toRoute(['index'])?>?grave_id=" + grave_id;
        }

        $.get("<?=Url::toRoute(['sel-grave'])?>?grave_id=" + grave_id, {}, function(xhr){
            $(that).closest('.form-group').nextAll().remove();
            if (xhr.status) {
                data = xhr.data;
                options = '<option value="">请选择墓区</option>';
                for (grave in data) {
                    options += '<option value="'+data[grave].id+'" leaf="'+data[grave].is_leaf+'">'+data[grave].name+'</option>';
                }
                var sel = '<div class="form-group">' +
                            '<select class="form-control input-sm selg">' +
                            options +
                            '</select>' +
                            '</div>';
                $(that).closest('.selgroup').append(sel);
            }
        },'json')

    })

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
