<?php
use yii\helpers\Url;
$this->params['current_nav'] = 'memorial';
?>
<div class="container bannerAndLogin">
    <div class="col-md-9">
        <div class="row">
            <div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-timeout="4000" data-cycle-slides="> a" data-cycle-pause-on-hover="true" style="overflow: hidden;"><a href="#" data-cycle-title="实景墓园" data-cycle-desc="让使用者无论身在何处，都能亲临真实墓园的祭拜感受..." class="cycle-slide cycle-sentinel" style="position: static; top: 0px; left: 0px; z-index: 100; opacity: 1; display: block; visibility: hidden;">
                    <img alt="实景墓园" src="/UploadFiles/Image/2016/5/13/Heaven/CommandAd/PhotoPath/20160513165415.jpg" style="visibility: hidden;">
                </a>
                <!-- empty element for pager links -->
                <span class="cycle-prev"></span>
                <span class="cycle-next"></span>
                <span class="cycle-caption">4 / 5</span>
                <div class="cycle-overlay"><div>在线追思</div><div>激扬人生留下的传奇故事 让思念带着灵魂永驻天堂</div></div>

                <a href="#" data-cycle-title="实景墓园" data-cycle-desc="让使用者无论身在何处，都能亲临真实墓园的祭拜感受..." class="cycle-slide" style="position: absolute; top: 0px; left: 0px; z-index: 96; opacity: 1; display: block; visibility: hidden;">
                    <img alt="实景墓园" src="/UploadFiles/Image/2016/5/13/Heaven/CommandAd/PhotoPath/20160513165415.jpg">
                </a><a href="#" data-cycle-title="特别的爱" data-cycle-desc="让使用者无论身在何处，都能亲临真实墓园的祭拜感受..." class="cycle-slide" style="position: absolute; top: 0px; left: 0px; z-index: 95; visibility: hidden; opacity: 1; display: block;">
                    <img alt="特别的爱" src="/UploadFiles/Image/Heaven/CommandAd/PhotoPath/tebie.jpg">
                </a><a href="#" data-cycle-title="香火不断" data-cycle-desc="特别的爱，献给特别的你。" class="cycle-slide" style="position: absolute; top: 0px; left: 0px; z-index: 95; visibility: hidden; opacity: 1; display: block;">
                    <img alt="香火不断" src="/UploadFiles/Image/2016/5/13/Heaven/CommandAd/PhotoPath/20160513165347.jpg">
                </a><a href="#" data-cycle-title="在线追思" data-cycle-desc="激扬人生留下的传奇故事 让思念带着灵魂永驻天堂" class="cycle-slide cycle-slide-active" style="position: absolute; top: 0px; left: 0px; z-index: 99; visibility: visible; opacity: 1; display: block;">
                    <img alt="在线追思" src="/UploadFiles/Image/2016/5/13/Heaven/CommandAd/PhotoPath/20160513163545.jpg">
                </a><a href="http://www.waheaven.com/Activity/heavenstory/index.html" data-cycle-title="一千零一个天堂故事" data-cycle-desc="将亲人的思念化作永恒-让生命的故事流芳百世" class="cycle-slide" style="position: absolute; top: 0px; left: 0px; z-index: 97; visibility: hidden; opacity: 1; display: block;">
                    <img alt="一千零一个天堂故事" src="/UploadFiles/Image/2016/4/1/Heaven/commandAd/PhotoPath/20160401102211.jpg">
                </a></div>
        </div>
    </div>
    <div class="col-md-3" style="background-color:#d6e0db;">
        <div class="row setHeight">
            <div class="register-btn"><a href="/MemberCenter/Memorial/Add" class="btn btn-warning btn-lg">免费创建纪念馆</a></div>
            <div class="build-step step1">用户免费注册</div>
            <div class="build-step step2">完善纪念馆资料</div>
            <div class="build-step step3">纪念馆创建成功</div>
        </div>
    </div>
</div>

<div class="blank"></div>
<div class="container">
    <div class="row memorials-list">
        <?php
        $models = $dataProvider->getModels();
        foreach ($models as $model):
        ?>
        <div class="col-md-4">
            <div class="media">
                <div class="media-left">
                    <div class="tab-content">
                        <div class="tab-pane active  ml_0_0">
                            <a href="<?=Url::toRoute(['/memorial/home/hall/index','id'=>$model->id])?>" target="_blank">
                                <img src="<?=$model->getThumbImg('174x210')?>">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <a target="_blank" href="<?=Url::toRoute(['/memorial/home/hall/index','id'=>$model->id])?>">
                        <h4 class="media-heading ellipsis"><?=$model->title?></h4>
                    </a>
                    <div class="tab-content">
                        <?php foreach ($model->deads as $v):?>
                        <div class="tab-pane active ml_0_0">
                            <a target="_blank" href="#">
                                <p class="ellipsis"><?=$v->dead_name?></p>
                            </a>
                            <em><?=$v->birth?>-<?=$v->fete?></em>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <p class="ellipsis">建馆人：<?=$model->user->username?></p>
                    <small>建馆时间：<?=date('Y-m-d', $model->created_at)?></small><br>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <div class="memorials-pager">
        <?php
        echo \yii\widgets\LinkPager::widget([
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
</div>