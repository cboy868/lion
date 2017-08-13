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

                <div class="col-md-6 jdwz">
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
                <div class="col-md-6">
                    <img width="100%" src="<?=$memorial->getThumbImg('500x500')?>" alt="">
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
                            <a class="bg-tit" href="<?=Url::toRoute(['life', 'id'=>$memorial->id])?>">生平简介</a>
                        </div>
                        <div class="pull-right"><a href="<?=Url::toRoute(['life', 'id'=>$memorial->id])?>">详细内容&gt;&gt;</a></div>
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
                        <div class="pull-left">
                            <a class="bg-tit" href="<?=Url::toRoute(['archive', 'id'=>$memorial->id])?>">档案资料</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?=Url::toRoute(['archive', 'id'=>$memorial->id])?>">更多内容&gt;&gt;</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="about-index da-info">
                        <ul class="list-unstyled">
                            <?php foreach ($archives as $v): ?>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="#"><?=$v->title?></a></h5>
                                    <h6>
                                        作者：
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
                        <div class="pull-left">
                            <a class="bg-tit" href="<?=Url::toRoute(['miss', 'id'=>$memorial->id])?>">追思文章</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?=Url::toRoute(['miss', 'id'=>$memorial->id])?>">更多内容&gt;&gt;</a>
                        </div>
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
<!--
                <div class="box">
                    <div class="side-title">
                        微信扫一扫“码”上纪念
                    </div>
                    <div style="text-align:center" class="side-tips">
                    <span>
                        <img src="#">
                    </span>
                    </div>
                </div>
-->
                <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>Yii::$app->request->get('id')])?>

                <div class="blank"></div>
                <div class="box">
                    <div class="side-title">
                        <a class="tit" href="javascript:void(0)">祭奠记录</a>
                        <a class="more" href="#">更多祭奠记录&gt;&gt;</a></div>
                    <div class="scoll-up">
                        <ul class="list-unstyled">
                            <li class="">
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=581180" href="javascript:void(0)">狄国老</a>
                                    敬献了普通香
                                </p>
                                <span>敬献时间：2017-01-07 01:52</span>
                            </li>
                            <li class="">
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886146" href="javascript:void(0)">151*****097</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2016-12-21 02:11</span>
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
                <div class="blank"></div>
                <div class="box">
                    <div class="side-title">
                        <a class="tit" href="javascript:void(0)">到过这里的访客</a>
                        <a class="more" href="javascript:void(0)">更多&gt;&gt;</a>
                    </div>
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

                        </ul>
                    </div>
                </div>
            </div>
            <!---------------右侧内容结束------------------>
        </div>
    </div>
</div>
