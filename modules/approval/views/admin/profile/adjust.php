<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\approval\models\ApprovalLeave;
$this->params['profile_nav'] = 'work';

\app\assets\Treeview::register($this);
\app\assets\JqueryuiAsset::register($this);

?>

<div class="page-content">
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=$this->render('nav')?>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm modalAddButton"
                           href="<?=Url::toRoute(['adjust-create'])?>">
                            <i class="fa fa-plus"></i>  申请调休
                        </a>
                    </div>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '调休申请',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false, 'keyboard'=>false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '编辑调休申请',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false, 'keyboard'=>false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '调休申请详情',
            'id' => 'modalView',
            // 'size' => 'modal'
        ]) ;

        echo '<div id="viewContent"></div>';

        Modal::end();
        ?>
        <div class="row">

            <div class="col-md-12">
                <div class="left-side">
                    <div class="panel panel-sm">
                        <div class="panel-body" style="padding: 10px;">
                            <ul class='tree' data-collapsed='true'>
                                <?php foreach ($cates as $year=>$cate):?>
                                    <li class='<?php if($params['year'] == $year)echo'active'?>'>
                                        <a href='<?=Url::toRoute(['overtime', 'year'=>$year])?>' ><?=$year?></a>
                                        <ul>
                                            <?php foreach ($cate as $m=>$month):?>
                                                <li class='<?php if($params['month'] == $m)echo'active'?>'>
                                                    <a href='<?=Url::toRoute(['overtime', 'year'=>$year,'month'=>$m])?>' >
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
                    <?=\app\core\widgets\Alert::widget()?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                        // 'filterModel' => $searchModel,
                        'columns' => [
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
                            'desc:ntext',
                            'reviewed_by',
                            'created_dtime',
                            [
                                'label' =>'状态',
                                'value' => function($model){
                                    $c = $model->status == ApprovalLeave::STATUS_PASS ? ' text-success' : '';
                                    return '<span class="status '. $c .'">'.$model->statusText .'</span>';
                                },
                                'format' => 'raw'
                            ],

                            [
                                'header' => '操作',
                                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{leave-view} {adjust-update} {leave-undo} {report} {leave-delete}',

                                'buttons' => [
                                    'leave-view' =>function($url, $model, $key) {
                                        return Html::a('详情', $url,
                                            [
                                                'class'=>'modalViewButton',
                                                "data-loading-text"=>"页面加载中, 请稍后...",
                                                "onclick"=>"return false"
                                            ] );
                                    },
                                    'adjust-update' =>function($url, $model, $key) {

                                        if (in_array($model->status, [ApprovalLeave::STATUS_PASS])) {
                                            return Html::a('编辑', '#',
                                                [
                                                    'disabled' => 'disabled'
                                                ]);
                                        } else {
                                            return Html::a('编辑', $url,
                                                [
                                                    'class'=>'modalEditButton',
                                                    "data-loading-text"=>"页面加载中, 请稍后...",
                                                    "onclick"=>"return false"
                                                ] );
                                        }


                                    },
                                    'report' => function($url, $model, $key) {
                                        return '';
                                        //return Html::a('销假', $url, ['title' => '销假'] );
                                    },
                                    'leave-undo' => function($url, $model, $key) {
                                        if ($model->status == ApprovalLeave::STATUS_NORMAL) {
                                            return Html::a('撤销', $url,['title' => '撤销','class'=>'undo'] );
                                        } else if ($model->status == ApprovalLeave::STATUS_DRAFT){
                                            return Html::a('提交', $url,['title' => '提交','class'=>'undo'] );
                                        }else{
                                            return '';
                                        }
                                    },
                                    'leave-delete' => function($url, $model, $key) {
                                        if ($model->status == ApprovalLeave::STATUS_PASS) {
                                            return Html::a('删除', '#', ['disabled' => 'disabled'] );
                                        } else {
                                            return Html::a('删除', $url, ['title' => '删除', 'class'=>'del'] );
                                        }

                                    },
                                ],
                            ]
                        ],
                    ]); ?>
                </div>

            </div>
        </div>


    </div>


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
        $('.tree').each(function() {
            var $this = $(this);
            $this.treeview({collapsed: true, unique: false});
        });
        $('.tree li.active .hitarea').click();


        $('.undo').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
            var that = this;
            $.post(url,{_csrf:csrf},function (xhr) {
                if (xhr.status) {
                    var txt = $(that).text() == '提交' ? '撤销' : '提交';
                    $(that).text(txt);
                    $(that).closest('tr').find('.status').text(xhr.data.statusText);
                } else {
                    alert(xhr.info);
                }
            },'json');
            return false;
        });
        $('.del').click(function (e) {
            e.preventDefault();
            if (!confirm('您确定要删除此请假吗?')) {
                return false;
            }
            var url = $(this).attr('href');
            var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
            var that = this;
            $.post(url,{_csrf:csrf},function (xhr) {
                if (xhr.status) {
                    $(that).closest('tr').remove();
                } else {
                    alert(xhr.info);
                }
            },'json');
            return false;
        });
        $('tbody tr').click(function () {

            $('.modalViewButton',this).triggerHandler('click');
            return false;

        });
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>

