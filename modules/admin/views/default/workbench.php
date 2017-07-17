<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
$this->title = '我的工作台';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .fa-app{
        display: block;
        margin-bottom: 5px;
    }
    .btn img{
        width:48px;
        height: 48px;
    }
    .widget-main .btn-default{
        border-radius: 10px;
        margin: 5px;
        width: 78px;
    }
</style>
<?php
Modal::begin([
    'header' => '添增',
    'id' => 'modalAdd',
     'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'show' => false]
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
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-md-6">
                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 业务操作</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">

                            <a href="<?=Url::toRoute('/client/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/realition.png" class="fa-app">
                                客户关系
                            </a>

                            <a href="<?=Url::toRoute('/sms/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/sms.png" class="fa-app">
                                发短信
                            </a>

                            <a href="<?=Url::toRoute('/shop/admin/goods/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/shop.png" class="fa-app">
                                商品管理
                            </a>
                            <a href="<?=Url::toRoute('/user/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/users.png" class="fa-app">
                                用户管理
                            </a>

                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-home"></i> 门户操作</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <a href="<?=Url::toRoute('/focus/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/focus.png" class="fa-app">
                                焦点图
                            </a>

                            <a href="<?=Url::toRoute('/cms/admin/links/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/friend.png" class="fa-app">
                                友情链接
                            </a>
                            <a href="<?=Url::toRoute('/news/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/news.png" class="fa-app">
                                新闻资讯
                            </a>
                            <a href="<?=Url::toRoute('/blog/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/blog.png" class="fa-app">
                                博客
                            </a>
                            <a href="<?=Url::toRoute('/cms/admin/subject/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/special.png" class="fa-app">
                                专题
                            </a>
                            <a href="<?=Url::toRoute('/cms/admin/favor/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/fav.png" class="fa-app">
                                收藏
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-header">
                        <h4 class="widget-title lighter"><i class="fa fa-gears"></i> 系统管理</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <a href="<?=Url::toRoute('/mod/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/modules.png" class="fa-app">
                                模块管理
                            </a>
                            <a href="<?=Url::toRoute('/sys/admin/default/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/set.png" class="fa-app">
                                基础设置
                            </a>
                            <a href="<?=Url::toRoute('/sys/admin/backup/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/backup.png" class="fa-app">
                                数据备份
                            </a>
                            <a href="<?=Url::toRoute('/sys/admin/image/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/setpic.png" class="fa-app">
                                图片设置
                            </a>
                            <a href="<?=Url::toRoute('/cms/admin/nav/index')?>" target="_blank" class="btn btn-default">
                                <img src="/static/images/icons/nav.png" class="fa-app">
                                门户导航
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <?=\app\modules\news\widgets\News::widget(['type'=>'new']) ?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>