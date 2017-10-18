<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

\app\assets\JqueryFormAsset::register($this);
$this->title = '业务员列表';
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'],
                            [
                                'class' => 'btn btn-primary btn-sm new-menu modalAddButton',
                                'data-loading-text'=>"页面加载中, 请稍后...",
                                'onclick'=>"return false"
                            ]) ?>
                    <?php endif;?>

                    <?php  //echo  Html::a('<i class="fa fa-trash"></i> 清除不活跃用户', ['drop'], [
                                //'class' => 'btn btn-danger btn-sm new-menu',
                               // 'data-confirm'=>"此操作不可恢复，请慎重？",
                                //'data-method'=>"post"])
                    ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '新增',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false, 'keyboard'=>false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 user-index">
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
            'cate.title',
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

