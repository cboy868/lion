<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/product.css">
<div class="product details common">
        <div class="container clearfix bgcolor1">
<!--            <div class="skin_img"><img src="/theme/m2/static/gls/img/product/skin_product.jpg" /></div>-->
            <div class="main right">
                <div class="borbox">
                    <h2 class="tit2">
                        <span class="txtd"><?=g('cp_name')?>产品</span>
                    </h2>
                    <div class="det clearfix">
                        <p class="breadcrumb">当前位置：
                            <a href="/page">首页</a><span>&gt;</span> <a href="/page/index/product">产品</a>
                            <span>&gt;</span> 墓碑墓型</p>
                        <div class="product_album">

                        </div>
                        <div class="right">
                            <form action="">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr height="50">
                                        <td class="highlight"><?=$data['name']?></td>
                                    </tr>
                                    <tr height="50">
                                        <td>价格</td>
                                        <td class="highlight">¥<?=$data['price']?></td>
                                    </tr>
                                </table>
                                <div class="buy_btnbox">
<!--                                    <input type="button" class="buy1" />-->
                                    <input type="button" class="buy2" />
                                </div>
                            </form>
                        </div>
                        <div class="product_album">
                            <div class="tomb-bigshow">
                                <img src="<?=$data['cover']?>" class="changeImg" />
                            </div>
                            <div class="cut-listbox">
                                <span title="向左" class="cutleft"></span>
                                <span title="向右" class="cutright"></span>
                                <div class="cut-albumbox">
                                    <ul id="imgUl" class="clearfix">
                                        <?php foreach ($thumbs as $v):?>
                                        <li class="active" data-zoom="<?=$v['url']?>" data-big="<?=$v['url']?>">
                                            <a href="javascript:void(0);">
                                                <img alt="" src="<?=$v['url']?>" style="width:49px;height: 49px;">
                                            </a>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>
<!--                            <p><a href="#">收藏该商品</a>目前已有<span>0</span>人收藏</p>-->
                        </div>
                        <div class="tab" style="margin-top: 10px;">
                            <div class="tabtit">
                                <a href="javascript:;" class=" active">关联商品</a>
                            </div>
                            <?php $rels = getTagGoods($data['id'], 4, '160x120');?>
                            <div class="tabcon">
                                <div class="flower_list clearfix" style="display:block;">
                                    <?php foreach ($rels as $v):?>
                                    <div class="items_n">
                                        <a target="_blank" class="pic" href="<?=Url::toRoute(['/shop/home/default/view', 'id'=>$v['id']])?>">
                                            <img src="<?=$v['cover']?>">
                                        </a>
                                        <p class="tit"><?=$v['name']?></p>
                                        <a href="#" class="reservation">点击预定</a>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>

                        <div class="product_tab">
                            <p class="product_tabtit">
                                <a class="active">产品介绍</a>
<!--                                <a>评价</a>-->
<!--                                <a>交易记录</a>-->
                            </p>
                            <div class="product_tabcon">
                                <div class="items">
                                    <?=$data['intro'];?>
                                    <div class="padtb10"><img width="593" alt="" src="/theme/m2/static/gls/img/product/tomb_07.jpg"></div>
                                    <h3>评价</h3>
                                    <p class="evaluation">暂时没有评价</p>
                                </div>
