<?php
use yii\helpers\Url;
use app\core\helpers\Html;
use app\core\widgets\GridView;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
\app\core\widgets\Ueditor\UAsset::register($this);
$this->title = '我的博客';
$this->params['breadcrumbs'][] = ['label' => '个人中心', 'url' => ['/user/admin/profile/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/site/blog.css');

$this->params['profile_nav'] = 'blog';
?>
<div class="page-content">
    <style>
        .post-sum{
            color:#555;
        }
    </style>
    <div class="col-sm-12">

        <div id="user-profile-2" class="user-profile">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-18">
                    <?=$this->render('@app/modules/user/views/admin/profile/nav');?>
                    <a href="<?=Url::toRoute(['create'])?>" class="modalAddButton pull-right btn btn-info" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                        <i class="fa fa-plus"></i>写博客
                    </a>
                </ul>

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

                <?php
                Modal::begin([
                    'header' => '新增',
                    'id' => 'modalAdd',
                    'clientOptions' => ['backdrop' => 'static', 'show' => false],
                     'size' => Modal::SIZE_LARGE
                ]) ;

                echo '<div id="modalContent"></div>';

                Modal::end();
                ?>

                <?php
                Modal::begin([
                    'header' => '编辑',
                    'id' => 'modalEdit',
                    'clientOptions' => ['backdrop' => 'static', 'show' => false],
                    'size' => Modal::SIZE_LARGE
                ]) ;

                echo '<div id="editContent"></div>';

                Modal::end();
                ?>

                <div class="tab-content padding-12">
                    <div class="tab-pane active">
                        <div class="col-xs-12">
                            <div class="search-box search-outline">
                                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                            </div>
                        </div>

                        <div class="col-xs-12 blog-post">
                            <?php $posts = $dataProvider->getModels()?>
                            <?php foreach ($posts as $post):?>
                                <div class="post-item">
                                    <div class="caption wrapper-lg">
                                        <h3 class="post-title">
                                            <a href="#">
                                                <?=$post->title?>
                                            </a>
                                        </h3>
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
                                                ['class'=>'modalViewButton',
                                                    "data-loading-text"=>"页面加载中, 请稍后...",
                                                    "onclick"=>"return false"] );?>
                                            <i class="fa fa-pencil icon-muted"></i>
                                            <?= Html::a('修改', ['update', 'id'=>$post->id],[
                                                    'class'=>'modalEditButton',
                                                    "data-loading-text"=>"页面加载中, 请稍后...",
                                                    "onclick"=>"return false"
                                            ]);?>
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
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>