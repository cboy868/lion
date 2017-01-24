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

    <?php $form = ActiveForm::searchBegin(); ?>

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
        <?= $form->field($model, 'grave_id')->dropDownList(Grave::selTree(['pid'=>0]), ['class'=>'form-control input-sm selg', 'prompt'=>'--选择墓区--', 'options' => $options]); ?>
    </div>

    <?= $form->field($model, 'row') ?>

    <?= $form->field($model, 'col') ?>

     <?= $form->field($model, 'tomb_no'); ?>

    <?= $form->field($model, 'customer_id') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php $this->beginBlock('cate') ?>  
$(function(){

    $(document).on('change', '.selg', function(e){
        e.preventDefault();

        var leaf = $(this).find("option:selected").attr('leaf');
        var grave_id = $(this).val();
        var that = this;


        if (leaf == 1) {
            location.href = "<?=Url::toRoute(['index'])?>?grave_id=" + grave_id;
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
