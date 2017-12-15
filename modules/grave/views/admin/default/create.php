<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->title = '添加墓区';
$this->params['breadcrumbs'][] = ['label' => '墓区管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
        </div><!-- /.page-header -->
		<div class="row">
			<div class="col-md-10 col-sm-12 grave-create">
				<?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>