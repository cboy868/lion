<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\news\models\News;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '新闻资讯管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  $this->title ?> 
                <small>

                    <div class="pull-right nc">
                        <a class="btn btn-danger btn-sm" href="<?=Url::toRoute(['/news/admin/category/index'])?>">
                            <i class="fa fa-list-ol fa-2x"></i>  分类管理</a>
                    </div>
                    
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['create', 'type'=>'text'])?>">
                            <i class="fa fa-file-text fa-2x"></i>  添加文本资讯</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['create', 'type'=>'image'])?>">
                            <i class="fa fa-file-image-o fa-2x"></i>  添加图文资讯</a>
                    </div>
                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['create', 'type'=>'video'])?>">
                            <i class="fa fa-file-video-o fa-2x"></i>  添加视频资讯</a>
                    </div>
                </small>
            </h1>
        </div><!-- /.page-header -->


        <div class="row">

            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget()?>
            </div>

            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 news-index">

            <div class="widget-box transparent ui-sortable-handle">
                <div class="widget-header" style="border:none;">
                    <div class="no-border">
                        <ul class="nav nav-tabs">
                            <li class="<?php if (!$type): ?>active<?php endif ?>">
                                <a href="<?=Url::toRoute(['index'])?>" aria-expanded="true">全部</a>
                            </li>
                            <li class="<?php if ($type=='1'): ?>active<?php endif ?>">
                                <a href="<?=Url::toRoute(['index', 'type'=>1])?>" aria-expanded="true">文本资讯</a>
                            </li>
                            <li class="<?php if ($type=='2'): ?>active<?php endif ?>">
                                <a href="<?=Url::toRoute(['index', 'type'=>2])?>" aria-expanded="true">图文资讯</a>
                            </li>
                            <li class="<?php if ($type=='3'): ?>active<?php endif ?>">
                                <a href="<?=Url::toRoute(['index', 'type'=>3])?>" aria-expanded="true">视频资讯</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        'id' => 'grid',
        'showFooter' => true,  //设置显示最下面的footer
        'columns' => [
            [
                'class'=>yii\grid\CheckboxColumn::className(),
                'name'=>'id',  //设置每行数据的复选框属性
                'headerOptions' => ['width'=>'30'],
                'footer' => '<input type="checkbox" class="select-on-check-all" name="id_all" value="1"> '.
                    '<button href="#" class="btn btn-default btn-xs btn-delete">删除</button>',
                'footerOptions' => ['colspan' => 10, 'class'=>'deltd'],  //设置删除按钮垮列显示；
            ],
            [
                'label' => '封面',
                'value' => function($model) {
                    return '<img src="'.$model->getCover('36x36').'"> ' . $model->title;
                },
                'format' => 'raw'
            ],
            'category.name',
            'subtitle',
            'author',
            // 'pic_author',
            // 'video_author',
            'source',
            // 'video',
            // 'sort',
            'view_all',
            // 'com_all',
            // 'recommend',
            // 'is_top',
            [
                'label' => '创建',
                'value' => function($model){
                    return $model->createdBy->username . ' 于 ' . date('Y-m-d H', $model->created_at);
                },
                'headerOptions' => ['width' => '180']
            ],

            [
                'label' => '状态',
                'value' => function($model){
                    $txt = '';
                    if ($model->is_top) {
                        $txt .= '<font color="red">置顶</font>&nbsp;';
                    }

                    if ($model->recommend) {
                        $txt .= '<font color="green">推荐</font>&nbsp;';
                    }

                    return $txt;
                },
                'format' => 'raw'
            ],
            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',

                'template' => '
{update} {delete}
<div class="btn-group">
  <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    更多 <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">{top}</a></li>
    <li><a href="#">{recommend}</a></li>
    <li><a href="#">{update-lg}</a></li>
    <li role="separator" class="divider"></li>
  </ul>
</div>',
                'buttons' => [
                    'top' => function($url, $model, $key){
                        if ($model->is_top) {
                            return Html::a('<font color="red"> 取消置顶</font>', $url, ['title' => '置顶', 'class'=>'top'] );
                        } else {
                            return Html::a('<font color="red"> 置顶</font>', $url, ['title' => '置顶', 'class'=>'top'] );
                        }
                    },
                    'recommend' => function($url, $model, $key) {
                        if ($model->recommend) {
                            return Html::a(' 取消推荐', $url, ['title' => '推荐', 'class'=>'recommend'] );
                        } else {
                            return Html::a(' 推荐', $url, ['title' => '推荐', 'class'=>'recommend'] );
                        }
                    },
                    'update-lg' => function($url, $model, $key) use($i18n_flag) {
                        if($i18n_flag) {
                            return Html::a('编辑多语言', $url, ['title' => '编辑多语言'] );
                        }
                    }
                ],
               'headerOptions' => ['width' => '190',"data-type"=>"html"]
            ]
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<!-- Modal -->
<?php if($i18n):?>
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
                <?php $type = $type ? News::types($type) : 'text'; ?>
                <a href="<?=Url::toRoute(['update-lg', 'id'=>Yii::$app->request->get('id')])?>" class="btn btn-info">编辑多语言</a>
                <a href="<?=Url::toRoute(['create', 'type'=>$type])?>" class="btn btn-info">继续添加</a>
                <a href="<?=Url::toRoute(['index', 'type'=>$type])?>" class="btn btn-info">不做任何操作</a>
            </div>
        </div>
    </div>
</div>
    <?php $this->beginBlock('i18n') ?>
    $(function(){
        $('#myModal').modal();
    })
<?php
    $this->endBlock();
    $this->registerJs($this->blocks['i18n'], \yii\web\View::POS_END);
    endif;
?>


<?php $this->beginBlock('cate') ?>  
$(function(){
$('td.deltd').siblings('td').remove();
    $(".top, .recommend").click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.get(url, function(xhr){
            if (xhr.status) {
                location.reload();
            }
        },'json');
    });

    $('.btn-delete').click(function(){
        if (!confirm("您确定要删除这些文章吗?,删除后不可恢复")){return false;}
        var ids = $('#grid').yiiGridView('getSelectedRows');
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
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  