<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

use yii\bootstrap\Modal;
use app\modules\cms\models\Category;
use app\assets\FootableAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\cms\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $module->name . '内容管理';
$this->params['breadcrumbs'][] = ['label' => '模块管理', 'url' => ['/mod/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;
FootableAsset::register($this);

?>
<style>
    .nc{
        margin-right:10px;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->

    <?php
    Modal::begin([
        'header' => '新增',
        'id' => 'modalAdd',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
        // 'size' => 'modal'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
    ?>

    <?php
    Modal::begin([
        'header' => '编辑',
        'id' => 'modalEdit',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
        // 'size' => 'modal'
    ]) ;

    echo '<div id="editContent"></div>';

    Modal::end();
    ?>

    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=$module->title?>内容管理
                <small>
                    <?php
                    $mod = Yii::$app->request->get('id');
                    ?>
                    <div class="pull-right nc">
                        <a class="btn btn-danger btn-sm" href="<?=Url::toRoute(['/mod/admin/default/index'])?>">
                            <i class="fa fa-th-large fa-2x"></i>  模块管理</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/cms/admin/category/index','mid'=>$module->id])?>">
                            <i class="fa fa-list-ol fa-2x"></i>  分类管理</a>
                    </div>


                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false"
                           href="<?=Url::toRoute(['/cms/admin/post/create', 'type'=>'image', 'mid'=>$module->id])?>">
                            <i class="fa fa-file-text fa-2x"></i>  添加图集</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm"
                           href="<?=Url::toRoute(['/cms/admin/post/create', 'type'=>'text', 'mid'=>$module->id])?>">
                            <i class="fa fa-file-image-o fa-2x"></i>  添加文章</a>
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
                                <li class="<?php if(!$type):?>active<?php endif;?>">
                                    <a href="<?=Url::toRoute(['/cms/admin/post/index', 'mid'=>$module->id])?>" aria-expanded="true">全部</a>
                                </li>
                                <li class="<?php if($type == 'text'):?>active<?php endif;?>">
                                    <a href="<?=Url::current(['type'=>'text'])?>" aria-expanded="true">文本内容</a>
                                </li>
                                <li class="<?php if($type == 'image'):?>active<?php endif;?>">
                                    <a href="<?=Url::current(['type'=>'image'])?>" aria-expanded="true">图片内容</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?=$this->render('_text',[
                        'dataProvider' => $dataProvider,
                        'type' => $type,
                        'mid' =>$module->id
                ]) ?>

                </div>
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
                    <?php $type = $type ? \app\modules\cms\models\Post::types($model->type) : 'text'; ?>
                    <?php if (isset($model)): ?>
                    <a href="<?=Url::toRoute(['update-lg','mid'=>$module->id, 'id'=>$model->id])?>" class="btn btn-info">编辑多语言</a>
                    <?php endif;?>
                    <a href="<?=Url::toRoute(['create', 'mid'=>$module->id, 'type'=>$type])?>" class="btn btn-info">继续添加</a>
                    <a href="<?=Url::toRoute(['index', 'mid'=>$module->id, 'type'=>$type])?>" class="btn btn-info">不做任何操作</a>
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