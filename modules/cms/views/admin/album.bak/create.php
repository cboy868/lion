<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Album */

$this->title = '上传' . $modinfo->name;
$this->params['breadcrumbs'][] = ['label' => $modinfo->name, 'url' => ['index','mod'=>\Yii::$app->getRequest()->get('mod')]];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
	.old{
		display: none;
	}
</style>
<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="row">
			<div class="col-xs-12 album-create">
				<?= $this->render('_form', [
			        'model' => $model,
			        'attach'=> $attach,
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>

