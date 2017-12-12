<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\approval\models\ApprovalLeave;
use yii\bootstrap\Modal;

$this->title = '调休管理';
$this->params['breadcrumbs'][] = ['label' => '考勤管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\app\assets\Treeview::register($this);
$yr = Yii::$app->request->get('year');
$mth = Yii::$app->request->get('month');
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=$this->title?>
                <small>
                </small>
            </h1>
        </div><!-- /.page-header -->
        <?php
        Modal::begin([
            'header' => '调休详情',
            'id' => 'modalView',
            // 'size' => 'modal'
        ]) ;

        echo '<div id="viewContent"></div>';

        Modal::end();
        ?>


        <?php
        Modal::begin([
            'header' => '拒绝原因',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false, 'keyboard'=>false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel, 'params'=>$params]); ?>
                </div>
            </div>
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
                <div class="left-side">
                    <div class="panel panel-sm">
                        <div class="panel-body" style="padding: 10px;">
                            <ul class='tree' data-collapsed='true'>
                                <?php foreach ($cates as $year=>$cate):?>
                                    <li class='<?php if($params['year'] == $year)echo'active'?>'>
                                        <a href='<?=Url::toRoute(['index', 'year'=>$year])?>' ><?=$year?></a>
                                        <ul>
                                            <?php foreach ($cate as $m=>$month):?>
                                                <li class='<?php if($params['month'] == $m)echo'active'?>'>
                                                    <a href='<?=Url::toRoute(['index', 'year'=>$year,'month'=>$m])?>' >
                                                        <?=$m?>月
                                                    </a>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="main">


                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            'user.username',
                            'typeLabel',
                            [
                                'label' => '开始时间',
                                'value' => function($model){
                                    return $model->start_day .' '. $model->start_time;
                                }
                            ],
                            [
                                'label' => '结束时间',
                                'value' => function($model){
                                    return $model->end_day .' '. $model->end_time;
                                }
                            ],
                            'hours',
                            'finish_at',
                            'desc:ntext',
                            'reason:ntext',
                            'reviewed_by',
                            'created_dtime',
                            [
                                'label' =>'状态',
                                'value' => function($model){
                                    switch ($model->status) {
                                        case ApprovalLeave::STATUS_PASS : $c='text-success';
                                        break;
                                        case ApprovalLeave::STATUS_REFUSE : $c='text-danger';
                                        break;
                                        default:
                                            $c = '';
                                    }
                                    return '<span class="status '. $c .'">'.$model->statusText .'</span>';
                                },
                                'format' => 'raw'
                            ],

                            [
                                'header' => '操作',
                                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {pass} {refuse}',

                                'buttons' => [
                                    'view' =>function($url, $model, $key) {
                                        return Html::a('详情', $url,
                                            [
                                                'class'=>'modalViewButton',
                                                "data-loading-text"=>"页面加载中, 请稍后...",
                                                "onclick"=>"return false"
                                            ]);
                                    },
                                    'pass' =>function($url, $model, $key) {
                                        if ($model->status != ApprovalLeave::STATUS_NORMAL) {
                                            return '';
                                        }
                                        return Html::a('通过', $url,
                                            [
                                                'class'=>'pass',
                                            ]);
                                    },
                                    'refuse' =>function($url, $model, $key)use($yr,$mth) {
                                        if ($model->status != ApprovalLeave::STATUS_NORMAL) {
                                            return '';
                                        }
                                        $url = Url::toRoute(['refuse', 'id'=>$model->id,'year'=>$yr,'month'=>$mth]);
                                        return Html::a('拒绝', $url,
                                            [
                                                'class'=>'refuse modalEditButton',
                                                "data-loading-text"=>"页面加载中, 请稍后...",
                                                "onclick"=>"return false"
                                            ]);
                                    }

                                ],
                            ]

                        ],
                    ]); ?>
                </div>

            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<style>
    .left-side {
        left: 20px;
        position: absolute;
        width: 140px;
    }
    .main {
        padding-left: 160px;
        margin-right: 0;
    }
    a.disabled, a.disabled:focus, a.disabled:hover, a[disabled], a[disabled]:focus, a[disabled]:hover {
        color: #aaa;
        text-decoration: none;
        cursor: default;
    }
</style>
<?php $this->beginBlock('foo') ?>
$(function(){
    var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
    $('.tree').each(function() {
        var $this = $(this);
        $this.treeview({collapsed: true, unique: false});
    });
    $('.tree li.active .hitarea').click();

    $('tbody tr').click(function () {
        $('.modalViewButton',this).triggerHandler('click');
        return false;
    });

    $('.pass').click(function (e) {
        e.preventDefault();
        if (!confirm('确定要执行此操作吗？')){return false;}

        var url = $(this).attr('href');
        $.post(url,{_csrf:csrf},function (xhr) {
            if (xhr.status) {
                location.reload();
            } else {
                alert(xhr.info);
            }
        }, 'json');

        return false;
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>

