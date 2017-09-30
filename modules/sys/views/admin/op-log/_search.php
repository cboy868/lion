<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\sys\models\OpLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="op-log-search">

    <?php $form = ActiveForm::searchBegin(); ?>

    <?= $form->field($model, 'user_id')
        ->dropDownList(ArrayHelper::map(User::staffs(), 'id', 'username'),
            ['prompt'=>'选择操作人']) ?>

    <?= $form->field($model, 'table_name') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
