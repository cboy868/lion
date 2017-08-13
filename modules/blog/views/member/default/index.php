<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\base\Model;
use yii\bootstrap\Modal;
use yii\widgets\LinkPager;
use app\modules\blog\models\Blog;
$this->title = '博客管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/site/blog.css');
\app\assets\ExtAsset::register($this);
\app\assets\PluploadAssets::register($this);
\app\core\widgets\Ueditor\UAsset::register($this);

Yii::$app->params['cur_nav'] = 'blog_index';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">


            <h1>
                <a href="<?=Url::to(['create'])?>" class='btn btn-danger btn-sm modalAddButton'
                   data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>写博客</a>
            </h1>
        </div><!-- /.page-header -->
        <?php
        Modal::begin([
            'header' => '写博客',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
            'size' => 'modal-lg'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '编辑博客',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
            'size' => 'modal-lg'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '查看博客',
            'id' => 'modalView',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
            'size' => 'modal-lg'
        ]) ;

        echo '<div id="viewContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <?= \app\core\widgets\Alert::widget();?>
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>


            <div class="col-xs-12 blog-index">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="border:none;">
                        <div class="no-border">
                            <?php $res=Yii::$app->request->get('res');?>
                            <ul class="nav nav-tabs">
                                <li class="<?php if(!$res)echo'active'?>">
                                    <a href="<?=Url::toRoute(['index'])?>" aria-expanded="true">全部</a>
                                </li>
                                <li class="<?php if($res == Blog::RES_BLOG)echo'active'?>">
                                    <a href="<?=Url::toRoute(['index','res'=>Blog::RES_BLOG])?>" aria-expanded="true">博客</a>
                                </li>
                                <li class="<?php if($res == Blog::RES_MISS)echo'active'?>">
                                    <a href="<?=Url::toRoute(['index','res'=>Blog::RES_MISS])?>" aria-expanded="true">追忆文章</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="blog-post">
                    <?php $posts = $dataProvider->getModels()?>
                    <?php foreach ($posts as $post):?>
                        <div class="post-item">
                            <div style="float:right;line-height:30px; margin-right:10px">
                                <b style="color:green"><?=$post->statusText?></b>
                                <b style="color:green"><?=$post->privacyText?></b>
                            </div>
                            <div class="caption wrapper-lg">
                                <h2 class="post-title">
                                    <a href="#">
                                        <?=$post->title?>
                                    </a>
                                </h2>
                                <div class="post-sum">
                                    <?=Html::cutstr_html($post->body,100)?>
                                </div>
                                <div class="line line-lg"></div>
                                <div class="text-muted">
                                    <i class="fa fa-user icon-muted"></i>
                                    by <a class="m-r-sm" href="javascript:void(0"><?=$post->user->username?></a>
                                    <i class="fa fa-clock-o icon-muted"></i> <span class="m-r-sm"><?=date('Y-m-d H:i', $post->created_at)?></span>

                                    <i class="fa fa-eye icon-muted"></i>
                                    <?= Html::a('查看', ['view', 'id'=>$post->id],
                                        ['class'=>'modalViewButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );?>
                                    <i class="fa fa-pencil icon-muted"></i>
                                    <?= Html::a('修改', ['update', 'id'=>$post->id],
                                        ['class'=>'modalEditButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"] );?>
                                    <i class="fa fa-trash-o icon-muted"></i>

                                    <?= Html::a('删除',['delete', 'id'=>$post->id], [
                                        'data-confirm' => '您确定要删除此文章吗？',
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
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>