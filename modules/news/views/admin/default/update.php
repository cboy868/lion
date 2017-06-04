<?php

use app\core\helpers\Html;
use yii\helpers\Url;

$this->title = ' ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '新闻资讯管理', 'url' => ['index']];
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
			<div class="col-xs-12 news-update">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="border:none;">
                        <div class="widget-toolbar" style="z-index: 2">
                            <button class="btn btn-xs btn-light">
                                智能翻译
                            </button>
                        </div>
                        <div class="no-border">
                            <ul class="nav nav-tabs">
                                <?php
                                $language = Yii::$app->request->get('language');
                                $language = $language ? $language : $main_language;
                                ?>
                                <?php foreach ($languages as $k=>$v):?>
                                <li class="<?php if ($language==$k): ?>active<?php endif ?>">
                                    <a href="<?=Url::current(['language'=>$k])?>" aria-expanded="true"><?=$v?></a>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <div class="widget-body">
				<?php 
					$fm = '_' . $type . 'form';
				 ?>
				 <?= $this->render($fm, [
				        'model' => $model,
				        'imgs' => isset($imgs) ? $imgs :'',
                        'tags' => $tags
				    ]) ?>
                    </div>
                </div>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">操作选择</h4>
            </div>
            <div class="modal-body">
                <a href="<?=Url::toRoute(['update', 'id'=>Yii::$app->request->get('id')])?>" class="btn btn-info">编辑其它语言</a>
                <a href="<?=Url::toRoute(['create'])?>" class="btn btn-info">继续添加</a>
                <a href="<?=Url::toRoute(['index', 'type'=>$model->type])?>" class="btn btn-info">返回列表页</a>
            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('cate') ?>
$(function(){
<?php if($i18n):?>
    $('#myModal').modal();
<?php endif;?>
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>
