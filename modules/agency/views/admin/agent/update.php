<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\ActiveForm;

$this->params['current_menu'] = 'agency/default/index';

$this->title = ' ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '业务员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改【' . $model->username .'】的信息';
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
			<div class="col-xs-12 user-update">
				 <?= $this->render('_update', [
			        'model' => $model,
			        'attach' => $attach,
                	'addition' => $addition,
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
