<?php

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\focus\models\Category;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\focus\models\Focus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="focus-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); 
    ?>

    <?= $form->field($model, 'category_id')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput(['maxlength' => true, 'class'=>'form-control img'])->hint($category->intro) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?= Html::submitButton('保 存', ['class' =>'btn btn-primary btn-block']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('cate') ?>
$('.sel').change(function(){
    var intro = $(this).find("option:selected").attr('intro');
    $('.img').siblings('.hint-block').text(intro);
})
<?php $this->endBlock('cate') ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>
