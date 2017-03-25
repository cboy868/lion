<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;
use app\assets\ExtAsset;
use kartik\select2\Select2;

ExtAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\TombSearch */
/* @var $form yii\widgets\ActiveForm */
\app\assets\JqueryUiAsset::register($this);
?>

<style type="text/css">
   /* .selgroup select{
        font-size: 15px;
        font-weight: 800;
        height: 36px;
        line-height: 30px;
        margin-right: 10px;
    }*/
    .sel-ize{
        width:200px;
    }
    .form-inline .form-control.srow, .form-inline .form-control.scol{
        width:80px;
    }
    .selg{
        width:200px;
    }
</style>
<div class="tomb-search">

    <?php $form = ActiveForm::searchBegin(); 
        // $form->action = Url::toRoute(['list']);

    ?>

    <?php 

        $gs = Grave::find()->where(['<>', 'status', Grave::STATUS_DELETE])
                           ->where(['pid'=>0])
                           ->asArray()
                           ->all();


        $options = [];
        foreach ($gs as $k => $v) {
            $options[$v['id']]['leaf'] = $v['is_leaf'];
            $options[$v['id']]['data-leaf'] = $v['is_leaf'];
        }


     ?>
     <input class="grave_id"  type="hidden" name="grave_id" value="<?=Yii::$app->request->get('grave_id')?>" />
        <div class="selgroup" style="margin-bottom:20px;">

     <?php if (Yii::$app->request->get('grave_id')): ?>
        <?php if ($parents): ?>
            <?php foreach ($parents as $k => $parent): ?>
                <?= $form->field($model, 'grave_id')->dropDownList(Grave::selTree(['pid'=>$parent['pid']], 0, ''), ['class'=>'form-control input-sm selg','options' => $options,'value'=>$parent['id'], 'prompt'=>'--选择墓区--'])->label(false); ?>
            <?php endforeach ?>
        <?php else: ?>
            <?= $form->field($model, 'grave_id')->dropDownList(Grave::selTree(['pid'=>$grave->pid], 0, ''), ['class'=>'form-control input-sm selg','options' => $options,'value'=>$grave->id, 'prompt'=>'--选择墓区--'])->label(false); ?>
        <?php endif ?>
    <?php else: ?>


        <?php 
echo $form->field($model, 'grave_id')->widget(Select2::classname(), [
    'data' => Grave::selTree(['pid'=>0]),
    'options' => [
        'placeholder' => '选择墓区 ...',
        'options' => $options,
        'class' => 'selg'
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false);

     ?>








            <?php //each $form->field($model, 'grave_id')->dropDownList(Grave::selTree(['pid'=>0]), ['class'=>'selg sel-ize', 'prompt'=>'--选择墓区--', 'options' => $options])->label(false); ?>

            <?php // $form->field($model, 'grave_id')->dropDownList(Grave::selTree(['pid'=>0]), ['class'=>'selg form-control input-sm', 'prompt'=>'--选择墓区--', 'options' => $options])->label(false); ?>
    <?php endif ?>
        </div>
        

    <?= $form->field($model, 'row')->textInput(['class'=>'form-control srow']) ?>

    <?= $form->field($model, 'col')->textInput(['class'=>'form-control scol']) ?>

    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

     <?php //echo $form->field($model, 'tomb_no'); ?>

    <?= $form->field($model, 'customer_id')->textInput(['class'=>'form-control scus']) ?>

    <div class="form-group">
        <button class="btn btn-primary btn-sm bsearch" type="submit"><i class="fa fa-search"></i> 查找</button>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php $this->beginBlock('cate') ?>  
$(function(){

    var gid = "<?=Yii::$app->request->get('grave_id')?>";
    if (!isNaN(gid)) {
        var da = $('form').serialize();
        getData("<?=Url::toRoute(['list'])?>?grave_id="+ gid + '&' + da);
    }

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

        $('.tfram').load("<?=Url::toRoute(['list'])?>?grave_id="+ grave_id + '&' + da);

    });
    $(document).on('change', '.selg', function(e){
        e.preventDefault();

        var leaf = $("option:selected", this).attr('leaf');

        var grave_id = $(this).val();
        var that = this;


        console.log(leaf);

        $(this).closest('.form-group').nextAll().remove();


        if (grave_id == 0) {
            return;
        }

        if (leaf == 1) {
            $('.grave_id').val(grave_id);
            $(this).closest('.form-group.selg').nextAll().remove();
            //$('.tfram').load("<?=Url::toRoute(['list'])?>?grave_id=" + grave_id);
            getData("<?=Url::toRoute(['list'])?>?grave_id=" + grave_id);
            return ;
        }


        $.get("<?=Url::toRoute(['sel-grave'])?>?grave_id=" + grave_id, {}, function(xhr){
            if (xhr.status) {
                data = xhr.data;
                options = '<option value="">--请选择墓区--</option>';
                for (grave in data) {
                    options += '<option value="'+data[grave].id+'" leaf="'+data[grave].is_leaf+'">'+data[grave].name+'</option>';
                }
                var sel = '<div class="form-group">' +
                            '<select class="form-control input-sm sel-ize selg">' +
                            options +
                            '</select>' +
                            '</div>';
                $(that).closest('.selgroup').append(sel);
            }
        },'json')

    })

})  

function getData(url)
{
    $('.tfram').load(url);
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
