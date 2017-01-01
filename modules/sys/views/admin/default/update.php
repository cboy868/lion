<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Set */

$this->title = ' ' . ' ' . $model->sname;
$this->params['breadcrumbs'][] = ['label' => '网站设置', 'url' => ['list']];
$this->params['breadcrumbs'][] = '更新';
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
			<div class="col-xs-6 set-update">
				 <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
