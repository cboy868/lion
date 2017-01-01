<?php

use yii\helpers\Html;
use yii\helpers\Url;

use app\core\widgets\ActiveForm;
use app\modules\focus\models\Category;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\focus\models\FocusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="focus-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'title') ?>

    <?php echo $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'title')) ?>

    <div class="form-group">
        <?= Html::submitButton('查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
