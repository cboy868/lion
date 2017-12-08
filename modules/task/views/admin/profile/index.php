<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\core\widgets\GridView;
$this->params['profile_nav'] = 'task';

$this->title = '我的任务';
$this->params['breadcrumbs'][] = ['label' => '个人中心', 'url' => ['/user/admin/profile/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-content">
    <div class="col-sm-12">

        <div id="user-profile-2" class="user-profile">
            <div class="tabbable">

                <div class="tab-content padding-12">
                    <div class="tab-pane active">
                        <div class="col-xs-12">
                            <div class="search-box search-outline">
                                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                            </div>
                        </div>

                        <!-- table start -->
                        <div class="col-xs-12 task-index">
                            <div class="widget-box transparent ui-sortable-handle" id="widget-box-13">
                                <div class="widget-header" style="z-index: 0">
                                    <div class="widget-toolbar no-border" style="float: left;">
                                        <ul class="nav nav-tabs">
                                            <?php $t = Yii::$app->request->get('t')?>
                                            <li class="<?php if(!$t) echo 'active';?>">
                                                <a href="<?=Url::toRoute(['/task/admin/profile/index'])?>" aria-expanded="true">全部</a>
                                            </li>
                                            <li class="<?php if($t==1) echo 'active';?>">
                                                <a href="<?=Url::toRoute(['/task/admin/profile/index', 't'=>1])?>" aria-expanded="true">今日任务</a>
                                            </li>
                                            <li class="<?php if($t==2) echo 'active';?>">
                                                <a href="<?=Url::toRoute(['/task/admin/profile/index', 't'=>2])?>" aria-expanded="true">明日任务</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                                // 'filterModel' => $searchModel,
                                'columns' => [
                                    'id',
//                                    'info.name',
                                    'user.username',
                                    'title',
                                    'content:ntext',
                                    'pre_finish:date',
                                    'finish',
                                    'statusText',
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header'=>'操作',
                                        'template' => '{view} {finish}',
                                        'visibleButtons' =>[
                                            'view' => Yii::$app->user->can('task/default/view'),
                                            'delete' => Yii::$app->user->can('task/default/delete'),
                                            'finish' => Yii::$app->user->can('task/default/finish')
                                        ],
                                        'buttons' => [
                                            'finish' => function($url, $model, $key) {
                                                if ($model->pre_finish < date('Y-m-d')) {
                                                    return '<span class="overdue">任务过期</span>';
                                                }
                                                if ($model->status == $model::STATUS_FINISH) {
                                                    return '';
                                                }
                                                return Html::a('<span class="fa fa-check"></span>', $url, ['title' => '完成'] );
                                            }
                                        ],
                                        'headerOptions' => ['width' => '100',"data-type"=>"html"]
                                    ]
                                ],
                            ]); ?>
                            <div class="hr hr-18 dotted hr-double"></div>
                        </div><!-- /.col -->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>