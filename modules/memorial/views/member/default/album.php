<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\LinkPager;


$this->title = '回忆相册';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/site/blog.css');
?>

<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <?php
        Modal::begin([
            'header' => '新增相册',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
        ]) ;
        echo '<div id="modalContent"></div>';
        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '编辑相册',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
        ]) ;
        echo '<div id="editContent"></div>';
        Modal::end();
        ?>
        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'album', 'model'=>$model])?>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>
                <div class="page-header">
                    <h1>
                            <a href="<?=Url::to(['create-album', 'id'=>$model->id])?>" class='btn btn-danger btn-sm modalAddButton'
                               data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>创建相册</a>
                    </h1>

                </div>

                <div class="row masonry">
                    <?php $albums = $dataProvider->getModels()?>
                    <?php foreach ($albums as $k => $album):?>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="item panel panel-default wrapper-sm">
                            <div class="pos-rlt">
                                <div class="bottom">
                                    <span class="pull-right badge bg-white"><small><?=$album->num?></small></span>
                                </div>
                                <a style="height: 200px;display: inline-block" href="<?=Url::toRoute(['photos', 'id'=>$album->id])?>">
                                    <img class="album-img" alt="" src="<?=$album->getCover('690x430')?>">
                                </a>
                            </div>
                            <div class="padder-h text-center">
                                <h4 class="h4 m-b-sm"><?=$album->title?> </h4>

                                <i class="fa fa-plus icon-muted"></i>
                                <?= Html::a('上传照片', ['photos', 'id'=>$album->id]);?>
                                <i class="fa fa-pencil icon-muted"></i>
                                <?= Html::a('修改', ['/memorial/member/default/update-album', 'id'=>$album->id],
                                    ['class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );?>
                                <i class="fa fa-trash-o icon-muted"></i>

                                <?= Html::a('删除',['del-album', 'id'=>$album->id], [
                                    'data-confirm' => '删除会连同照片一起删除，您确定要删除吗？',
                                    'data-method' => 'post'
                                ])?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>



                <footer class="panel-footer">
                    <div class="row">
                        <?php
                        echo LinkPager::widget([
                            'pagination' => $dataProvider->getPagination(),
                            'nextPageLabel' => '>',
                            'prevPageLabel' => '<',
                            'lastPageLabel' => '尾页',
                            'firstPageLabel' => '首页',
                            'options' => [
                                'class' => 'pull-right pagination'
                            ]
                        ]);
                        ?>

                    </div>
                </footer>



                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
