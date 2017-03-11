<?php 
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;
use app\core\helpers\Html;
use app\core\helpers\Url;
//use app\assets\ExtAsset;
use kartik\select2\Select2;


//ExtAsset::register($this);
?>
<style type="text/css">
    .selectize-input {
        padding: 6px 8px;
        overflow: inherit;
        border-radius: 0px;
    }
    .form-inline .form-group{
        margin-bottom: 10px;
    }
    .form-grave-sel{
        width:35%;
    }
</style>
<div class="tomb-search">

    <?php $form = ActiveForm::searchBegin();?>
    <?php $form->options['id'] = 'tsearch';
          $form->action = Url::toRoute(['/grave/admin/tomb/search-list']); 
    ?>

         <?php 
         $form->fieldConfig['options']['class'] = 'form-group form-grave-sel';
            echo $form->field($model, 'grave_id')->widget(Select2::classname(), [
                'data' => Grave::selTree(['is_leaf'=>1], 0, ''),
                'size' => Select2::SMALL,
                'options' => [
                    'placeholder' => '选择墓区',
                    'options' => $options,
                    'class' => 'selg'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);

            $form->fieldConfig['options']['class'] = 'form-group';

        ?>
        <?= $form->field($model, 'row')->textInput(['class'=>'form-control srow', 'placeholder'=>'排'])->label(false) ?>
        <?= $form->field($model, 'col')->textInput(['class'=>'form-control scol', 'placeholder'=>'号'])->label(false) ?>

    <?php ActiveForm::end(); ?>

    <div class="tfram"></div>

</div>


<?php $this->beginBlock('cate') ?>  
$(function(){
$.fn.modal.Constructor.prototype.enforceFocus = function () { }
$('.sel-ize').each(function(index, item){
    var $this = $(item);
    if ( !$this.data('select-init') ) {
        $this.selectize({
            //create: true
        });
        $this.data('select-init', true);
    }
});


$('.selg, .srow, .scol').change(function(){
    var gid = $('.selg').val();
    var row = $('.srow').val();
    var col = $('.scol').val();

    if (!(gid && row && col)) {
        return ;
    }

    var data = $('form#tsearch').serialize();


    $.get("<?=Url::toRoute(['/grave/admin/tomb/search-list'])?>", data, function(xhr){
        $('.tfram').html(xhr);
    },'html');

});

})  

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  

