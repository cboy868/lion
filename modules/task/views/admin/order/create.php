<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Order */

$this->title = 'Create Order';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
                <?= Html::encode($this->title) ?>
                <!--
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
				</small>
				-->
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 order-create">
				<?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>