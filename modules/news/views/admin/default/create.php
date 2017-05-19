<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\modules\news\models\News;
/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */



$type = Yii::$app->request->get('type');

$this->title = '添加'.News::$types[$type].'资讯';
$this->params['breadcrumbs'][] = ['label' => '新闻资讯管理', 'url' => ['index']];
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
			<div class="col-xs-10 news-create">
			<?php 
				$fm = '_' . $type . 'form';
			 ?>
				<?= $this->render($fm, [
			        'model' => $model,
                    'tags' => $tags
			    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>