<?php
use yii\helpers\Url;
$this->params['current_nav'] = 'index';
?>
<style>
    .popover-content img{
        max-width:100%;
    }
</style>
<div class="container main-container">
    <div class="row">
        <div class="col-md-12">
            <a target="_blank" href="#">
                <img src="/static/images/memorial/memorial_memorial.png" width="100%">
            </a>
        </div>
    </div>
    <div class="blank"></div>
    <!-- left{ -->
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-box white-bg">
                        <ul class="nav nav-tabs tabs-waheaven" role="tablist">
                            <li class="active"><a data-toggle="tab"><h4>最新纪念馆</h4></a></li>
                        </ul>
                        <div class="tab-content person-list">
                            <div class="tab-pane fade in active">
                                <ul>
                                    <?php foreach ($memorials as $v):?>
                                    <li>
                                        <a target="_blank" href="<?=Url::toRoute(['/memorial/home/hall/index', 'id'=>$v->id])?>">
                                            <img alt="<?=$v->title?>" src="<?=$v->getCover('120x145')?>">
                                            <p class="ellipsis"><?=$v->title?></p>
                                        </a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="blank"></div>
            <div class="row">
                <!--
                <div class="col-md-12">
                    <iframe src="http://screen.ibagou.com:8080/" frameborder="0" style="width:100%;height:750px;"></iframe>
                </div>
                -->

                <div class="col-md-6 ">
                    <!-- 在线讣告{ -->
                    <div class="tab-box white-bg">
                        <ul class="nav nav-tabs tabs-waheaven" role="tablist">
                            <li class="active"><a data-toggle="tab"><h4>最新祭祀</h4></a></li>
                        </ul>
                        <div class="online-list">
                            <ul id="remoteList">
                                <?php foreach ($remotes as $v):?>
                                <li>
                                    <div class="col-md-4">
                                        <a href="#">
                                            <img alt="<?=$v->goodsSkuName?>" class="img-responsive" src="<?=$v->goods->cover?>">
                                        </a>
                                    </div>
                                    <div class="col-md-8 text-left no-padding-left no-padding-right">
                                        <h4><?=$v->goodsSkuName?></h4>
                                        <p>
                                            <?=$v->user->username?>敬上
                                        </p>
                                            <?=$v->note?>
                                    </div>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <!-- }在线讣告 -->
                </div>
                <div class="col-md-6">

                    <!-- 今日忌日 & 今日生日{ -->
                    <div class="tab-box white-bg">
                        <ul class="nav nav-tabs tabs-waheaven" role="tablist">
                            <li class="active"><a href="#tb" data-toggle="tab"><h4>今日生辰</h4></a></li>
                            <li><a href="#tf" data-toggle="tab"><h4>今日忌日</h4></a></li>
                        </ul>
                        <div class="tab-content person-list">
                            <div id="tb" class="tab-pane fade in active">
                                <ul>
                                    <?php foreach ($birth as $v):?>
                                    <li>
                                        <a target="_blank" href="<?=Url::toRoute(['/memorial/home/hall/index', 'id'=>$v->memorial_id])?>">
                                            <img alt="<?=$v->dead_name?>" src="<?=$v->getAvatarImg('128x145')?>">
                                            <p class="ellipsis"><?=$v->dead_name?></p>
                                        </a>

                                        <span>生辰:<?=$v->birth?> </span>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <div id="tf" class="tab-pane fade">
                                <ul>
                                    <?php foreach ($fete as $v):?>
                                        <li>
                                            <a target="_blank" href="<?=Url::toRoute(['/memorial/home/hall/index', 'id'=>$v->memorial_id])?>">
                                                <img alt="<?=$v->dead_name?>" src="<?=$v->getAvatarImg('128x145')?>">
                                                <p class="ellipsis"><?=$v->dead_name?></p>
                                            </a>

                                            <span>忌日:<?=$v->fete?> </span>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- }今日忌日 & 今日生日 -->
                </div>
            </div>
            <div class="blank"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="tab-box white-bg">
                        <ul class="nav nav-tabs tabs-waheaven" role="tablist">
                            <li class="active"><a href="#zqAlbums" data-toggle="tab"><h4>音容笑貌</h4></a></li>
                        </ul>
                        <div class="albums-list">
                            <ul>
                                <?php foreach ($albums as $v):?>
                                <li>
                                    <a target="_blank" href="<?=Url::toRoute(['/memorial/home/hall/photos','id'=>$v->memorial_id,'album_id'=>$v->id])?>">
                                        <img alt="<?=$v->title?>" src="<?=$v->getCover('240x320')?>"><p><?=$v->title?></p>
                                    </a>
                                </li>
                                <?php endforeach;?>
                            </ul>
                            <div class="blank"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- }left -->
        <!-- right{ -->
        <div class="col-md-3">
                <!-- 时空信箱{ -->
                <div class="tab-box white-bg">
                    <ul class="nav nav-tabs tabs-waheaven" role="tablist">
                        <li class="active"><a data-toggle="tab"><h4>美好祝福</h4></a></li>
                    </ul>
                    <div class="tab-content mail-list">
                        <div role="tabpanel" class="tab-pane fade in active">
                            <ul id="msgList">
                                <?php foreach ($msgs as $msg):?>
                                <li>
                                    <div class="user-avatar">
                                        <a href="javascript:void(0)">
                                            <img src="<?=$msg->fromUser->getAvatar('40x40')?>" />
                                            <p><?=$msg->fromUser->username?></p>
                                        </a>
                                    </div>
                                    <a target="_blank" href="#">
                                        <div class="popover tt-popover right">
                                            <div class="arrow"></div>
                                            <div class="popover-content" style="overflow:hidden;">
                                                <?=$msg->content?>
                                            </div>
                                        </div>
                                    </a>

                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- }时空信箱 -->
                <div class="blank"></div>
                <!-- 最新纪念文章{ -->
                <div class="tab-box white-bg">
                    <ul class="nav nav-tabs tabs-waheaven" role="tablist">
                        <li class="active"><a data-toggle="tab"><h4>最新纪念文章</h4></a></li>
                    </ul>
                    <div class="tab-content tab-list article-tab-list">
                        <div role="tabpanel" class="tab-pane fade in active">
                            <ul>

                                <?php foreach ($blogs as $blog):?>
                                <li>
                                    <a target="_blank" href="<?=Url::toRoute(['/memorial/home/hall/miss-view','id'=>$blog->memorial_id,'bid'=>$blog->id])?>">
                                        <?=$blog->title?>
                                    </a>
                                    <span><?=$blog->user->username;?></span>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- }最新纪念文章 -->
        </div>
    </div>
</div>
<?php $this->beginBlock('cate') ?>

$(function(){
    $('#msgList').roll(4200);
    $('#remoteList').roll(4000);

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>

