<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use kartik\export\ExportMenu;

\app\assets\JqueryFormAsset::register($this);
$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>

                    <?php if (Yii::$app->user->can('user/default/create')):?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                    <?php endif;?>

                    <?php  //echo  Html::a('<i class="fa fa-trash"></i> 清除不活跃用户', ['drop'], [
                                //'class' => 'btn btn-danger btn-sm new-menu',
                               // 'data-confirm'=>"此操作不可恢复，请慎重？",
                                //'data-method'=>"post"])
                    ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">


            <div class="col-xs-12">
                <?php

                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'username',
                    'status',
                    ['class' => 'yii\grid\ActionColumn'],
                ];

                // Renders a export dropdown menu
                echo ExportMenu::widget([
                    'dataProvider'  => $dataProvider,
                    'columns' => $gridColumns
                ]);

                // You can choose to render your own GridView separately
                echo \kartik\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumns
                ]);

                ?>
            </div>


            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 user-index">

                <div class="widget-box transparent ui-sortable-handle" >

                    <?php
                    $is_staff = Yii::$app->request->get('is_staff');
                    ?>
                    <div class="widget-header" style="z-index: 0">
                        <div class="no-border">
                            <ul class="nav nav-tabs">
                                <li class="<?php if ($is_staff === null): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['index'])?>" aria-expanded="true">全部</a>
                                </li>
                                <li class="<?php if ($is_staff == 1): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['index','is_staff'=>1])?>" aria-expanded="true">员工</a>
                                </li>
                                <li class="<?php if ($is_staff == 2): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['index','is_staff'=>2])?>" aria-expanded="true">业务员</a>
                                </li>
                                <li class="<?php if ($is_staff == 0 && $is_staff!==null): ?>active<?php endif ?>">
                                    <a href="<?=Url::toRoute(['index','is_staff'=>0])?>" aria-expanded="true">客户</a>
                                </li>

                                <li style="float: right;">

                                    <form enctype="multipart/form-data" method="post" action="<?=Url::toRoute(['import'])?>" class="cover-form form-inline">
                                        <div class="form-group " style="margin:0px;">
                                            <input type="file" class="form-control input-sm up-excel" name="users" value="" style="">
                                        </div>
                                        <a href="#" class="btn btn-default">下载模板</a>
                                    </form>

                                </li>

                            </ul>

                        </div>

                    </div>

                </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'id' => 'grid',
        'showFooter' => true,  //设置显示最下面的footer
        'columns' => [
            [
                'class'=>yii\grid\CheckboxColumn::className(),
                'name'=>'id',  //设置每行数据的复选框属性
                'headerOptions' => ['width'=>'30', "data-type"=>"html"],
                'footer' => Yii::$app->user->can('user/default/batch-del') ? '<input type="checkbox" class="select-on-check-all" name="id_all" value="1"> '.
                    '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>' : '',
                'footerOptions' => ['colspan' => 6, 'class'=>'deltd'],  //设置删除按钮垮列显示；
            ],
//            'id',
            [
                'label' => '账号',
                'value' => function($model){
                    return Html::img($model->getAvatar('36x36', '/static/images/avatar.png')) . $model->username;
                },
                'format' => 'raw'
            ],
            'mobile',
            'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' =>[
                    'update' =>Yii::$app->user->can('user/default/update'),
                    'view' =>Yii::$app->user->can('user/default/view'),
                    'delete' =>Yii::$app->user->can('user/default/delete'),
                ],

            ],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('foo') ?>
$(function(){

    $(".up-excel").change(function () {
        var _this = this;
        //$(_this).closest('div').html('文件正在上传，请稍后');
        $(this).closest('form').ajaxSubmit({
            dataType: 'json',
            success: function (data) {
                if ( data.status ) {
                    console.dir(data);
                } else {
                    alert(data.info);
                }
            },
            error: function (data) {}
        });
    });

    $('td.deltd').siblings('td').remove();

    $('.btn-delete').click(function(){
        var ids = $('#grid').yiiGridView('getSelectedRows');

        if (ids.length<1) {
            alert('请先选择要删除的账号');
            return;
        }
        if (!confirm("您确定要删除这些账号吗?,删除后不可恢复")){return false;}

        var url = "<?=Url::toRoute(['batch-del'])?>";

        $.post(url, {ids:ids},function(xhr){
            if (xhr.status){
                location.reload();
            } else {
                alert(xhr.info);
            }
        },'json');

    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>

