<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Info */
$this->params['current_menu'] = 'task/info/project';

$this->title = ' ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '任务消息管理', 'url' => ['project']];
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
			<div class="col-xs-12 info-update">
				 <?= $this->render('_pro_form', [
				        'model' => $model,
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
