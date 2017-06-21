<?php
$this->title="商品详情";
?>
<style>
    .concern-cart>div>p{
        font-size:10px;
    }
    .concern-cart>div{
        float: left;
        text-align: left;
        margin-top: 10px;
    }
</style>
<div class="content" id="news-box">
    <div class="swiper-container" style="height: 200px;">
        <img src="<?=$tomb->cover?>" />
    </div>

    <div class="goods_info_box goods_base">
        <div class="price_div">
            <span class="product-price1">
                <span class="big-price"><?=$tomb->tomb_no?></span>
            </span>
        </div>
    </div>
    <div class="weui-cells">
        <div class="shuxingbox">
            <div class="weui-cell chooseshuxiang">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>购买时间</p>
                </div>
                <div class="weui-cell__ft"><?=$tomb->sale_time?></div>
            </div>
            <?php if ($tomb->card): ?>
            <div class="weui-cell chooseshuxiang">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>墓证期限</p>
                </div>
                <div class="weui-cell__ft"><?=$tomb->card->start?> ~ <?=$tomb->card->end?></div>
            </div>
            <?php endif;?>
            <div class="weui-cell chooseshuxiang">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>办理人</p>
                </div>
                <div class="weui-cell__ft"><?=$tomb->customer->name?> <?=$tomb->customer->mobile?></div>
            </div>

            <?php if ($tomb->memorial):?>
            <a class="weui-cell weui-cell_access" href="<?=url(['/memorial/m/default/view', 'id'=>$tomb->memorial->id])?>">
                <div class="weui-cell__bd">
                    <p>纪念馆</p>
                </div>
                <div class="weui-cell__ft"><?=$tomb->memorial->title?></div>
            </a>
            <?php endif;?>

            <div class="weui-cell chooseshuxiang">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>备注</p>
                </div>
                <div class="weui-cell__ft"><?=$tomb->note?></div>
            </div>

        </div>
    </div>
</div>
