<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\modules\grave\models\Withdraw;

$type = Yii::$app->request->get('type');
$txt = Withdraw::types($type);
$title = '墓位【'.$tomb->tomb_no.'】进行'.$txt.'操作';

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => '退墓记录', 'url' => ['index']];
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
			<div class="col-xs-12 withdraw-create">
				<?= $this->render('_form', [
			        'model' => $model,
                    'oprice' => $oprice,
                    'graves' => $graves
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>