<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

use yii\bootstrap\Modal;
use app\modules\cms\models\Category;
use app\assets\FootableAsset;

$this->title = '图文模块内容管理';
$this->params['breadcrumbs'][] = $this->title;
FootableAsset::register($this);

?>
<style>
    .nc{
        margin-right:10px;
    }
    .parallelogram {
        -webkit-transform:skew(-15deg);
        -moz-transform:skew(-15deg);
        -o-transform:skew(-15deg);
        -ms-transform:skew(-15deg);
        transform:skew(-15deg);
        -webkit-border-radius:5px;
        -moz-border-radius:5px;
        border-radius:5px;
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
                <?php
                $mid = Yii::$app->request->get('mid');
                foreach ($modules as $v): ?>
                    <a href="<?=Url::toRoute(['/cms/admin/post/index', 'mid'=>$v['id']])?>"
                       class="btn <?php if($mid == $v['id']){echo 'btn-primary';} else{echo 'btn-default';}?> btn-lg parallelogram"><?=$v['title']?></a>
                <?php endforeach;?>
            </h1>
            <hr>
            <h1>
                <?=$module->title?>内容管理
                <small>
                    <?php
                    $mod = Yii::$app->request->get('id');
                    ?>
                    <div class="pull-right nc">
                        <a class="btn btn-danger btn-sm" href="<?=Url::toRoute(['/mod/admin/default/index'])?>" target="_blank">
                            <i class="fa fa-th-large fa-2x"></i>  模块管理</a>
                    </div>

                    <div class="pull-right nc">
                        <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/cms/admin/category/index','mid'=>$module->id])?>" target="_blank">
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
            <div class="col-xs-2">
                <?php $cid = Yii::$app->request->get('category_id');?>
                <ul class="nav nav-list">
                    <?=  Html::a('<i class="fa fa-plus"></i> 添加新分类',
                        ['/cms/admin/category/create', 'mid'=>$module->id],
                        ['class' => 'btn btn-primary btn-sm modalAddButton',
                            'title'=>"添加分类",
                            'data-loading-text'=>"页面加载中, 请稍后...",
                            'onclick'=>"return false",
                            'style'=>'width:100%',

                        ]) ?>

                    <li class="<?php if (!$cid) { echo 'active'; } ?>" >
                        <a href="<?=Url::toRoute(['index', 'mid'=>$module->id])?>" class="dropdown-toggle">
                            <i class="menu-icon fa fa-circle"></i>
                            <span class="menu-text">所有分类</span>
                        </a>
                    </li>
                    <?php foreach ($cates as $key => $value): ?>
                        <li class="<?php if(isset($value['child'])){echo 'p-menu';}?> <?php if ($value['id'] == $cid) { echo 'active'; } ?>">
                            <a href="<?=$value['url']?>" class="dropdown-toggle">
                                <i class="menu-icon fa fa-bars"></i>
                                <span class="menu-text"><?=$value['name']?></span>
                                <b class="arrow"></b>
                            </a>
                            <b class="arrow"></b>
                            <?php if (!isset($value['child'])) { continue; } ?>
                            <ul class="submenu" style="display:block;">
                                <?php foreach ($value['child'] as $k => $val): ?>
                                    <?php if (!isset($val['child'])): ?>
                                        <li class="<?php if ($val['id'] == $cid) { echo 'active'; } ?>" rel="">
                                            <a href="<?=$val['url']?>">
                                                <i class="menu-icon"></i>
                                                <?=$val['name']?>
                                                <b class="arrow"></b>
                                            </a>
                                            <b class="arrow"></b>
                                        </li>
                                    <?php else: ?>
                                        <li class="p-menu <?php if ($val['id'] == $cid) { echo 'active'; } ?>">
                                            <a href="<?=$val['url']?>" class="dropdown-toggle">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                <?=$val['name']?>
                                                <b class="arrow "></b>
                                            </a>
                                            <b class="arrow"></b>
                                            <ul class="submenu" style="display:block;">
                                                <?php foreach ($val['child'] as $k => $last):?>
                                                    <?php if (!isset($last['child'])): ?>
                                                        <li class="<?php if ($last['id'] == $cid) { echo 'active'; } ?>" rel="">
                                                            <a href="<?=$last['url']?>">
                                                                <i class="menu-icon"></i>
                                                                <?=$last['name']?>
                                                                <b class="arrow"></b>
                                                            </a>
                                                            <b class="arrow"></b>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="p-menu <?php if ($last['id'] == $cid) { echo 'active'; } ?>">
                                                            <a href="<?=$last['url']?>" class="dropdown-toggle">
                                                                <i class="menu-icon fa fa-caret-right"></i>
                                                                <?=$last['name']?>
                                                                <b class="arrow "></b>
                                                            </a>
                                                            <b class="arrow"></b>
                                                            <ul class="submenu" style="display:block;">
                                                                <?php foreach ($last['child'] as $k => $l1):?>
                                                                    <li class="<?php if ($l1['id'] == $cid) {echo 'active';}?>">
                                                                        <a href="<?=$l1['url'];?>">
                                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                                            <?=$l1['name']?>
                                                                            <b class="arrow "></b>
                                                                        </a>
                                                                        <b class="arrow"></b>
                                                                    </li>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        </li>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </ul>
                        </li>
                    <?php endforeach;?>
                </ul><!-- /.nav-list -->
            </div>

            <div class="col-xs-10 news-index">
                <?=\app\core\widgets\Alert::widget()?>

                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>

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
                        'mid' =>$module->id,
                        'i18n_flag' => $i18n_flag
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