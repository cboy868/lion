<?php
use yii\helpers\Url;
$this->params['current_nav'] = 'index';
?>
<div class="container memorial-container">
    <!--这里加内容-->
    <div class="white-bg">
        <div class="person-list">
            <div class="sline-box person-a">
                <ul class="nav nav-tabs sline" role="tablist">
                    <?php foreach ($deads as $k=>$v):?>
                    <li class="<?php if($k==0)echo"active";?>">
                        <a href=".d<?=$k?>" data-toggle="tab"><?=$v->dead_name?></a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="col-md-6 box">
                <div class="tab-content person-content">
                    <?php foreach ($deads as $k=>$v):?>
                    <div class="tab-pane fade d<?=$k?> <?php if($k==0)echo"active in";?>">

                        <div class="col-md-4 col-sm-4 text-center">
                            <img class="img-rounded img-responsive center-block" src="<?=$v->getAvatarImg('144x200')?>">
                            <br>
                        </div>


                        <div class="col-md-8 col-sm-8 info">
                            <ul class="list-unstyled">
                                <li><h4><?=$v->dead_name?></h4></li>
                                <li>
                                    <?=$v->birth?> ~ <?=$v->fete?>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12"><span>性别：</span><?=$v->genderText?></div>
                                    </div>
                                </li>
