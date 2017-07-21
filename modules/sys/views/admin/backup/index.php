<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

$this->title = '数据备份';
$this->params['breadcrumbs'][] = ['label' => '系统管理', 'url' => ['admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">

        	<div class="page-header">
				<h1>
	                <?= Html::encode($this->title) ?>
					<small>
						<div class="btn-group pull-right">
                            <?php if (Yii::$app->user->can('sys/backup/index')):?>
			        		<a href="<?=Url::toRoute(['index'])?>" class="btn btn-info">备份列表</a>
                            <?php endif;?>
                            <?php if (Yii::$app->user->can('sys/backup/create')):?>
			        		<a href="<?=Url::toRoute(['create'])?>" class="btn btn-info">创建新备份</a>
                            <?php endif;?>
                            <?php if (Yii::$app->user->can('sys/backup/upload')):?>
			        		<a href="<?=Url::toRoute(['upload'])?>" class="btn btn-info">上传备份文件</a>
                            <?php endif;?>
                            <?php if (Yii::$app->user->can('sys/backup/clean')):?>
			        		<a href="<?=Url::toRoute(['clean'])?>" class="btn btn-warning">清空数据库</a>
                            <?php endif;?>
						</div>
					</small>
				</h1>

			</div><!-- /.page-header -->

        	<div class="col-xs-12">
	        	<?php if(Yii::$app->session->hasFlash('success')): ?>
				<div class="alert alert-success" style="word-break: break-all;word-wrap: break-word;">
					<?php echo Yii::$app->session->getFlash('success'); ?>
				</div>
				<?php endif; ?>
        	</div>

            <div class="col-xs-12">

    			<?= $this->render ( '_list', array (
							'dataProvider' => $dataProvider 
					));
				?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>



