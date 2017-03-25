<?php 
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;
use app\core\helpers\Html;
use app\core\helpers\Url;
//use app\assets\ExtAsset;
use kartik\select2\Select2;
use yii\bootstrap\Modal;


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

<?php 
    Modal::begin([
        'header' => '新增',
        'id' => 'modalAdd',
        // 'size' => 'modal'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
?>

<div class="tomb-search">
<table class="table">
    <?php foreach ($tombs as $k => $tomb): ?>
        <tr>
            <td width="30%"><?=$tomb->tomb_no?></td>
            <td width="70%">
                <div class="form-group pull-right">
                    <a href="<?=Url::toRoute(['/grave/admin/tomb/option', 'id'=>$tomb->id, 'client_id'=>Yii::$app->request->get('client_id')])?>" class="btn btn-info btn-sm mAddButton">办理业务</a>
                </div>
            </td>
        </tr>
    <?php endforeach ?>
    
</table>
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
                    // 'options' => $options,
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

<?php $this->beginBlock('c') ?>  
$(function(){
    $('.mAddButton').click(function(e){
        e.preventDefault();
        //加载完再显示，看着舒服一点
        $('#modalAdd').find('#modalContent')
                    .load($(this).attr('href'),function(){
                        $('#modalAdd').modal('show');
                    });
    });

})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['c'], \yii\web\View::POS_END); ?>  
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


    $.get("<?=Url::toRoute(['/grave/admin/tomb/search-list', 'client_id'=>Yii::$app->request->get('client_id')])?>", data, function(xhr){
        $('.tfram').html(xhr);
    },'html');

});

})  

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  

