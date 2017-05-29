<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\grave\models\Grave;
use app\core\widgets\Webup\Webup;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Grave */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grave-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
    $graves = Grave::selTree(); 
    ?>
    <?= $form->field($model, 'pid')->dropDownList($graves, ['prompt'=> '顶级'])->label('所属大区') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model,'intro')->widget('app\core\widgets\Ueditor\Ueditor',
        ['option' =>['res_name'=>'grave', 'use'=>'ue'] ]);?>

    <?= $form->field($model, 'area_totle')->textInput()->label('总面积(平米)') ?>

    <?= $form->field($model, 'area_use')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php if (isset($imgs)): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">已上传图片</h3>
            </div>

            <div class="panel-body row">
                <?php foreach ($imgs as $img): ?>
                    <div class="col-xs-3 col-md-2 pic" >
                        <div href="#" class="thumbnail <?php if ($model->thumb == $img['id']): ?>active<?php endif ?>">
                            <img src="<?=$img['url']?>" alt="<?=$img['title']?>" rid="<?=$img['id']?>">
                            <a class="btn btn-danger btn-sm del" href="<?=Url::toRoute(['del-img'])?>"><span class="fa fa-trash"></span></a>
                            <a class="btn btn-success btn-sm cover"><span class="fa fa-flag"></span>封面</a>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>
        </div>
    <?php endif ?>

    <div class="form-group field-goods-pic required">
        <?php echo Webup::widget(['options'=>['res_name'=>'grave']]);?>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model, 'is_show')->radioList([1=>'显示',0=>'不显示'])->label('门户显示') ?>

	<div class="form-group">
        <div class="col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>


<?php $this->beginBlock('img') ?>
$(function(){

$('.del').click(function(e){
e.preventDefault();
var that = this;
if (!confirm('确定要删除此图片?')){
return
}

var url = $(this).attr('href');
var thumb = $(this).siblings('img').attr('rid');
var _csrf = $('meta[name=csrf-token]').attr('content');
var that = this;

$.post(url, {_csrf:_csrf, thumb:thumb}, function(xhr){
if (xhr.status) {
$(that).closest('.pic').fadeOut();
} else {
alert(xhr.info);
}
},'json');

});
$('.cover').click(function(e){
e.preventDefault();
var that = this;

var url = "<?=Url::toRoute(['cover'])?>";
var _csrf = $('meta[name=csrf-token]').attr('content');
var grave_id = "<?=$model->id?>";
var thumb = $(this).siblings('img').attr('rid');

if (thumb == "<?=$model->thumb?>") {
return ;
}


$.post(url, {_csrf:_csrf,grave_id:grave_id,thumb:thumb}, function(xhr){
if (xhr.status) {
$('.thumbnail').removeClass('active');
$(that).closest('.thumbnail').addClass('active');
}
}, 'json');
});

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>
