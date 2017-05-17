<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;

?>

<div class="page-content">
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 album-update">
				 <?= $this->render('_form', [
				        'model' => $model,
				        'attach'=> $attach,
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
