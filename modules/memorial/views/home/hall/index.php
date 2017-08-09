<?php
use yii\helpers\Url;
$this->params['current_nav'] = 'index';
?>
<div class="container memorial-container">
    <!--这里加内容-->
    <div class="white-bg">
        <div class="person-list">
            <div class="sline-box person-a">
                <ul class="nav nav-tabs sline" role="tablist">
                    <?php foreach ($deads as $k=>$v):?>
                    <li class="<?php if($k==0)echo"active";?>">
                        <a href=".d<?=$k?>" data-toggle="tab"><?=$v->dead_name?></a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="col-md-6 box">
                <div class="tab-content person-content">
                    <?php foreach ($deads as $k=>$v):?>
                    <div class="tab-pane fade d<?=$k?> <?php if($k==0)echo"active in";?>">

                        <div class="col-md-4 col-sm-4 text-center">
                            <img class="img-rounded img-responsive center-block" src="<?=$v->getAvatarImg('144x200')?>">
                            <br>
                        </div>


                        <div class="col-md-8 col-sm-8 info">
                            <ul class="list-unstyled">
                                <li><h4><?=$v->dead_name?></h4></li>
                                <li>
                                    <?=$v->birth?> ~ <?=$v->fete?>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12"><span>性别：</span><?=$v->genderText?></div>
                                    </div>
                                </li>