<!--                                <div class="items" style="display:none;">-->
<!--                                    <h3>评价</h3>-->
<!--                                    <ol>-->
<!--                                        <li class="clearfix">-->
<!--                                            <div class="avatarbox left">-->
<!--                                                <a href="/home/profile/4790"><img alt="" src="/theme/m2/static/gls/img/default/avatar.gif"></a>-->
<!--                                                <a href="/home/profile/4790"><span class="f12">匿名用户</span></a>-->
<!--                                            </div>-->
<!--                                            <div class="left eval-info">-->
<!--                                                <ul>-->
<!--                                                    <p style="display:none">0</p>-->
<!--                                                    <li id="goods_5" class="vote-box goods">-->
<!--                                                        <b>产品评价：</b>-->
<!--                                                        <a class="active" href="javascript:void(0);"></a>&nbsp;<a class="active" href="javascript:void(0);"></a>&nbsp;<a class="active" href="javascript:void(0);"></a>&nbsp;<a class="active" href="javascript:void(0);"></a>&nbsp;<a class="active" href="javascript:void(0);"></a>&nbsp;                                            </li>-->
<!--                                                    <li>-->
<!--                                                        <b>评价内容：</b>-->
<!--                                                        不错不错 味道好几啦                    </li>-->
<!--                                                    <li class="hidden">-->
<!--                                                        <b>评价回复：</b>-->
<!--                                                    </li>-->
<!--                                                </ul>-->
<!--                                            </div>-->
<!--                                            <div class="ip-time right">-->
<!--                                                <p>(125.39.106.155&nbsp;)<br>2014-07-11 13:51:03</p>-->
<!--                                            </div>-->
<!--                                        </li>-->
<!--                                        <li class="clearfix">-->
<!--                                            <div class="avatarbox left">-->
<!--                                                <a href="/home/profile/4790"><img alt="" src="/theme/m2/static/gls/img/default/avatar.gif"></a>-->
<!--                                                <a href="/home/profile/4790"><span class="f12">匿名用户</span></a>-->
<!--                                            </div>-->
<!--                                            <div class="left eval-info">-->
<!--                                                <ul>-->
<!--                                                    <p style="display:none">0</p>-->
<!--                                                    <li id="goods_5" class="vote-box goods">-->
<!--                                                        <b>产品评价：</b>-->
<!--                                                        <a class="active" href="javascript:void(0);"></a>&nbsp;<a class="active" href="javascript:void(0);"></a>&nbsp;<a class="active" href="javascript:void(0);"></a>&nbsp;<a class="active" href="javascript:void(0);"></a>&nbsp;<a class="active" href="javascript:void(0);"></a>&nbsp;                                            </li>-->
<!--                                                    <li>-->
<!--                                                        <b>评价内容：</b>-->
<!--                                                        不错不错 味道好几啦                    </li>-->
<!--                                                    <li class="hidden">-->
<!--                                                        <b>评价回复：</b>-->
<!--                                                    </li>-->
<!--                                                </ul>-->
<!--                                            </div>-->
<!--                                            <div class="ip-time right">-->
<!--                                                <p>(125.39.106.155&nbsp;)<br>2014-07-11 13:51:03</p>-->
<!--                                            </div>-->
<!--                                        </li>-->
<!--                                    </ol>-->
<!--                                </div>-->
<!--                                <div class="items">-->
<!--                                    <h3>交易记录</h3>-->
<!--                                    <div class="product-msgbox" id="productMsgbox">-->
<!--                                        <ul class="products-js">-->
<!--                                            <li>  -->
<!--                                                <div id="buy-log">-->
<!--                                                    <table width="100%">-->
<!--                                                       <thead>-->
<!--                                                            <tr>-->
<!--                                                                <th>买家</th>-->
<!--                                                                <th>墓位区排号</th>-->
<!--                                                                <th>购买数量</th>-->
<!--                                                                <th>成交时间</th>-->
<!--                                                            </tr>-->
<!--                                                        </thead>-->
<!--                                                        <tbody id="tradeRecord">-->
<!--                                                            <tr>-->
<!--                                                                <td><a target="_blank" href="/home/profile/4790">刘大</a></td>-->
<!--                                                                <td><a target="_blank" href="/memorial/detail?id=">文华园S区10排1列</a>-->
<!--                                                                </td>-->
<!--                                                                <td>2</td>-->
<!--                                                                <td>2014-07-11 13:49:27</td>-->
<!--                                                            </tr><tr>-->
<!--                                                                <td><a target="_blank" href="/home/profile/4770">微信</a></td>-->
<!--                                                                <td><a target="_blank" href="/memorial/detail?id=27">文华园F区3排18列</a>-->
<!--                                                                </td>-->
<!--                                                                <td>1</td>-->
<!--                                                                <td>2014-06-10 09:23:11</td>-->
<!--                                                            </tr><tr>-->
<!--                                                                <td><a target="_blank" href="/home/profile/0"></a></td>-->
<!--                                                                <td><a target="_blank" href="/memorial/detail?id="></a>-->
<!--                                                                </td>-->
<!--                                                                <td>1</td>-->
<!--                                                                <td>2014-06-11 15:56:59</td>-->
<!--                                                            </tr><tr>-->
<!--                                                                <td><a target="_blank" href="/home/profile/0"></a></td>-->
<!--                                                                <td><a target="_blank" href="/memorial/detail?id="></a>-->
<!--                                                                </td>-->
<!--                                                                <td>4</td>-->
<!--                                                                <td>2014-06-15 14:05:07</td>-->
<!--                                                            </tr><tr>-->
<!--                                                                <td><a target="_blank" href="/home/profile/0"></a></td>-->
<!--                                                                <td><a target="_blank" href="/memorial/detail?id="></a>-->
<!--                                                                </td>-->
<!--                                                                <td>5</td>-->
<!--                                                                <td>2014-06-15 14:07:01</td>-->
<!--                                                            </tr><tr>-->
<!--                                                                <td><a target="_blank" href="/home/profile/0"></a></td>-->
<!--                                                                <td><a target="_blank" href="/memorial/detail?id="></a>-->
<!--                                                                </td>-->
<!--                                                                <td>3</td>-->
<!--                                                                <td>2014-06-15 14:12:41</td>-->
<!--                                                            </tr><tr>-->
<!--                                                                <td><a target="_blank" href="/home/profile/0"></a></td>-->
<!--                                                                <td><a target="_blank" href="/memorial/detail?id="></a>-->
<!--                                                                </td>-->
<!--                                                                <td>9</td>-->
<!--                                                                <td>2014-06-15 14:28:50</td>-->
<!--                                                            </tr>                    -->
<!--                                                        </tbody>-->
<!--                                                    </table>-->
<!--                                                </div>-->
<!--                                            </li>-->
<!--                                        </ul>-->
<!--                                    </div>-->
<!--                                </div>-->
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
                <div class="staff marb0 borbox">
                    <h2 class="tit2">
                        <span class="txtc">优秀员工</span>
                    </h2>
                    <div class="det clearfix">
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                        <dl class="user_list_items">
                            <dt><a href="#"><img src="/theme/m2/static/skin/img/global/staff_boy.jpg" /></a></dt>
                            <dd>用户名</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/theme/m2/static/libs/cSwitch/cSwitch.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.product_tab').cSwitch({
                btnItems : '.product_tabtit a',
                bigImg : '.product_tabcon .items',
                PNBtnShow : false,
                changeFade : false,
                autoPlay : false
            }); 

            album.init() //图册
        });
    </script>