<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Bag */

$this->title = '添加打包';
$this->params['breadcrumbs'][] = ['label' => '打包品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>
                第一步  基础信息填写 
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 bag-create">
				<?= $this->render('_form', [
			        'model' => $model,
			        'rel' => $rel
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>