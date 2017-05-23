<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\helpers\ArrayHelper;
use app\core\widgets\ActiveForm;
use app\modules\cms\models\Category;
/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\AlbumSearch */
/* @var $form yii\widgets\ActiveForm */
$mid = Yii::$app->request->get('mid');
?>

<div class="album-search">


<?php 
$mod = \Yii::$app->getRequest()->get('mod');
?>

    <?php $form = ActiveForm::searchBegin(); ?>
    <input type="hidden" name="mid" value="<?=$mid?>"/>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'category_id')
        ->dropDownList(ArrayHelper::map(Category::sortTree(['mid'=>$mid]), 'id', 'name'), ['prompt'=>'所有分类']) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index', 'id'=>$mid]),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
