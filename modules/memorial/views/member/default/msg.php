<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\ActiveForm;
use app\core\models\Attachment;
use yii\bootstrap\Modal;

\app\assets\ExtAsset::register($this);
\app\assets\PluploadAssets::register($this);


$this->title = '追忆文章';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <?php
        Modal::begin([
            'header' => '新增逝者',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
             'size' => 'modal-lg'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>
        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'msg'])?>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>
                <div class="page-header">
                    <h1>
                            <a href="<?=Url::to(['create-dead', 'id'=>$model->id])?>" class='btn btn-danger btn-sm modalAddButton'
                               data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加追忆文章</a>
                    </h1>

                </div>

                <style>

                    body{
                        color:#788188;
                    }
                    a {
                        color: #545a5f;
                        text-decoration: none;
                    }
                    a {
                        background: transparent;
                    }
                    .post-item {
                        border-radius: 3px;
                        background-color: #fff;
                        -webkit-box-shadow: 0px 1px 2px rgba(0,0,0,0.15);
                        box-shadow: 0px 1px 2px rgba(0,0,0,0.15);
                        margin-bottom: 15px;
                    }
                    .wrapper-lg {
                        padding: 30px;
                    }
                    .post-item .post-title {
                        margin-top: 0;
                    }
                    .line-lg {
                        margin-top: 15px;
                        margin-bottom: 15px;
                    }
                    .line {
                        height: 2px;
                        margin: 10px 0;
                        font-size: 0;
                        overflow: hidden;
                    }
                    .text-muted {
                        color: #939aa0;
                    }
                    .block {
                        display: block;
                    }
                    .comment-list {
                        position: relative;
                    }
                    .comment-list .comment-item {
                        margin-top: 0;
                        position: relative;
                    }

                    .comment-list .comment-item > .thumb-sm {
                        width: 36px;
                    }
                    .thumb-sm {
                        display: inline-block;
                    }
                    .avatar {
                        position: relative;
                        border-radius: 500px;
                        white-space: nowrap;
                    }
                    .comment-list .comment-item .arrow.left {
                        top: 20px;
                        left: 39px;
                    }
                    .arrow.left {
                        top: 50%;
                        left: -8px;
                        margin-top: -8px;
                        border-left-width: 0;
                        border-right-color: #eee;
                        border-right-color: rgba(0,0,0,0.1);
                    }
                    .arrow, .arrow:after {
                        position: absolute;
                        display: block;
                        width: 0;
                        height: 0;
                        border-color: transparent;
                        border-style: solid;
                    }
                    .arrow {
                        border-width: 8px;
                        z-index: 10;
                    }
                    .arrow.left:after {
                        content: " ";
                        left: 1px;
                        border-left-width: 0;
                        border-right-color: #fff;
                        bottom: -7px;
                    }
                    .arrow:after {
                        border-width: 7px;
                        content: "";
                    }
                    .comment-list .comment-item .comment-body {
                        margin-left: 46px;
                    }
                    .panel.panel-default {
                        border-color: #eaeef1;
                    }
                    .panel {
                        border-radius: 2px;
                    }
                    .comment-list .comment-item .panel-heading, .comment-list .comment-item .panel-footer {
                        position: relative;
                        font-size: 12px;
                        background-color: #fff;
                    }
                    .panel.panel-default > .panel-heading, .panel.panel-default > .panel-footer {
                        border-color: #eaeef1;
                    }
                    .bg-white a {
                        color: #545a5f;
                    }
                    .bg-white .text-muted {
                        color: #939aa0 !important;
                    }
                    .m-l-sm {
                        margin-left: 10px;
                    }
                    .comment-list .comment-item .panel-body {
                        padding: 10px 15px;
                    }
                    .m-t-sm {
                        margin-top: 10px;
                    }
                </style>

                <div class="blog-post">
                    <div class="post-item">
                        <div style="float:right;line-height:30px; margin-right:10px">
                            <b style="color:green">审核通过</b>
                        </div>
                        <div class="caption wrapper-lg">
                            <h2 class="post-title">
                                <a target="_blank" href="/Memorial/ReView/591539105i638553.html">精彩的一瞬间</a>
                            </h2>
                            <div class="post-sum">
                                <p>
                                    在我的心里珍藏着一张珍贵的“照片”，上面记录着一个精彩的瞬间。她时时刻刻激励着我呢！现在我向你展示一下这张特殊的“照片”吧！希望也对你有所启发或感悟。记得那是在我们瞻岐中心小学举行的一次运动会上，那天举行的是一百米短跑决赛。我和其他没有参加比赛的同学一样站在操场边，看运动员比赛，为他们加油。当六个同学站在起跑线后，老师举起发令将要开的那一瞬间，有个运动员突然举手示意暂停，然后他指着旁边一个运动员的...
                                </p>
                            </div>
                            <div class="line line-lg"></div>
                            <div class="text-muted">
                                <i class="fa fa-user icon-muted"></i> by <a class="m-r-sm" href="javascript:void(0">cboy868@163.com</a>
                                <i class="fa fa-clock-o icon-muted"></i> <span class="m-r-sm">2017-08-09</span>

                                <i class="fa fa-eye icon-muted"></i>
                                <a onclick="LoadAjaxViewModal('查看追忆文章', '/MemberCenter/Archives/ViewDetailed?id=69c8a3e5-b2f7-4f32-bf89-ffaf0aa59b13')" href="javascript:void(0)" class="m-r-sm">查看</a>
                                <i class="fa fa-pencil icon-muted"></i>
                                <a onclick="LoadAjaxModal('添加追忆文章', '/MemberCenter/Archives/Edit?id=69c8a3e5-b2f7-4f32-bf89-ffaf0aa59b13')" href="javascript:void(0)" class="m-r-sm">修改</a>


                                <i class="fa fa-trash-o icon-muted"></i>
                                <a href="javascript:void(0)" data-toggle="confirmation" data-id="formMemorialArticle69c8a3e5-b2f7-4f32-bf89-ffaf0aa59b13" class="m-r-sm" data-original-title="" title="">
                                    删除
                                </a>
                                <form id="formMemorialArticle69c8a3e5-b2f7-4f32-bf89-ffaf0aa59b13" callback="loadPage()" action="/MemberCenter/Archives/Del" onsubmit="return false">
                                    <input type="hidden" name="id" value="69c8a3e5-b2f7-4f32-bf89-ffaf0aa59b13">
                                </form>
                            </div>
                            <div class="line line-lg"></div>
                            <!-- .comment-list -->
                            <section class="comment-list block">
                                <!-- comment form -->
                                <article class="comment-item media" id="reply-form638553">
                                    <a class="pull-left thumb-sm avatar">
                                        <img src="/Resource/Images/Default/Member.jpg" alt="...">
                                    </a>
                                    <section class="media-body">
                                        <form action="Archives/CommentAdd" onsubmit="return false" data-validate="parsley" class="m-b-none">
                                            <input id="reply-id" class="reply-id" value="638553" type="hidden">
                                            <div class="input-group">
                                                <span class="input-group-addon">@</span>
                                                <input id="postMsg" name="Content" data-required="true" type="text" class="form-control parsley-validated" placeholder="说说。。。">
                                                <span class="input-group-btn">
                                                                    <button class="btn btn-primary" data-toggle="reply-btn" type="button">回复</button>
                                                                </span>
                                            </div>
                                            <input type="hidden" name="LT_ForeignKey" value="69c8a3e5-b2f7-4f32-bf89-ffaf0aa59b13">
                                            <input type="hidden" name="LX_Column" value="2">
                                            <input style="display:none" type="submit" onclick="$(this).parents('form').find('[data-toggle=\'reply-btn\']').click()">
                                        </form>
                                    </section>
                                </article>
                            </section>
                            <!-- / .comment-list -->
                        </div>

                    </div>
                    <div class="post-item">
                        <div style="float:right;line-height:30px; margin-right:10px">
                            <b style="color:green">审核通过</b>
                        </div>
                        <div class="caption wrapper-lg">
                            <h2 class="post-title">
                                <a target="_blank" href="/Memorial/ReView/591539105i638552.html">星老有老华的人</a>
                            </h2>
                            <div class="post-sum">
                                <p>
                                    星老有老华的人,从1980年相识以来，果有一颗很专一的心，但是也管不住果到处爱乱走的腿，所以，山东的樱桃基地行，在到达基地之前已经去了好多好多其他地方，呲了好多好多的东西。现在想起来果都佩服记几，来来来，瞅一瞅呗
                                </p>
                            </div>
                            <div class="line line-lg"></div>
                            <div class="text-muted">
                                <i class="fa fa-user icon-muted"></i> by <a class="m-r-sm" href="javascript:void(0">cboy868@163.com</a>
                                <i class="fa fa-clock-o icon-muted"></i> <span class="m-r-sm">2017-08-09</span>

                                <i class="fa fa-eye icon-muted"></i>
                                <a onclick="LoadAjaxViewModal('查看追忆文章', '/MemberCenter/Archives/ViewDetailed?id=c0f94758-ef0a-4086-8dc5-56d8ccc74ebe')" href="javascript:void(0)" class="m-r-sm">查看</a>
                                <i class="fa fa-pencil icon-muted"></i>
                                <a onclick="LoadAjaxModal('添加追忆文章', '/MemberCenter/Archives/Edit?id=c0f94758-ef0a-4086-8dc5-56d8ccc74ebe')" href="javascript:void(0)" class="m-r-sm">修改</a>


                                <i class="fa fa-trash-o icon-muted"></i>
                                <a href="javascript:void(0)" data-toggle="confirmation" data-id="formMemorialArticlec0f94758-ef0a-4086-8dc5-56d8ccc74ebe" class="m-r-sm" data-original-title="" title="">
                                    删除
                                </a>
                                <form id="formMemorialArticlec0f94758-ef0a-4086-8dc5-56d8ccc74ebe" callback="loadPage()" action="/MemberCenter/Archives/Del" onsubmit="return false">
                                    <input type="hidden" name="id" value="c0f94758-ef0a-4086-8dc5-56d8ccc74ebe">
                                </form>
                            </div>
                            <div class="line line-lg"></div>
                            <!-- .comment-list -->
                            <section class="comment-list block">
                                <form id="formComment185054" callback="callDelPage('formComment185054')" action="Archives/CommentDel" onsubmit="return false">
                                    <article class="comment-item" id="comment-id-1">
                                        <a class="pull-left thumb-sm avatar">
                                            <img src="/Resource/Images/Default/Member.jpg" class="img-circle" alt="...">
                                        </a>
                                        <span class="arrow left"></span>
                                        <section class="comment-body panel panel-default">
                                            <header class="panel-heading bg-white">
                                                <a href="#">cboy868@163.com</a>
                                                <span class="text-muted m-l-sm pull-right">
                                                                        <i class="fa fa-clock-o"></i> 2017-08-09 22:59:23
                                                                    </span>
                                            </header>
                                            <div class="panel-body">
                                                <div>为啥</div>
                                                <div class="comment-action m-t-sm">

                                                    <a class="btn btn-default btn-xs" data-id="formComment185054" data-toggle="confirmation" data-original-title="" title="">
                                                        <i class="fa fa-trash-o text-muted"></i> 删除
                                                    </a>
                                                </div>
                                            </div>
                                        </section>
                                    </article>
                                    <input type="hidden" name="Id" value="185054">
                                </form>
                                <!-- comment form -->
                                <article class="comment-item media" id="reply-form638552">
                                    <a class="pull-left thumb-sm avatar">
                                        <img src="/Resource/Images/Default/Member.jpg" alt="...">
                                    </a>
                                    <section class="media-body">
                                        <form action="Archives/CommentAdd" onsubmit="return false" data-validate="parsley" class="m-b-none">
                                            <input id="reply-id" class="reply-id" value="638552" type="hidden">
                                            <div class="input-group">
                                                <span class="input-group-addon">@</span>
                                                <input id="postMsg" name="Content" data-required="true" type="text" class="form-control parsley-validated" placeholder="说说。。。">
                                                <span class="input-group-btn">
                                                                    <button class="btn btn-primary" data-toggle="reply-btn" type="button">回复</button>
                                                                </span>
                                            </div>
                                            <input type="hidden" name="LT_ForeignKey" value="c0f94758-ef0a-4086-8dc5-56d8ccc74ebe">
                                            <input type="hidden" name="LX_Column" value="2">
                                            <input style="display:none" type="submit" onclick="$(this).parents('form').find('[data-toggle=\'reply-btn\']').click()">
                                        </form>
                                    </section>
                                </article>
                            </section>
                            <!-- / .comment-list -->
                        </div>

                    </div>
                </div>

                <footer class="panel-footer">
                    <div class="row">

                        111

                    </div>
                </footer>



                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('cate') ?>
$(function(){
    $('.selize-rel').each(function(index, item){
        var $this = $(item);
        if ( !$this.data('select-init') ) {
            $this.selectize({
                create: true
            });
        }
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>




