<?php

use app\core\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */

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
                                <?php $language = Yii::$app->request->get('language');?>
                                <li class="<?php if ($language=='zh-CN'): ?>active<?php endif ?>">
                                    <a href="<?=Url::current(['language'=>'zh-CN'])?>" aria-expanded="true">中文</a>
                                </li>
                                <li class="<?php if ($language=='en-US'): ?>active<?php endif ?>">
                                    <a href="<?=Url::current(['language'=>'en-US'])?>" aria-expanded="true">英文</a>
                                </li>
                                <li class="<?php if ($language=='ja-JA'): ?>active<?php endif ?>">
                                    <a href="<?=Url::current(['language'=>'ja-JA'])?>" aria-expanded="true">日文</a>
                                </li>
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
