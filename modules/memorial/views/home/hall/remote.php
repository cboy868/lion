<?php
use yii\helpers\Url;
?>
<style>

    .goods-box ul{
        list-style:none;
        overflow: hidden;
    }

    .goods-box ul.cates{
        height:30px;
    }

    ul.goods{
        margin:0;
        padding:0;
    }
    ul.goods li.item{
        -webkit-border-radius:2px;
        -moz-border-radius:2px;
        border-radius:2px;

        width: 114px;
        height: 255px;
        margin-left: 5px;
        margin-top: 5px;
        border: 2px solid #D7D7D7;
        float: left;
        position: relative;
    }

    ul.goods li.item img{
        width:86px;
        height:86px;
    }

    ul.goods li.item .goods-cover{
        width:86px;
        height:86px;
        margin:5px auto;
    }
    .goods-cover img{
        -webkit-border-radius:3px;
        -moz-border-radius:3px;
        border-radius:10px;
        border:1px solid #fff;
    }

    ul.goods li.item .goods-intro{
        margin-left:4px;


    }

    .goods-intro {
        padding:5px;
    }
    .goods-intro p{
        margin: 0;
        line-height: 15px;
        font-size: 12px;

    }

    ul.goods li.item h2{
        height: 18px;
        font-size: 12px;
        line-height: 18px;
        margin-top: 0;
        margin-bottom: 0;
        background: #F0F0F0;
        text-align: center;

    }

    .goods-container{
        background: #fff;
    }
    .btns{
        margin:5px 5px 5px auto;
    }
    .btns a{
        position: absolute;
        bottom: 10px;
        right: 10px;
    }
    .cates li a{
        padding:5px 10px;
        margin: 0;
        border: none;
        border-radius: 0;
    }

</style>
<div class="goods-container">

    <div class="row goods-box">
        <div class="col-md-12">
            <div class="note">
                <p>
                    远程祭祀主要为身在外地，无法赶回，但又急于祭奠亲人提供方便，远程祭祀流程如下：
                </p>
                <p>
                    1、客户购买相应服务并在线支付;

                </p>
                <p>
                    2、我园代客祭拜，并录成视频，上传到客户个人空间;
                </p>
                <p>
                    3、客户登录我们的网站，在个人空间中查看祭祀过程。
                </p>
                <p>
                    注：因空间有限，视频会在商品过期后自动删除，客户可提前下载到自己电脑，另远程祭祀只适用我园业务。
                </p>
                <br>
            </div>
        </div>
        <div class="col-md-12">

                <ul class="nav nav-tabs cates" role="tablist">
                    <?php foreach ($cates as $k=>$cate):?>

                    <li role="presentation" class="<?php if($k==0)echo'active';?>">
                        <a href="#cate<?=$cate->id?>" aria-controls="home" role="tab" data-toggle="tab"><?=$cate->name?></a>
                    </li>
                    <?php endforeach;?>
                </ul>

                    <div class="tab-content">
                        <?php foreach ($cates as $k =>$cate):?>
                        <div role="tabpanel" class="tab-pane <?php if($k==0)echo'active';?>" id="cate<?=$cate->id?>">
                            <ul class="goods">
                                <?php foreach ($goods[$cate->id] as $key => $g):?>
                                <li class="item">
                                    <h2><?=$g->name?></h2>
                                    <div class="goods-cover">
                                        <img src="/upload/image/thumb/201708/160x160@1502261497577.jpeg" alt="">
                                    </div>

                                    <div class="goods-intro">
                                        <p>原价: <span><?=$g->original_price?></span></p>
                                        <p>现价: <span><?=$g->price?></span></p>
                                        <p>时间: <span><?=$g->days?>天</span></p>
                                        <?php if (count($g->sku)>1):?>
                                        <p>规格:
                                            <select class="sku_id">
                                                <?php foreach ($g->sku as $sku):?>
                                                <option value="<?=$sku->id?>"><?=$sku->name?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </p>
                                        <?php else:?>
                                            <input type="hidden" value="<?=$g->sku[0]->id?>" class="sku_id">
                                        <?php endif;?>
                                        <p>
                                            数量:
                                            <span>
                                                <input type="number" style="width: 50px;" value="1" class="num">
                                            </span>
                                        </p>
                                    </div>
                                    <div class="btns">
                                        <a tabindex="0" class="btn btn-xs btn-danger pull-right s2"
                                           role="button"
                                           data-toggle="popover"
                                           data-trigger="focus"
                                           data-sku_id=<?=$g->id?>
                                           >购买</a>
                                    </div>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <?php endforeach;?>

                    </div>

                <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->beginBlock('cate') ?>
$(function(){
    $('.s2').popover({
        title:'微信扫码支付',
        content:function(){

            var sku_id = $(this).closest('.item').find('.sku_id').val();
            var num = $(this).closest('.item').find('.num').val();
            var url = "<?=Url::toRoute(['qr-goods','id'=>$memorial_id])?>&sku_id="+sku_id+"&num="+num;
            return '<img src="'+url+'" alt="扫码支付" style="width:160px; height: 160px;">';
        },
        html: 'true',
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>

