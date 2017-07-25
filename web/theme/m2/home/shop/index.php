<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/after_sale.css">
<div class="after_sale common">
        <div class="container">
            <div class="skin_img shadow"><img src="/theme/m2/static/gls/img/after_sale/skin_after_sale.jpg" /></div>
            <div class="process shadow">
                <h2 class="tit1">
                    <span class="txta">安葬流程</span>
                </h2>
                <div class="det">
                    <div class="bor clearfix posf tips_box">
                        <a href="#" class="round hover_ele" data-tip-txt="吉时预定<br />清洁维护<br />风俗讲解">
                            <div class="round"><img src="/theme/m2/static/gls/img/after_sale/round_1.gif" /></div>
                            <div class="txt">
                                <h3 class="right">安葬预定</h3>
                                <div class="round_small">1</div>
                            </div>
                        </a>
                        <span class="arrow"></span>
                        <a href="#" class="round hover_ele" data-tip-txt="避光迎灵<br />随葬品领取">
                            <div class="round"><img src="/theme/m2/static/gls/img/after_sale/round_2.gif" /></div>
                            <div class="txt">
                                <h3 class="right">迎灵服务</h3>
                                <div class="round_small">2</div>
                            </div>
                        </a>
                        <span class="arrow"></span>
                        <a href="#" class="round hover_ele" data-tip-txt="净宅净碑<br />温馨暖穴<br />祈福安放随葬品<br />跪式安葬<br />指导祭拜">
                            <div class="round"><img src="/theme/m2/static/gls/img/after_sale/round_3.gif" /></div>
                            <div class="txt">
                                <h3 class="right">礼仪安葬</h3>
                                <div class="round_small">3</div>
                            </div>
                        </a>
                        <span class="arrow"></span>
                        <a href="#" class="round hover_ele" data-tip-txt="代客献花<br />节日问候<br />专项祭礼">
                            <div class="round"><img src="/theme/m2/static/gls/img/after_sale/round_4.gif" /></div>
                            <div class="txt">
                                <h3 class="right">远程祭祀</h3>
                                <div class="round_small">4</div>
                            </div>
                        </a>
                        <span class="arrow"></span>
                        <a href="#" class="round hover_ele" data-tip-txt="安葬奉地献花布置<br />祭祀献花">
                            <div class="round"><img src="/theme/m2/static/gls/img/after_sale/round_5.gif" /></div>
                            <div class="txt">
                                <h3 class="right">献花服务</h3>
                                <div class="round_small">5</div>
                            </div>
                        </a>
                        <span class="arrow"></span>
                        <a href="#" class="round hover_ele" data-tip-txt="随葬品套装<br />墓穴装饰：绢花（盆花）、镇墓石狮、香炉供台">
                            <div class="round"><img src="/theme/m2/static/gls/img/after_sale/round_6.gif" /></div>
                            <div class="txt">
                                <h3 class="right">祭祀商品</h3>
                                <div class="round_small">6</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="special shadow">
                <h2 class="tit1">
                    <span class="txtb">节日专题</span>
                </h2>
                <div class="det">
                    <div class="bor set_lastli">
                        <ul class="clearfix">
                            <?php
                            $subject = subject('jieri',7, '133x87');
                            ?>
                            <?php foreach ($subject as $k => $v):?>
                                <li>
                                    <a href="<?=$v['link']?>" class="pic" target="_blank">
                                        <img src="<?=$v['cover']?>" />
                                    </a>
                                    <a href="<?=$v['link']?>" class="tit" target="_blank"><?=$v['title']?></a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="hot shadow">
                <h2 class="tit1">
                <a title="热销随葬品--查看更多" href="#" class="more">
                    <img alt="热销随葬品--查看更多" src="/theme/m2/static/gls/img/global/more.gif">
                </a>
                    <span class="txtc">热销随葬品</span>
                </h2>
                <div class="det">
                    <div class="bor">
                        <ul class="clearfix product_box">
                            <?php $list = productByType(4, 12, '152x152');?>
                            <?php foreach ($list as $k => $v):?>
                            <li>
                                <a class="tomb-avatar" href="<?=Url::toRoute(['/shop/home/default/view', 'id'=>$v['id']])?>">
                                    <img alt="<?=$v['name']?>" src="<?=$v['cover']?>">
                                </a>
                                <p><span style="font-size: 20px;color:red;">￥ <?=$v['price']?></span></p>
                                <p>
                                    <?=$v['name']?>
                                </p>
                                <div class="function-box clearfix right">
                                    <a href="#"><img alt="加入购物车" src="/theme/m2/static/gls/img/product/small_online_appointment.png"></a>
<!--                                    <a href="#"><img alt="购买" src="/theme/m2/static/gls/img/product/buy_small_btn.png"></a>-->
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="image shadow">
                <h2 class="tit1">
                    <span class="txtd">远程祭祀</span>
                </h2>
                <?php $glist = productCateByType(1, 12, '160x120');?>
                <div class="tabbox padt20 clearfix">
                    <div class="bor padb0">
                        <div class="tab">
                            <div class="tabtit">
                                <?php foreach ($glist as $k => $v):?>
                                <a href="javascript:;" class="<?php if($k==0):?> active<?php endif;?>"><?=$v['name']?></a>
                                <?php endforeach;?>
                            </div>
                            <div class="tabcon">
                                <?php foreach ($glist as $k => $v):?>
                                <div class="flower_list clearfix" style="<?php if($k==0):?>display:block;<?php endif;?>">

                                    <?php
                                    if (isset($v['child'])):
                                    foreach ($v['child'] as $goods):?>
                                        <div class="items_n">
                                            <a target="_blank" class="pic" href="<?=Url::toRoute(['/shop/home/default/view', 'id'=>$goods['id']])?>"><img src="<?=$goods['cover']?>"></a>
                                            <p class="tit"><?=$goods['name']?></p>
                                            <a href="#" class="reservation">点击预定</a>
                                        </div>
                                    <?php endforeach;endif;?>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div class="select_guide shadow">-->
<!--                <h2 class="tit1">-->
<!--                    <span class="txte">安葬礼仪师</span>-->
<!--                </h2>-->
<!--                <div class="det">-->
<!--                    <ul class="clearfix">-->
<!--                        <li>-->
<!--                            <div class="avatar"><img src="/theme/m2/static/gls/img/after_sale/p1_11.jpg"></div>-->
<!--                            <p class="name">姓名：陈安康</p>-->
<!--                            <a class="online" href="#">在线咨询</a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="avatar"><img src="/theme/m2/static/gls/img/after_sale/p2_11.jpg"></div>-->
<!--                            <p class="name">姓名：蒋开雄</p>-->
<!--                            <a class="online" href="#">在线咨询</a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="avatar"><img src="/theme/m2/static/gls/img/after_sale/p3_11.jpg"></div>-->
<!--                            <p class="name">姓名：李国彬</p>-->
<!--                            <a class="online" href="#">在线咨询</a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="avatar"><img src="/theme/m2/static/gls/img/after_sale/p4_11.jpg"></div>-->
<!--                            <p class="name">姓名：王刚</p>-->
<!--                            <a class="online" href="#">在线咨询</a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="avatar"><img src="/theme/m2/static/gls/img/after_sale/p5_11.jpg"></div>-->
<!--                            <p class="name">姓名：王冰源</p>-->
<!--                            <a class="online" href="#">在线咨询</a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
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