<!--                                <li>-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-md-12 col-sm-12">-->
<!--                                            <span>籍贯：</span>-->
<!--                                            暂无-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->

                                <?php if($v->tomb):?>
                                <li>
                                    <span>安葬位置：<?=$v->tomb->tomb_no?></span>

                                </li>
                                <?php endif;?>
                                <li><span>网址：</span><?=\yii\helpers\Url::current([],true)?></li>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-10 jdwz">
                    本馆由 <strong><?=$memorial->user->username;?></strong>于<?=date('Y-m-d', $memorial->created_at)?>建立。<br>
                    今日:<?=date('Y-m-d')?>。<br>
                    距:薄一波 <strong>11</strong>周年忌日还剩  <strong>160</strong> 天;
                    距:胡明 <strong>10</strong>周年忌日还剩  <strong>60</strong> 天
                    <p>
                        以下是本管的一个简要介绍
                    </p>
                </div>
            </div>
        </div>
        <div class="blank"></div>
    </div>
    <div class="white-bg">
        <div class="row">
            <div class="col-md-9 mb20">
                <div class="person-list">
                    <div class="sline-box person-b">
                        <ul class="nav nav-tabs sline" role="tablist" style="width: 0px;">
                        </ul>
                    </div>
                </div>
                <div class="box">
                    <div class="bg-title">
                        <div class="pull-left">
                            <a class="bg-tit" href="<?=Url::toRoute(['/memorial/home/hall/life', 'id'=>$memorial->id])?>">生平简介</a>
                        </div>
                        <div class="pull-right"><a href="<?=Url::toRoute(['/memorial/home/hall/life', 'id'=>$memorial->id])?>">详细内容&gt;&gt;</a></div>
                    </div>
                    <div class="clear"></div>
                    <div class="about-index">
                        <?php foreach ($deads as $v):
                            if ($v->desc):
                            ?>
                        <strong><?=$v->dead_name?></strong>
                        <div>
                            <?=$v->desc?>
                        </div>
                        <?php endif;endforeach;?>
                    </div>
                </div>

                <div class="blank"></div>
                <div class="box">
                    <div class="bg-title">
                        <div class="pull-left"><a class="bg-tit" href="http://www.5201000.com/Memorial/ArticleList/69.html">档案资料</a></div>
                        <div class="pull-right"><a href="http://www.5201000.com/Memorial/ArticleList/69.html">更多内容&gt;&gt;</a></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="about-index da-info">
                        <ul class="list-unstyled" id="Opusli">
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i568605.html">• 《最后的岁月》</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                            hu
                                        </a>
                                    </h6>
                                    <span>时间：2010年09月26日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        　　孙中山最后岁月　　新华报业网讯 1925年3月12日，一场基督徒式的葬礼在协和大礼堂举行，这是早年是一名外科医生后来成为革命家的孙中山的葬礼。孙中山生命最后两个月的大部分时间，是在协和度过的。1924年的最后一天，孙中山抱病来到北京，连日来不断加重的肝病，让他都已无力宣读那300字的入京宣言。此后，有人建议他到东郊民巷的德国医院去，他说：东郊民巷是租界，我不去。并最终选择了协和医院。
                                        　　1
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i568601.html">• 各省联军解放南京</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                            hu
                                        </a>
                                    </h6>
                                    <span>时间：2010年09月26日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        　　各省联军解放南京
                                        　　1911年10月10日，武昌起义的消息传到江苏后，清政府属下新军官兵及广大民众群情振奋，纷纷响应，短短20多天，上海、苏州、无锡、镇江、淮阴等地迅速宣告解放，南京孤悬于东南一隅。
                                        　　对于南京这个兵家必争之地，革命军与清政府，一方认为志在必得，一方认为志在必守，南京又一次被推到了历史的风口浪尖上。
                                        　　11月上旬，同盟会通电已光复的各省火速派兵增援，组成江浙联军。只
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i568598.html">• 中山陵</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                            hu
                                        </a>
                                    </h6>
                                    <span>时间：2010年01月09日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        中山陵位于南京东郊钟山风景区内。作为伟大的民主革命先驱孙中山先生的墓地，它以凝重的历史意义、极高的文化价值和优美的园林景致在海内外享有盛誉，成为海内外华人竞相瞻仰的地方。
                                        １９２５年３月１２日，孙中山在北京病逝。遵照先生生前归葬南京东郊钟山之遗愿，南京国民政府决定建造中山陵。１９２９年春，陵墓主体工程完工，同年６月１日举行了隆重的奉安大典。
                                        中山陵位于紫金山南麓，前临平川，后依青山，气象
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i568597.html">• 孙中山的三份遗嘱</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                            hu
                                        </a>
                                    </h6>
                                    <span>时间：2010年01月09日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        孙中山先生临终前十七天,即１９２５年２月２４日,知道自己病已不治，预立了三份遗嘱，这三份遗嘱是《遗嘱》、《家事遗嘱》、和《致苏联遗书》。前两份遗嘱由孙中山口授，汪精卫笔录。《致苏联遗书》则是由孙中山以英语口授，他的苏联顾问鲍罗廷等笔录。孙中山口授遗嘱时，在场的宋子文、孙科、孔祥熙、邵元冲、吴敬恒、戴恩赛、何香凝、邹鲁、戴季陶等人都作为证明人在遗嘱上签了字。孙中山本来也要签字的，但是，因为听见宋庆龄
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="blank"></div>
                <div class="box">
                    <div class="bg-title">
                        <div class="pull-left"><a class="bg-tit" href="http://www.5201000.com/Memorial/ReList/69.html">追思文章</a></div>
                        <div class="pull-right"><a href="http://www.5201000.com/Memorial/ReList/69.html">更多内容&gt;&gt;</a></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="about-index da-info">
                        <ul class="list-unstyled" id="ArticleLi">
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i627002.html">• 向中山先生致敬!!</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                            pan.conan@gmail.com
                                        </a>
                                    </h6>
                                    <span>时间：2017年06月21日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        偉大的中山先生，我們向您致敬!
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i568658.html">• 祝福</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=540675" href="javascript:void(0)">
                                            蒙哥
                                        </a>
                                    </h6>
                                    <span>时间：2015年11月21日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>

                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i568657.html">• 新闻社会娱乐军事大连枪杀1男1</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=587800" href="javascript:void(0)">
                                            蝙蝠
                                        </a>
                                    </h6>
                                    <span>时间：2015年07月24日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        新闻
                                        社会
                                        娱乐
                                        军事
                                        大连枪杀1男1女嫌犯被抓获(图)
                                        人社部：大部分省份公务员涨工资
                                        男子实名举报妻子遭村官多次强奸
                                        NASA宣布发现 另一个地球 (图)
                                        辞职看世界教师：丈夫就是我世界
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i568656.html">• 孙中山先生你好</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=591689" href="javascript:void(0)">
                                            zwmseo
                                        </a>
                                    </h6>
                                    <span>时间：2015年04月27日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        孙中山先生你好
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="wz-bt-index">
                                    <h5><a href="http://www.5201000.com/Memorial/ReView/69i568655.html">• 伟大革命先行者</a></h5>
                                    <h6>
                                        发布人：
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=612488" href="javascript:void(0)">
                                            521孙钰紫
                                        </a>
                                    </h6>
                                    <span>时间：2014年04月07日</span>
                                </div>
                                <div class="wz-br-index">
                                    <div>
                                        推翻帝制，使民主共和深入人心
                                        为中国的发展提出了宏大的蓝图，孙中山一心要建设中国，希望把中国建设成为政治修明，人民安乐，为民所有，为民所治，为民所享的共和民主富强康乐国家。他为中国民族自由、政治民主、人民幸福，致力革命，尽瘁一生。虽然遇到袁世凯篡权，军阀混战，陈炯明及蒋介石先后叛变，使孙中山的建设设想和计划，未能实现，但是，中国人民追求未来美好的生活，建设中国美好的愿望，始终未衰。多少志士仁
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="blank"></div>
                <div class="box">
                    <div class="bg-title">
                        <div class="pull-left"><a class="bg-tit" href="http://www.5201000.com/Memorial/RemarkIndex/69.html">祝福留言</a></div>
                        <div class="pull-right"><a href="http://www.5201000.com/Memorial/RemarkIndex/69.html">更多内容&gt;&gt;</a></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="about-index da-info">
                        <ul id="Commentli" class="list-unstyled">
                            <li>
                                <div class="ttxx-inde-pic">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                        <img class="img-responsive" src="static/images/Member.jpg">
                                    </a>
                                    <p>
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                            153*****363
                                        </a>
                                    </p>
                                </div>
                                <div class="ttxx-index-a">
                                    <div><p><img src="static/images/p33.png" data-num="1"></p></div>
                                    <div><br></div>
                                    <div><span>写信时间：2017/06/29 08:48:21 </span></div>
                                </div>
                            </li>
                            <li>
                                <div class="ttxx-inde-pic">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                        <img class="img-responsive" src="static/images/Member.jpg">
                                    </a>
                                    <p>
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                            153*****363
                                        </a>
                                    </p>
                                </div>
                                <div class="ttxx-index-a">
                                    <div><p><img src="static/images/p55.png" data-num="1"></p></div>
                                    <div><br></div>
                                    <div><span>写信时间：2017/06/29 08:48:06 </span></div>
                                </div>
                            </li>
                            <li>
                                <div class="ttxx-inde-pic">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                        <img class="img-responsive" src="static/images/Member.jpg">
                                    </a>
                                    <p>
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                            153*****363
                                        </a>
                                    </p>
                                </div>
                                <div class="ttxx-index-a">
                                    <div><p>致敬<img src="static/images/p22.png"></p></div>
                                    <div><br></div>
                                    <div><span>写信时间：2017/06/29 08:41:29 </span></div>
                                </div>
                            </li>
                            <li>
                                <div class="ttxx-inde-pic">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                        <img class="img-responsive" src="static/images/Member.jpg">
                                    </a>
                                    <p>
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                            pan.conan@gmail.com
                                        </a>
                                    </p>
                                </div>
                                <div class="ttxx-index-a">
                                    <div><p>中山先生，謝謝您為了民主奮鬥！<img src="static/images/p22.png"></p></div>
                                    <div><br></div>
                                    <div><span>写信时间：2017/06/21 23:43:31 </span></div>
                                </div>
                            </li>
                            <li>
                                <div class="ttxx-inde-pic">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=574281" href="javascript:void(0)">
                                        <img class="img-responsive" src="static/images/479f3a8113404ed4a1751829947f4a20.jpg">
                                    </a>
                                    <p>
                                        <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=574281" href="javascript:void(0)">
                                            柏名
                                        </a>
                                    </p>
                                </div>
                                <div class="ttxx-index-a">
                                    <div><p><img src="static/images/p33.png" data-num="9"></p></div>
                                    <div><br></div>
                                    <div><span>写信时间：2017/04/04 10:53:12 </span></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <!---------------右侧内容开始------------------>
            <div class="col-md-3 no-padding-left mb20">

                <div class="box">
                    <div class="side-title">
                        微信扫一扫“码”上纪念 孙中山
                    </div>
                    <div style="text-align:center" class="side-tips">
        <span>
            <img src="static/images/Generate">
        </span>
                    </div>
                </div>

                <br>
                <div class="box">
                    <div class="side-title"><a class="tit" href="javascript:void(0)">祭奠记录</a><a class="more" href="http://www.5201000.com/Memorial/SLList/1/1/69.html">更多祭奠记录&gt;&gt;</a></div>
                    <div class="scoll-up">
                        <ul class="list-unstyled">
                            <li class="">
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=581180" href="javascript:void(0)">狄国老</a>
                                    敬献了普通香
                                </p>
                                <span>敬献时间：2017-01-07 01:52</span>
                            </li><li class="">
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886146" href="javascript:void(0)">151*****097</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2016-12-21 02:11</span>
                            </li><li class="">
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=885951" href="javascript:void(0)">157*****658</a>
                                    敬献了烧钱
                                </p>
                                <span>敬献时间：2016-12-07 09:36</span>
                            </li><li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889268" href="javascript:void(0)">150*****463</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-04-21 05:25</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889268" href="javascript:void(0)">150*****463</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-04-21 05:22</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=576390" href="javascript:void(0)">波斯猫</a>
                                    敬献了烧钱
                                </p>
                                <span>敬献时间：2017-04-01 06:47</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=576390" href="javascript:void(0)">波斯猫</a>
                                    敬献了西瓜
                                </p>
                                <span>敬献时间：2017-04-01 06:46</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=887182" href="javascript:void(0)">455177522@qq.com</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-02-28 08:51</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=887182" href="javascript:void(0)">455177522@qq.com</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-02-28 08:51</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886926" href="javascript:void(0)">158*****605</a>
                                    敬献了野果
                                </p>
                                <span>敬献时间：2017-02-08 04:14</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886926" href="javascript:void(0)">158*****605</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-02-08 04:13</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886925" href="javascript:void(0)">186*****857</a>
                                    敬献了野果
                                </p>
                                <span>敬献时间：2017-02-08 02:59</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886925" href="javascript:void(0)">186*****857</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-02-08 02:54</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=885951" href="javascript:void(0)">157*****658</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-01-18 06:10</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886500" href="javascript:void(0)">182*****955</a>
                                    敬献了圣经
                                </p>
                                <span>敬献时间：2017-01-12 02:10</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=886500" href="javascript:void(0)">182*****955</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-01-12 02:08</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=885951" href="javascript:void(0)">157*****658</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-01-11 11:55</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=885951" href="javascript:void(0)">157*****658</a>
                                    敬献了白蜡烛
                                </p>
                                <span>敬献时间：2017-01-11 11:40</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=581180" href="javascript:void(0)">狄国老</a>
                                    敬献了花圈
                                </p>
                                <span>敬献时间：2017-01-07 01:53</span>
                            </li>
                            <li>
                                <p>
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=581180" href="javascript:void(0)">狄国老</a>
                                    敬献了花圈
                                </p>
                                <span>敬献时间：2017-01-07 01:53</span>
                            </li>



                        </ul>
                    </div>
                    <div class="side-tips">
                    <span>
                        温馨提示：请为您已经逝去的亲朋好友点一柱香
                        献一束花，让他们在天堂永不孤单。
                    </span>
                    </div>
                </div>
                <br>


                <link href="static/css/owl.carousel.css" rel="stylesheet" type="text/css">
                <link href="static/css/owl.theme.css" rel="stylesheet">
                <link href="static/css/owl.transitions.css" rel="stylesheet" type="text/css">
                <div class="box">
                    <div class="side-title">
                        <a class="tit" href="http://www.5201000.com/Memorial/AlbumList/69.html">音容笑貌</a>
                        <a class="more" href="http://www.5201000.com/Memorial/AlbumList/69.html">更多&gt;&gt;</a>
                    </div>
                    <div class="photo">
                        <div id="owl-img" class="owl-carousel owl-theme" style="opacity: 1; display: block;">
                            <div class="owl-wrapper-outer autoHeight" style="height: 127px;">
                                <div class="owl-wrapper" style="width: 5302px; left: 0px; display: block; transition: all 0ms ease; transform: translate3d(-1446px, 0px, 0px); transform-origin: 1566.5px center 0px; perspective-origin: 1566.5px center;">
                                    <div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/100109092055208.jpg" height="166" width="118">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115193707015.jpg" height="200" width="249">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115193617125.jpg" height="186" width="250">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115193141687.jpg" height="130" width="250">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115193000734.jpg" height="200" width="175">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192901359.jpg" height="145" width="250">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192638625.jpg" height="127" width="133">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192433265.jpg" height="187" width="250">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192316828.jpg" height="200" width="166">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091115192225234.jpg" height="200" width="152">
                                        </div></div><div class="owl-item" style="width: 241px;"><div>
                                            <img onload="AutoResizeImage(250, 200, this)" src="static/images/091112223318312.jpg" height="200" width="134">
                                        </div></div></div></div>

                            <div class="owl-controls clickable"><div class="owl-buttons"><div class="owl-prev">上一张</div><div class="owl-next">下一张</div></div></div></div>


                    </div>
                </div>
                <script src="static/js/owl.carousel.js"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        setTimeout(function () {
                            $("#owl-img").owlCarousel({
                                autoPlay: 3000,
                                stopOnHover: true,
                                navigation: true,
                                paginationSpeed: 1000,
                                goToFirstSpeed: 2000,
                                singleItem: true,
                                autoHeight: true,
                                transitionStyle: "fadeUp",
                                navigationText: ["上一张", "下一张"],
                                lazyLoad: true,
                                pagination: false
                            });
                        }, 100)
                    });
                </script>


                <div class="blank"></div>
                <div class="box">
                    <form action="http://www.5201000.com/Search" method="get">
                        <div class="side-title">
                            <a class="tit" href="javascript:void(0)">搜索纪念馆</a>
                            <a class="more" href="http://www.5201000.com/Search">高级搜索</a>
                        </div>
                        <input name="keyword" class="form-control" type="text">
                        <button class="tt-btn tt-btn-default"><i class="smIcon search"></i> 搜索</button>
                    </form>
                </div>
                <div class="blank"></div>
                <div class="box">
                    <div class="side-title">
                        <a class="tit" href="javascript:void(0)">亲友纪念馆</a>

                    </div>
                    <div class="side-login"><p>您还未<a href="javascript:void(0)">登录</a> ，登录后可添加亲友纪念馆！</p></div>
                </div>
                <div class="blank"></div>
                <div class="col-md-12">
                    <div class="row">
                        <a href="http://www.5201000.com/MemberCenter/Memorial/Add"><img class="img-responsive" src="static/images/right-avd.gif" alt="免费创建纪念馆"></a>
                    </div>
                </div>
                <div class="blank"></div>
                <div class="box">
                    <div class="side-title"><a class="tit" href="javascript:void(0)">到过这里的访客</a><a class="more" href="javascript:void(0)">更多&gt;&gt;</a></div>
                    <div class="xp-huiyuan">
                        <ul>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889768" href="javascript:void(0)">
                                    <img width="73" height="83" alt="344803800@qq.com" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889768" href="javascript:void(0)">
                                        344803800@qq.com
                                    </a>
                                </p>
                                <span>07月15日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                    <img width="73" height="83" alt="153*****363" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                        153*****363
                                    </a>
                                </p>
                                <span>07月11日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890159" href="javascript:void(0)">
                                    <img width="73" height="83" alt="180*****805" src="static/images/20170704180312.JPG">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890159" href="javascript:void(0)">
                                        180*****805
                                    </a>
                                </p>
                                <span>07月04日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889981" href="javascript:void(0)">
                                    <img width="73" height="83" alt="565853277@qq.com" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889981" href="javascript:void(0)">
                                        565853277@qq.com
                                    </a>
                                </p>
                                <span>06月25日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                    <img width="73" height="83" alt="pan.conan@gmail.com" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                        pan.conan@gmail.com
                                    </a>
                                </p>
                                <span>06月21日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890009" href="javascript:void(0)">
                                    <img width="73" height="83" alt="Bluebaryamy@gmail.com" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890009" href="javascript:void(0)">
                                        Bluebaryamy@gmail.com
                                    </a>
                                </p>
                                <span>06月21日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889992" href="javascript:void(0)">
                                    <img width="73" height="83" alt="a0024a1@yacons.com.tw" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889992" href="javascript:void(0)">
                                        a0024a1@yacons.com.tw
                                    </a>
                                </p>
                                <span>06月21日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=542979" href="javascript:void(0)">
                                    <img width="73" height="83" alt="李赴朝" src="static/images/20170413051559.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=542979" href="javascript:void(0)">
                                        李赴朝
                                    </a>
                                </p>
                                <span>06月18日</span>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=611876" href="javascript:void(0)">
                                    <img width="73" height="83" alt="刘" src="static/images/Member.jpg">
                                </a>
                                <p class="ellipsis">
                                    <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=611876" href="javascript:void(0)">
                                        刘
                                    </a>
                                </p>
                                <span>06月17日</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!---------------右侧内容结束------------------>
        </div>
    </div>
</div>