<?php
use yii\helpers\Url;
$this->title="业务办理";
$wid = Yii::$app->request->get('wid');
?>

<div class="content" id="news-box">
    <article class="weui-article">
        <h3>待处理</h3>
    </article>
    <div class="weui-panel weui-panel_access zixun_list">

        <?php if (!isset($ins[0]) && !isset($portrait[4])):?>
            <div class="weui-loadmore weui-loadmore_line">
                <span class="weui-loadmore__tips">暂无数据</span>
            </div>
        <?php endif;?>


        <?php if (isset($ins[0])): ?>
            <?php foreach ($ins[0] as $v):?>
            <div class="weui-panel__bd" id="listbox">
                <a href="<?=Url::toRoute(['/grave/m/default/ins', 'id'=>$v->id, 'wid'=>$wid])?>" class="weui-media-box weui-media-box_appmsg weui-cell weui-cell_access">
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
        <?php endif;?>

        <?php if (isset($portrait[4])):?>
        <?php foreach ($portrait[4] as $k => $v):?>
            <div class="weui-panel__bd" id="listbox">
                <a href="<?=Url::toRoute(['/grave/m/default/portrait', 'tid'=>$k, 'wid'=>$wid])?>"
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
        <?php endif;?>

    </div>

    <article class="weui-article">
            <h3>业务记录</h3>
    </article>
    <div class="weui-panel weui-panel_access zixun_list">
        <?php if (isset($ins[1])): ?>
            <?php foreach ($ins[1] as $v):?>
                <div class="weui-panel__bd" id="listbox">
                    <a href="<?=Url::toRoute(['/grave/m/default/ins', 'id'=>$v->id,'wid'=>$wid])?>" class="weui-media-box weui-media-box_appmsg weui-cell weui-cell_access">
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
        <?php endif;?>
        <?php if (isset($portrait['other'])): ?>
        <?php foreach ($portrait['other'] as $k=>$v):?>
            <div class="weui-panel__bd" id="listbox">
                <a href="<?=Url::toRoute(['/grave/m/default/portrait', 'tid'=>$k,'wid'=>$wid])?>" class="weui-media-box weui-media-box_appmsg weui-cell weui-cell_access">
                    <?php foreach ($v as $val): ?>
                        <div class="weui-media-box__hd">
                            <img class="weui-media-box__thumb" src="<?=$val->processedImg?>">
                        </div>
                    <?php endforeach; ?>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title"><?=$val->tomb->tomb_no?>瓷像</h4>
                        <!--                    <p class="weui-media-box__desc">2015/08/01</p>-->
                    </div>
                    <div class="weui-cell__ft">
                        详细
                    </div>
                </a>
            </div>
        <?php endforeach;?>
        <?php endif;?>
    </div>

    <?php if (!isset($ins[1]) && !isset($portrait['other'])): ?>
        <div class="weui-loadmore weui-loadmore_line">
            <span class="weui-loadmore__tips">暂无数据</span>
        </div>
    <?php endif;?>


</div>




















