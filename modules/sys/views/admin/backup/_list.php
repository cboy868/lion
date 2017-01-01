<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

echo GridView::widget([
		'id' => 'install-grid',
		'dataProvider' => $dataProvider,
		'columns' => array(
				[
					'label' => '备份文件名',
					'attribute' => 'name'
				],
				[
					'label' => '文件大小(kb)',
					'attribute' => 'size'
				],
				[
					'label' => '添加时间',
					'attribute' => 'create_time'
				],
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{download} {restore} {delete}',
					'header' => '操作',
					'buttons' => [
						'download' => function ($url, $model) {
							$url = Url::toRoute(['download','filename'=>$model['name']]);
							return Html::a('<span class="fa fa-download"></span>下载', $url, [
								'title' => '下载此备份',
							]);
						},
						'restore' => function ($url, $model) {
							$url = Url::toRoute(['restore','filename'=>$model['name']]);
							return Html::a('<span class="glyphicon glyphicon-import"></span>导入', $url, [
								'title' => '下载此备份',
							]);
						},
						'delete' => function ($url, $model) {
							$url = Url::toRoute(['delete','file'=>$model['name']]);
							return Html::a('<span class="fa fa-trash"></span>删除', $url, [
								'title' => '删除此备份',
								'aria-label'=>"删除此备份",
								'data-confirm'=>"您确定要删除此项吗？",
								'data-method'=>"post",
								'data-pjax'=>"0",
								'class' => 'text-danger'
							]);
						}

					],
				]
		),
]); ?>

