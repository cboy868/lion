<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/product.css">
<div class="product details common">
    <div class="container clearfix bgcolor1">
        <!--        <div class="skin_img"><img src="/theme/m2/static/gls/img/product/skin_product.jpg" /></div>-->
        <div class="main right">
            <div class="borbox">
                <h2 class="tit2">
                    <span class="txtd"><?=g('cp_name')?>产品</span>
                </h2>
                <div class="det clearfix">
                    <p class="breadcrumb">当前位置：
                        <a href="/">首页</a><span>&gt;</span>
                        <a href="<?=\yii\helpers\Url::toRoute(['/grave/home/default/index'])?>">墓区列表</a>
                        <span>&gt;</span> <?=$data['name']?></p>
                    <?=\app\core\widgets\Alert::widget();?>


                            <div class="environment shadow">
                                <div class="slider" style="background: none;">
                                    <ul class="slider_main">
                                        <?php foreach ($thumbs as $k=>$thumb):?>
                                        <li style="<?php if($k==0):?>display:block;<?php endif;?>">
                                            <a class="link" href="#">
                                                <img style="width:800px;" src="<?=$thumb['url']?>" alt="">
                                            </a>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>

                            <div class="buy_btnbox">
                                <a href="<?=\yii\helpers\Url::toRoute(['/cms/home/message/index', 'id'=>$data['id']])?>"
                                   class="buy1"
                                   style="    float: right;height: 30px;font-size: 0;"
                                >网上预约</a>
                            </div>
                        <p class="product_tabtit">
                            <a class="active">产品介绍</a>
                        </p>
                        <div class="product_tabcon">
                            <div class="items">
                                <?=$data['intro']?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="aside">
            <div class="list_nav borbox">
                <h2 class="tit2">
                    <span class="txta">自助服务</span>
                </h2>
                <div class="det">
                    <ul>
                        <li><a href="#">墓碑墓型</a></li>
                        <li><a href="#">远程祭祀</a></li>
                        <li><a href="#">网上订花</a></li>
                        <li><a href="#">随葬用品</a></li>
                        <li><a href="#">瓷像制作</a></li>
                    </ul>
                </div>
            </div>
            <div class="record borbox">
                <h2 class="tit2">
                    <span class="txtb">浏览过......</span>
                </h2>
                <div class="det clearfix">
                    <div class="items">
                        <div class="right">
                            <a href="#">这是标题1</a>
                            <p>这是内容内容...</p>
                        </div>
                        <a class="img" href="#"><img width="80" height="80" src="/theme/m2/static/gls/img/product/a_03.jpg" alt="" /></a>
                    </div>
                    <div class="items">
                        <div class="right">
                            <a href="#">这是标题1</a>
                            <p>这是内容内容...</p>
                        </div>
                        <a class="img" href="#"><img width="80" height="80" src="/theme/m2/static/gls/img/product/a_03.jpg" alt="" /></a>
                    </div>
                    <div class="items">
                        <div class="right">
                            <a href="#">这是标题1</a>
                            <p>这是内容内容...</p>
                        </div>
                        <a class="img" href="#"><img width="80" height="80" src="/theme/m2/static/gls/img/product/a_03.jpg" alt="" /></a>
                    </div>
                    <a href="" class="right">清空</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/theme/m2/static/libs/cSwitch/cSwitch.min.js"></script>
<script type="text/javascript">
    $(function(){

        $('.slider').cSwitch({
            bigImg : '.slider_main li',
            PNBtnShow : true,
            changeFade : true,
            changeTime : 3000
        });



        album.init() //图册
    });
</script>