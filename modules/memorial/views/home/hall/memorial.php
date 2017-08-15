<?php
$this->params['current_nav'] = 'memorial';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/memorial/ink/ink.css');
?>
<div class="container memorial-container">

    <div class="col-md-12">
        <div id="memorial-person" class="clearfix">
            <div class="row">
                <div class="col-md-3 memorial-avatar">
                    <div class="avatar-box">
                        <img src="<?=$memorial->getThumbImg('149x116')?>" alt="">
                    </div>
                    <div class="info">
                        <a title="关注该纪念馆" data-status=1 class="">关注该馆</a>
                    </div>
                </div>
                <div class="col-md-5">
                    <dl class="memorial-info">
                        <dt class="memorial-title">
                            卓迅纪念馆
                        </dt>
                        <dd>
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        <b>
                                            母亲：
                                        </b>
                                        <span class="fyh20">尹霞</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>生于：</b>1954年 9月 6日<b> 卒于：</b>2012年 11月 21日 <b>享年：</b>58岁
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>籍贯：</b>辽宁省 沈阳市
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>生平：</b>暂无
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-condensed">
                                <tr>
                                    <td>
                                        <b>
                                            母亲：
                                        </b>
                                        <span class="fyh20">尹霞</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>生于：</b>1954年 9月 6日<b> 卒于：</b>2012年 11月 21日 <b>享年：</b>58岁
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>籍贯：</b>辽宁省 沈阳市
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>生平：</b>暂无
                                    </td>
                                </tr>
                            </table>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <div class="memorial_time">
                        <div class="det clearfix">
                            <p class="first">所属墓位：传承园传爱区2排13号</p>
                            <p>访问次数：36</p>
                            <div class="count">
                                <div class="inner">
                                    <table cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td class="txt">距离<span class="size">尹霞</span>生日还有</td>
                                            <td class="count_det">0</td>
                                            <td class="count_det">8</td>
                                            <td class="count_det">7</td>
                                            <td class="day">天</td>
                                        </tr>
                                        <tr>
                                            <td class="txt">距离<span class="size">尹霞</span>福日还有</td>
                                            <td class="count_det">1</td>
                                            <td class="count_det">4</td>
                                            <td class="count_det">0</td>
                                            <td class="day">天</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="row memorial-goods">
                <div class="col-md-2">
                    <div class="gbox">
                        <img src="<?=$mem[1]?>/memorial/common/images/ink_flower.png" alt="">
                        <p>可可 赠</p>
                        <a href="" class="btn btn-default btn-xs">进入观看视频</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="gbox">
                        <img src="<?=$mem[1]?>/memorial/common/images/ink_flower.png" alt="">
                        <p>可可 赠</p>
                        <a href="" class="btn btn-default btn-xs">进入观看视频</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="gbox">
                        <img src="<?=$mem[1]?>/memorial/common/images/ink_flower.png" alt="">
                        <p>可可 赠</p>
                        <a href="" class="btn btn-default btn-xs">进入观看视频</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="gbox">
                        <img src="<?=$mem[1]?>/memorial/common/images/ink_flower.png" alt="">
                        <p>可可 赠</p>
                        <a href="" class="btn btn-default btn-xs">进入观看视频</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="gbox">
                        <img src="<?=$mem[1]?>/memorial/common/images/ink_flower.png" alt="">
                        <p>可可 赠</p>
                        <a href="" class="btn btn-default btn-xs">进入观看视频</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="gbox">
                        <img src="<?=$mem[1]?>/memorial/common/images/ink_flower.png" alt="">
                        <p>可可 赠</p>
                        <a href="" class="btn btn-default btn-xs">进入观看视频</a>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top:30px">
                <div class="col-md-12">
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-default">献花</button>
                        <button type="button" class="btn btn-default">上香</button>
                        <button type="button" class="btn btn-default">点烛</button>
                        <button type="button" class="btn btn-default">祭品</button>
                        <button type="button" class="btn btn-default">扫墓</button>
                        <button type="button" class="btn btn-default">怀念文集</button>
                        <button type="button" class="btn btn-primary btn-goods">购买商品</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="op-box">

            <div class="row">
                <div class="col-md-12">
                    <div class="wish-msg" >
                        <div id="wish-msgbox" class="module-memorial">
                            <form action="/comment/save" method="post" id="main-comment-form" />
                            <input type="hidden" name="parent_id" value="0" />
                            <input type="hidden" name="user_id" value="0" />
                            <input type="hidden" name="res_name" value="memorial" />
                            <input type="hidden" name="res_id" value="5" />
                            <p><textarea name="content" id="comContent" class="sInput wide"></textarea></p>
                            <p class="submit-box" style="text-align:left;">
                                <button class="btn btn-default"> 送上祝福 </button>
                            </p>
                            </form>
                        </div>
                        <div id="commentList">
                            <ol class="leave-msglist comList" id="comment-box">
                                <li style="display:none;"></li>
                                <li class="clearfix aComment new" style="display:list-item" data-id="">
                                    <a rel="avatar-a" href="/profile/5340.html" target="_blank" class="pull-left avatar">
                                        <img rel="avatar" alt="头像" src="http://www.yagm.com.cn/upload/2016/01/29/small_20160129112329000000_1_32874_36.jpg">
                                    </a>
                                    <div class="leave-msgbody" data-user_id="5340" data-id="1419607">
                                        <h6>
                <span class="ip pull-right">
                    <span rel="time" class="time">2014-10-28 11:47:47</span>
                    <a rel="ip" href="javascript:return false;" title="125.39.31.* 天津市联通"><img src="./static/images/ip_ink.png"></a>
                                        </span>
                                            <!-- -- user ---->
                                            <span>
                      <a class="green" rel="username" href="/profile/5340.html" target="_blank">王玮</a>
                  </span>说：

                                            <!-- user -->
                                        </h6>

                                        <div rel="content" class="leave-msgcontent main-comment-content">
                                            可爱的小丫丫,愿你安好,你的家人安康....                              </div>
                                        <div class="leave-replay leaveReplay" data-parent_id="1419607">
                                            <a rel="replay" href="#" class="repaly-btns replyBtns">回复</a>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        <div class="commPager" class="pull-right">
                        </div>
                        <div style="clear:both;margin-bottom:10px"></div>
                    </div>
                </div>
            </div>

            <div class="row">

            </div>
        </div>

    </div>
    <style type="text/css">
        div.pray-b p.time{text-align:left;}
    </style>
    <div class="clear"></div>
</div>