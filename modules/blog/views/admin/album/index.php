<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '相册管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/site/blog.css');

Yii::$app->params['cur_nav'] = 'album_index';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=$this->title?>
            </h1>
        </div><!-- /.page-header -->
        <?php
        Modal::begin([
            'header' => '编辑相册',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
        ]) ;
        echo '<div id="editContent"></div>';
        Modal::end();
        ?>

        <div class="row masonry">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <div class="col-xs-12">
                <?=\app\core\widgets\Alert::widget() ?>
            </div>

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
                            <?= Html::a('修改', ['update', 'id'=>$album->id],
                                ['class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );?>
                            <i class="fa fa-trash-o icon-muted"></i>

                            <?= Html::a('删除',['delete', 'id'=>$album->id], [
                                'data-confirm' => '删除会连同照片一起删除，您确定要删除吗？',
                                'data-method' => 'post'
                            ])?>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div><!-- /.page-content-area -->
</div>