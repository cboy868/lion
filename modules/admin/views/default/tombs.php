<?php
use yii\helpers\Url;
use app\modules\grave\models\Grave;
use kartik\select2\Select2;
use app\core\widgets\ActiveForm;
use yii\bootstrap\Modal;

$this->title = '我的工作台';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
Modal::begin([
    'header' => '业务操作',
    'id' => 'modalAdd',
    'size' => Modal::SIZE_LARGE,
    'footer' => '<button class="btn btn-info" data-dismiss="modal">取消</button>',
]) ;

echo '<div id="modalContent"></div>';

Modal::end();
?>


<table class="table table-striped table-hover table-bordered table-condensed table-tombs">

<?php foreach ($dataProvider->getModels() as $model):?>
<tr>
<td>
    <a href="<?=Url::toRoute(['/grave/admin/tomb/view', 'id'=>$model->id])?>" target="_blank">
        <?=$model->tomb_no?>
    </a>
    <?=$model->customer ? $model->customer->name : ''?>
    <?=$model->customer ? $model->customer->mobile : ''?>
    <?=$model->statusText?></td>
<td width="80">
    <a href="<?=Url::toRoute(['/grave/admin/tomb/option','id'=>$model->id])?>"
        class="mAddButton btn btn-default btn-xs"
        data-loading-text="等待..."
        onclick="return false">
        办理业务
    </a>
</td>
</tr>
<?php endforeach;?>
</table>
<?php $this->beginBlock('cate') ?>
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
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>