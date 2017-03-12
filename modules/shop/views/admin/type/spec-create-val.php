<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model modules\foods\models\FoodsAttrVal */

// $this->title = 'Create Foods Attr Val';
// $this->params['breadcrumbs'][] = ['label' => 'Foods Attr Vals', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 foods-attr-val-create">
				<?= $this->render('_specvform', [
			        'model' => $model,
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>