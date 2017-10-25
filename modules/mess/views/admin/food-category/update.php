<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\mess\models\MessFoodCategory */

$this->title = ' ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mess Food Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
				<?= Html::encode($this->title) ?>
				<small>
					修改详细信息
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 mess-food-category-update">
				 <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
