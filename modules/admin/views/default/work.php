<?php
use yii\helpers\Url;
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
    .gsearch input{margin-top: 5px;margin-bottom:5px;}
</style>

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

                            <div style="border: 1px solid #ccc;border-radius: 3px;padding:5px;">
                            <form action="" class="form-inline gsearch">

                                    <input type="text" class="form-control input-lg" placeholder="墓区" >

                                    <input type="text" class="form-control input-lg" placeholder="排" style="width:80px;">

                                    <input type="text" class="form-control input-lg" placeholder="列" style="width:80px;">

                                    <input type="text" class="form-control input-lg" placeholder="用户名">

                                    <input type="text" class="form-control input-lg" placeholder="手机号">

                                    <button class="btn btn-info btn-lg"><i class="fa fa-search"></i> 查找 </button>


                            </form>


                            <table class="table table-striped table-hover table-bordered table-condensed">

                                <tr>
                                    <td><a href="#">颐安二十一1排12号</a> 张小强 18588889999 部分安葬</td>
                                    <td width="80">
                                        <a href="#">
                                            办理业务
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="#">颐安二十一1排12号</a> 张小强 18588889999 部分安葬</td>
                                    <td width="80">
                                        <a href="#">
                                            办理业务
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="#">颐安二十一1排12号</a> 张小强 18588889999 部分安葬</td>
                                    <td width="80">
                                        <a href="#">
                                            办理业务
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="#">颐安二十一1排12号</a> 张小强 18588889999 部分安葬</td>
                                    <td width="80">
                                        <a href="#">
                                            办理业务
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><a href="#">颐安二十一1排12号</a> 张小强 18588889999 部分安葬</td>
                                    <td width="80">
                                        <a href="#">
                                            办理业务
                                        </a>
                                    </td>
                                </tr><tr>
                                    <td><a href="#">颐安二十一1排12号</a> 张小强 18588889999 部分安葬</td>
                                    <td width="80">
                                        <a href="#">
                                            办理业务
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            </div>

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

            </div>
            <div class="col-md-6">
                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'client'])?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>