<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\focus\models\Focus */

?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 focus-update">
				 <?= $this->render('_form', [
				        'model' => $model,
				        'category'=>$category
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
