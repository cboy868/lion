<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;


$this->title = ' ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '我的审批', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
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
			<div class="col-xs-12 approval-update">
				 <?= $this->render('_form', [
				        'model' => $model,
                        'attachs' => $attachs
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
