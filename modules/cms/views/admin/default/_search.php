<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\AlbumSearch */
/* @var $form yii\widgets\ActiveForm */
$id = Yii::$app->request->get('id');
?>

<div class="album-search">


<?php 
$mod = \Yii::$app->getRequest()->get('mod');
?>

    <?php $form = ActiveForm::searchBegin(); ?>
    <input type="hidden" name="id" value="<?=$id?>"/>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index', 'id'=>$id]),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
