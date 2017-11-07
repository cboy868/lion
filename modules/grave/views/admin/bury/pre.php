<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '预葬记录';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1 >
                <?=$this->title?>
                <small style="">
                        <a class="btn btn-sm btn-danger"
                           href="<?=Url::toRoute(['serial'])?>">
                            <i class="fa fa-sort-amount-asc"></i>为明日安葬逝者编号
                        </a>
                </small>
                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['index'])?>">
                        <i class="fa fa-th fa-2x"></i>  安葬记录</a>
                </div>
            </h1>
        </div><!-- /.page-header -->
        <?php
        Modal::begin([
            'header' => '编辑备注',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '确认安葬',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php echo $this->render('_presearch', ['model' => $searchModel]); ?>
                </div>
            </div>
            <div class="col-md-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <?php

            $today = date('Y-m-d');
            $tomorrow = date("Y-m-d",strtotime("+1 day"));
            $nextday = date("Y-m-d",strtotime("+2 day"));
            ?>

            <div class="col-xs-12 bury-index">
                <div class="widget-box transparent ui-sortable-handle" id="widget-box-13">
                    <div class="widget-header" style="z-index: 0">
                        <div class="widget-toolbar no-border" style="float: left;">
                            <ul class="nav nav-tabs">
                                <li class="<?php if ($searchModel->pre_bury_date == null): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['pre'])?>" aria-expanded="true">全部</a>
                                </li>
                                <li class="<?php if ($searchModel->pre_bury_date === $today): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['pre','BurySearch[pre_bury_date]'=>$today])?>"
                                       aria-expanded="true">今天</a>
                                </li>
                                <li class="<?php if ($searchModel->pre_bury_date == $tomorrow): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['pre','BurySearch[pre_bury_date]'=>$tomorrow])?>"
                                       aria-expanded="true">明天</a>
                                </li>
                                <li class="<?php if ($searchModel->pre_bury_date == $nextday): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['pre','BurySearch[pre_bury_date]'=>$nextday])?>"
                                       aria-expanded="true">后天</a>
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
            [
                'label' => '现场排序',
                'value' => function($model) use ($searchModel){
                    if ($model->bury_order) {
                        return $model->bury_order;
                    }
                    return Html::a('排序', ['sort', 'id'=>$model->id], ['class'=>'btn btn-info btn-sm sort']);
                },
                'format' => 'raw',
                'visible' => $searchModel->pre_bury_date == date('Y-m-d'),
            ],
            [
                'label'=>'墓位号',
                'value' => function($model){
                    return Html::a($model->tomb->tomb_no,
                        ['/grave/admin/tomb/view', 'id'=>$model->tomb_id],['target'=>'_blank']);
                },
                'format' => 'raw'
            ],
            'user.username',
            [
                'label' => '使用人',
                'value' => function($model){
                    $deads = $model->deads;
                    $str = '';
                    foreach ($deads as $v){
                        $serial = '';
                        if ($v->serial) {
                            $serial = '<font color="green"> [序号:'.$v->serial.']</font>';
                        }

                        $str .= $v->dead_name .'('.$v->genderText.','.$v->dead_title.','.$v->boneType.')'.$serial.'<br>';
                    }
                    return $str;
                },
                'format' => 'raw'
            ],
            [
                'label' => '导购员',
                'value' => function($model){
                    if (!isset($model->tomb->guide_id)) {
                        return '';
                    }
                    return $model->tomb->guide->username;
                }
            ],
            // 'dead_num',
             'type',
            [
                'label' => '预葬日期',
                'value' => function($model){
                    return substr($model->pre_bury_date, 0, 10);
                }
            ],
            // 'bury_order',
            [
                'label' => '备注',
                'value' => function($model){
                    $str = '';
                    if ($model->note) {
                        $str .= $model->note .'<br>';
                    }
                    return $str. Html::a('编辑',
                            ['note', 'id'=>$model->id],
                            ['class'=>'modalAddButton btn btn-xs btn-default']);
                },
                'format' => 'raw'
            ],
            'created_at:datetime',
            // 'updated_at',
            // 'status',
            [
                'header' => '操作',
                'headerOptions' => ['width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {confirm} {sign}',
                'visibleButtons' =>[
                    'confirm' =>Yii::$app->user->can('grave/bury/confirm'),
                    'delete' =>Yii::$app->user->can('grave/bury/delete'),
                ],
                'buttons' => [
                    'confirm' => function($url, $model, $key) {
                        return Html::a('确认安葬', $url, [
                                'title' => '确认安葬',
                                'data-confirm' => '请确定此记录已完成',
                                'data-method'=>"post",
                                'data-pjax' => '0'
                        ] );
                    },
                    'sign' => function($url, $model, $key) {
                        return Html::a('<i class="fa fa-print"></i>打印桌签',$url,['target'=>'_blank']);
                    }
                ],
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('up') ?>
    $(function () {
        $('.sort').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var that = this;
            $.post(url,{},function(xhr){
                if(xhr.status) {
                    $(that).closest('td').text(xhr.data.sort);
                } else {
                    alert(xhr.info);
                }

            },'json');
        });
    })

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?>
