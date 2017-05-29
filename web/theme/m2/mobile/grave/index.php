<?php
use yii\helpers\Url;
?>
<div class="content" id="news-box">
    <article class="weui-article">
        <h3>待处理</h3>
    </article>
    <div class="weui-panel weui-panel_access zixun_list">
        <?php foreach ($ins as $v):?>
        <div class="weui-panel__bd" id="listbox">
            <a href="<?=Url::toRoute(['/grave/m/default/ins', 'id'=>$v->id])?>" class="weui-media-box weui-media-box_appmsg weui-cell weui-cell_access">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="<?=$v->front?>">
                </div>
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="<?=$v->back?>">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title"><?=$v->tomb->tomb_no?>碑文</h4>
<!--                    <p class="weui-media-box__desc">2015/08/01</p>-->
                </div>
                <div class="weui-cell__ft">
                    详细
                </div>
            </a>
        </div>
        <?php endforeach;?>
        <?php foreach ($portrait as $k => $v):?>
            <div class="weui-panel__bd" id="listbox">
                <a href="<?=Url::toRoute(['/grave/m/default/portrait', 'tid'=>$k])?>"
                   class="weui-media-box weui-media-box_appmsg weui-cell weui-cell_access">
                    <?php foreach ($v as $val): ?>
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" src="<?=$val->processedImg?>">
                    </div>
                    <?php endforeach; ?>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title"><?=$val->tomb->tomb_no?> 瓷像 </h4>
                        <!--                    <p class="weui-media-box__desc">2015/08/01</p>-->
                    </div>
                    <div class="weui-cell__ft">
                        详细
                    </div>
                </a>
            </div>
        <?php endforeach;?>

    </div>

    <article class="weui-article">
            <h3>业务历史</h3>
    </article>
    <div class="weui-panel weui-panel_access zixun_list">
        <div class="weui-panel__bd" id="listbox">
            <a href="#" class="weui-media-box weui-media-box_appmsg">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="/static/images/default.bak.png">
                </div>
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="/static/images/default.bak.png">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title">某区某排1号</h4>
                    <p class="weui-media-box__desc">2015/08/01</p>
                </div>
            </a>
        </div>
    </div>

    <div class="weui-loadmore weui-loadmore_line">
        <span class="weui-loadmore__tips">暂无数据</span>
    </div>

</div>




