<!--                                <li>-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-md-12 col-sm-12">-->
<!--                                            <span>籍贯：</span>-->
<!--                                            暂无-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->

                                <?php if($v->tomb):?>
                                <li>
                                    <span>安葬位置：<?=$v->tomb->tomb_no?></span>

                                </li>
                                <?php endif;?>
                                <li><span>网址：</span><?=\yii\helpers\Url::current([],true)?></li>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-10 jdwz">
                    本馆由 <strong><?=$memorial->user->username;?></strong>于<?=date('Y-m-d', $memorial->created_at)?>建立。<br>
                    今日:<?=date('Y-m-d')?>。<br>

                    <?php foreach ($deads as $v):?>
                        距:<?=$v->dead_name?>
                        <?php foreach ($v->getDays() as $d): ?>
                            <?php if ($d['days']<0) continue; ?>
                            <strong><?=$d['title']?></strong>还剩  <strong><?=$d['days']?></strong> 天;
                        <?php endforeach;?>
                        <br>
                    <?php endforeach;?>

                    <hr>
                    <p>
                        <?=\app\core\helpers\Html::cutstr_html($memorial->intro, 100)?>
                    </p>
                </div>
            </div>
        </div>
        <div class="blank"></div>
    </div>
    <div class="white-bg">
        <div class="row">
            <div class="col-md-9 mb20">
                <div class="person-list">
                    <div class="sline-box person-b">
                        <ul class="nav nav-tabs sline" role="tablist" style="width: 0px;">
                        </ul>
                    </div>
                </div>
                <div class="box">
                    <div class="bg-title">
                        <div class="pull-left">
                            <a class="bg-tit" href="<?=Url::toRoute(['/memorial/home/hall/life', 'id'=>$memorial->id])?>">生平简介</a>
                        </div>
                        <div class="pull-right"><a href="<?=Url::toRoute(['/memorial/home/hall/life', 'id'=>$memorial->id])?>">详细内容&gt;&gt;</a></div>
                    </div>
                    <div class="clear"></div>
                    <div class="about-index">
                        <?php foreach ($deads as $v):
                            if ($v->desc):
                            ?>
                        <strong><?=$v->dead_name?></strong>
                        <div>
                            <?=$v->desc?>
                        </div>
                        <?php endif;endforeach;?>
                    </div>
                </div>

                <div class="blank"></div>
                <div class="box">
                    <div class="bg-title">
                        <div class="pull-left"><a class="bg-tit" href="#">档案资料</a></div>
                        <div class="pull-right"><a href="#">更多内容&gt;&gt;</a></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="about-index da-info">
                        <ul class="list-unstyled">
                            <?php foreach ($archives as $v): ?>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="#"><?=$v->title?></a></h5>
                                    <h6>
                                        发布人：
                                        <a href="javascript:void(0)">
                                            <?=$v->user->username?>
                                        </a>
                                    </h6>
                                    <span>时间：<?=date('Y-m-d', $v->created_at)?></span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        　　<?=\app\core\helpers\Html::cutstr_html($v->body, 200)?>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="blank"></div>
                <div class="box">
                    <div class="bg-title">
                        <div class="pull-left"><a class="bg-tit" href="#">追思文章</a></div>
                        <div class="pull-right"><a href="#">更多内容&gt;&gt;</a></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="about-index da-info">
                        <ul class="list-unstyled" id="ArticleLi">
                            <?php foreach ($miss as $v): ?>
                                <li>
                                    <div class="wz-bt-index">
                                        <h5><a href="#"><?=$v->title?></a></h5>
                                        <h6>
                                            发布人：
                                            <a href="javascript:void(0)">
                                                <?=$v->user->username?>
                                            </a>
                                        </h6>
                                        <span>时间：<?=date('Y-m-d', $v->created_at)?></span>
                                    </div>
                                    <div class="wz-br-index">
                                        <div>
                                            　　<?=\app\core\helpers\Html::cutstr_html($v->body, 200)?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
                <div class="blank"></div>
                <div class="box">
                    <div class="bg-title">
                        <div class="pull-left"><a class="bg-tit" href="#">祝福留言</a></div>
                        <div class="pull-right"><a href="#">更多内容&gt;&gt;</a></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="about-index da-info">
                        <ul id="Commentli" class="list-unstyled">
                            <?php foreach ($msgs as $v):?>
                            <li>
                                <div class="ttxx-inde-pic">
                                    <a href="javascript:void(0)">
                                        <img class="img-responsive" src="<?=$v->fromUser->getAvatar('36x36', '/static/images/default.png')?>">
                                    </a>
                                    <p>
                                        <a href="javascript:void(0)">
                                            <?=$v->fromUser->username?>
                                        </a>
                                    </p>
                                </div>
                                <div class="ttxx-index-a">
                                    <div><p><?=$v->content?></p></div>
                                    <br>
                                    <div><span>祝福时间：<?=date('Y-m-d H:i', $v->created_at)?> </span></div>
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>

            </div>
            <!---------------右侧内容开始------------------>
            <div class="col-md-3 no-padding-left mb20">

                <div class="box">
                    <div class="side-title">
                        微信扫一扫“码”上纪念 孙中山
                    </div>
                    <div style="text-align:center" class="side-tips">
        <span>
            <img src="static/images/Generate">
        </span>
                    </div>
                </div>

                <br>
                <div class="box">
                    <div class="side-title"><a class="tit" href="javascript:void(0)">祭奠记录</a><a class="more" href="http://www.5201000.com/Memorial/SLList/1/1/69.html">更多祭奠记录&gt;&gt;</a></div>
                    <div class="scoll-up">
                        <ul class="list-unstyled">
                            <li class="">
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=581180" href="javascript:void(0)">狄国老</a>
                                    敬献了普通香
                                </p>
                                <span>敬献时间：2017-01-07 01:52</span>
                            </li><li class="">
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886146" href="javascript:void(0)">151*****097</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2016-12-21 02:11</span>
                            </li><li class="">
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=885951" href="javascript:void(0)">157*****658</a>
                                    敬献了烧钱
                                </p>
                                <span>敬献时间：2016-12-07 09:36</span>
                            </li><li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889268" href="javascript:void(0)">150*****463</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-04-21 05:25</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889268" href="javascript:void(0)">150*****463</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-04-21 05:22</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=576390" href="javascript:void(0)">波斯猫</a>
                                    敬献了烧钱
                                </p>
                                <span>敬献时间：2017-04-01 06:47</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=576390" href="javascript:void(0)">波斯猫</a>
                                    敬献了西瓜
                                </p>
                                <span>敬献时间：2017-04-01 06:46</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=887182" href="javascript:void(0)">455177522@qq.com</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-02-28 08:51</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=887182" href="javascript:void(0)">455177522@qq.com</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-02-28 08:51</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886926" href="javascript:void(0)">158*****605</a>
                                    敬献了野果
                                </p>
                                <span>敬献时间：2017-02-08 04:14</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886926" href="javascript:void(0)">158*****605</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-02-08 04:13</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886925" href="javascript:void(0)">186*****857</a>
                                    敬献了野果
                                </p>
                                <span>敬献时间：2017-02-08 02:59</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886925" href="javascript:void(0)">186*****857</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-02-08 02:54</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=885951" href="javascript:void(0)">157*****658</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-01-18 06:10</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886500" href="javascript:void(0)">182*****955</a>
                                    敬献了圣经
                                </p>
                                <span>敬献时间：2017-01-12 02:10</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886500" href="javascript:void(0)">182*****955</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-01-12 02:08</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=885951" href="javascript:void(0)">157*****658</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-01-11 11:55</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=885951" href="javascript:void(0)">157*****658</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-01-11 11:40</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=581180" href="javascript:void(0)">狄国老</a>
                                    敬献了花圈
                                </p>
                                <span>敬献时间：2017-01-07 01:53</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=581180" href="javascript:void(0)">狄国老</a>
                                    敬献了花圈
                                </p>
                                <span>敬献时间：2017-01-07 01:53</span>
                            </li>



                        </ul>
                    </div>
                    <div class="side-tips">
                    <span>
                        温馨提示：请为您已经逝去的亲朋好友点一柱香
                        献一束花，让他们在天堂永不孤单。
                    </span>
                    </div>
                </div>
                <br>


                <link href="static/css/owl.carousel.css" rel="stylesheet" type="text/css">
                <link href="static/css/owl.theme.css" rel="stylesheet">
                <link href="static/css/owl.transitions.css" rel="stylesheet" type="text/css">
                <div class="box">
                    <div class="side-title">
                        <a class="tit" href="http://www.5201000.com/Memorial/AlbumList/69.html">音容笑貌</a>
                        <a class="more" href="http://www.5201000.com/Memorial/AlbumList/69.html">更多&gt;&gt;</a>
                    </div>
                    <div class="photo">
                        <div id="owl-img" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
                            <div class="owl-wrapper-outer autoHeight" style="height: 127px;">
                                <div class="owl-wrapper" style="width: 5302px; left: 0px; display: block; transition: all 0ms ease; transform: translate3d(-1446px, 0px, 0px); transform-origin: 1566.5px center 0px; perspective-origin: 1566.5px center;">
                                    <div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/100109092055208.jpg" height="166" width="118">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115193707015.jpg" height="200" width="249">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115193617125.jpg" height="186" width="250">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115193141687.jpg" height="130" width="250">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115193000734.jpg" height="200" width="175">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192901359.jpg" height="145" width="250">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192638625.jpg" height="127" width="133">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192433265.jpg" height="187" width="250">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192316828.jpg" height="200" width="166">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192225234.jpg" height="200" width="152">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091112223318312.jpg" height="200" width="134">
                                        </div></div></div></div>

                            <div class="owl-controls clickable"><div class="owl-buttons"><div class="owl-prev">上一张</div><div class="owl-next">下一张</div></div></div></div>


                    </div>
                </div>
                <script src="static/js/owl.carousel.js"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        setTimeout(function () {
                            $("#owl-img").owlCarousel({
                                autoPlay: 3000,
                                stopOnHover: true,
                                navigation: true,
                                paginationSpeed: 1000,
                                goToFirstSpeed: 2000,
                                singleItem: true,
                                autoHeight: true,
                                transitionStyle: "fadeUp",
                                navigationText: ["上一张", "下一张"],
                                lazyLoad: true,
                                pagination: false
                            });
                        }, 100)
                    });
                </script>


                <div class="blank"></div>
                <div class="box">
                    <form action="http://www.5201000.com/Search" method="get">
                        <div class="side-title">
                            <a class="tit" href="javascript:void(0)">搜索纪念馆</a>
                            <a class="more" href="http://www.5201000.com/Search">高级搜索</a>
                        </div>
                        <input name="keyword" class="form-control" type="text">
                        <button class="tt-btn tt-btn-default"><i class="smIcon search"></i> 搜索</button>
                    </form>
                </div>
                <div class="blank"></div>
                <div class="box">
                    <div class="side-title">
                        <a class="tit" href="javascript:void(0)">亲友纪念馆</a>

                    </div>
                    <div class="side-login"><p>您还未<a href="javascript:void(0)">登录</a> ，登录后可添加亲友纪念馆！</p></div>
                </div>
                <div class="blank"></div>
                <div class="col-md-12">
                    <div class="row">
                        <a href="http://www.5201000.com/MemberCenter/Memorial/Add"><img class="img-responsive" src="static/images/right-avd.gif" alt="免费创建纪念馆"></a>
                    </div>
                </div>
                <div class="blank"></div>
                <div class="box">
                    <div class="side-title"><a class="tit" href="javascript:void(0)">到过这里的访客</a><a class="more" href="javascript:void(0)">更多&gt;&gt;</a></div>
                    <div class="xp-huiyuan">
                        <ul>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889768" href="javascript:void(0)">
                                    <img width="73" height="83" alt="344803800@qq.com" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889768" href="javascript:void(0)">
                                        344803800@qq.com
                                    </a>
                                </p>
                                <span>07月15日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                    <img width="73" height="83" alt="153*****363" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                        153*****363
                                    </a>
                                </p>
                                <span>07月11日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890159" href="javascript:void(0)">
                                    <img width="73" height="83" alt="180*****805" src="static/images/20170704180312.JPG">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890159" href="javascript:void(0)">
                                        180*****805
                                    </a>
                                </p>
                                <span>07月04日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889981" href="javascript:void(0)">
                                    <img width="73" height="83" alt="565853277@qq.com" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889981" href="javascript:void(0)">
                                        565853277@qq.com
                                    </a>
                                </p>
                                <span>06月25日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                    <img width="73" height="83" alt="pan.conan@gmail.com" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                        pan.conan@gmail.com
                                    </a>
                                </p>
                                <span>06月21日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890009" href="javascript:void(0)">
                                    <img width="73" height="83" alt="Bluebaryamy@gmail.com" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890009" href="javascript:void(0)">
                                        Bluebaryamy@gmail.com
                                    </a>
                                </p>
                                <span>06月21日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889992" href="javascript:void(0)">
                                    <img width="73" height="83" alt="a0024a1@yacons.com.tw" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889992" href="javascript:void(0)">
                                        a0024a1@yacons.com.tw
                                    </a>
                                </p>
                                <span>06月21日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=542979" href="javascript:void(0)">
                                    <img width="73" height="83" alt="李赴朝" src="static/images/20170413051559.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=542979" href="javascript:void(0)">
                                        李赴朝
                                    </a>
                                </p>
                                <span>06月18日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=611876" href="javascript:void(0)">
                                    <img width="73" height="83" alt="刘" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=611876" href="javascript:void(0)">
                                        刘
                                    </a>
                                </p>
                                <span>06月17日</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!---------------右侧内容结束------------------>
        </div>
    </div>
</div>