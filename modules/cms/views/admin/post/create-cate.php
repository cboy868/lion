<?php

use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\cms\models\Category;



/* @var $this yii\web\View */
/* @var $model shop\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 post-category-create">
				
			<div class="category-form">

			    <?php $form = ActiveForm::begin(); ?>

			    <?= $form->field($model, 'pid')->hiddenInput(['value'=>Yii::$app->request->get('pid')])->label(false) ?>

			    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

			    <div class="form-group">
			        <div class="col-sm-offset-2 col-sm-3">
			            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
			        </div>
			    </div>
			    
			    <?php ActiveForm::end(); ?>

			</div>

			<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>