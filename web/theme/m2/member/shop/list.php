<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/after_sale.css">
<style>
    .tit1 span {
        display: block;
        height: 24px;
         text-indent: 0px;
        background-repeat: no-repeat;
        font-size: 25px;
        line-height: 24px;
        background-image:none;
        color: #855D5B;
        font-family: "Arial";
    }
</style>
<div class="after_sale common">
    <div class="container">
        <div class="skin_img shadow"><img src="/theme/m2/static/gls/img/after_sale/skin_after_sale.jpg" /></div>
        <div class="image shadow">
            <p class="breadcrumb">当前位置：
                <a href="/page">首页</a><span>&gt;</span> <a href="<?=Url::toRoute(['/shop/home/default/index'])?>">产品列表</a>
                <span>&gt;</span> <?=$cate['name']?></p>
            <div class="tabbox padt20 clearfix">
                <div class="bor padb0">
                    <div class="tab">
                        <div class="tabtit">
                            <a href="javascript:;" class="active"><?=$cate['name']?></a>
                        </div>
                        <div class="tabcon">
                                <div class="flower_list clearfix" style="display:block">
                                    <?php foreach ($list as $goods):?>
                                        <div class="items_n">
                                            <a target="_blank" class="pic" href="<?=Url::toRoute(['/shop/home/default/view', 'id'=>$goods['id']])?>">
                                                <img src="<?=$goods['cover']?>">
                                            </a>
                                            <p class="tit"><?=$goods['name']?></p>
                                            <a href="#" class="reservation">点击预定</a>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            <ul class="pagination yw-page">

                                <?php
                                echo LinkPager::widget([
                                    'pagination' => $pagination,
                                ]);
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="op shadow">
            <a href="#" class="btn1">修补金铂字</a>
            <a href="#" class="btn2">维护费续期</a>
            <a href="#" class="btn3">投诉建议</a>
        </div>
    </div>
</div>
<script type="text/javascript" src="/theme/m2/static/libs/cSwitch/cSwitch.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('.tab').cSwitch({
            btnItems : '.tabtit a',
            bigImg : '.tabcon > .flower_list',
            PNBtnShow : false,
            changeFade : false,
            autoPlay : false
        });

        tipsTxt.init();
    });
</script>