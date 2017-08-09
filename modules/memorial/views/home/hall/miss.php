<?php
$this->params['current_nav'] = 'miss';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/relist.css');
?>
<div class="container memorial-container">
    <div class="row">
        <!---------------左边开始----------------->
        <div class="col-md-3 hidden-sm no-padding-right mb20">

            <div class="person-list">
                <div class="sline-box person-info">

                    <ul class="nav nav-tabs sline" role="tablist">

                    </ul>
                </div>
            </div>
            <div class="box">
                <div class="tab-content person-content" id="person_left">
                    <div class="tab-pane fade  in active   ps_533577">
                        <form id="formDeceased533577" action="/BaseMemorial/EditHeadImg" onsubmit="return false;">
                            <p>
                                <img id="PhotoHead_533577" name="PhotoHead_533577" class="img-responsive img-rounded center-block"
                                     src="http://imgs.5201000.com/UploadFiles/Image/Heaven/MemorialHall/PhotoPath/091112222633484.jpg"
                                     alt="孙中山" />

                            </p>
                            <div class="blank"></div>
                            <div class="blank"></div>
                            <div class="ny-ren-xx">
                                <ul class="list-unstyled">

                                    <li><span>姓名：</span>孙中山</li>
                                    <li><span>生辰：</span>1866年11月12日</li>
                                    <li><span>忌辰：</span>1925年03月12日</li>
                                    <li>
                                        <span>天堂纪念馆号：</span><strong style="color:#F60; font-size:16px;">TT000000069</strong>
                                    </li>
                                    <li><span>已经离开我们：</span><strong>33735</strong>天</li>
                                    <li>
                                        <span>建馆者：</span>
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                            hu
                                        </a>
                                    </li>
                                    <li><span>建馆时间：</span>2009年11月12日</li>
                                    <li><span>点击数：</span>638586次</li>
                                </ul>
                            </div>
                            <input type="hidden" name="Id" value="533577" />
                            <input type="hidden" name="PhotoPath" value="" />
                        </form>
                    </div>

                </div>
            </div>

            <div class="blank"></div>

            <div class="box">
                <div  class="side-title">
                    微信扫一扫“码”上纪念 孙中山
                </div>
                <div style="text-align:center" class="side-tips">
        <span>
            <img src="/Generate?id=69" />
        </span>
                </div>
            </div>

            <div class="blank"></div>


            <div class="box">
                <div class="side-title"><a class="tit" href="#">我要祭奠</a><a class="more" href="#">点一柱香、献一束花、敬一杯酒</a></div>
                <div class="row hold-box">
                    <div class="col-md-3">
                        <a href="/M/TT000000069" class="holdIcon a"></a>
                        <a href="/M/TT000000069">我要献花</a>

                    </div>
                    <div class="col-md-3">
                        <a href="/M/TT000000069" class="holdIcon f"></a>
                        <a href="/M/TT000000069">我要点烛</a>

                    </div>
                    <div class="col-md-3">
                        <a href="/M/TT000000069" class="holdIcon b"></a>
                        <a href="/M/TT000000069">我要上香</a>

                    </div>
                    <div class="col-md-3">
                        <a href="/M/TT000000069" class="holdIcon d"></a>
                        <a href="/M/TT000000069">我要摆供</a>

                    </div>
                </div>
                <div class="row hold-box">
                    <div class="col-md-3">
                        <a href="/M/TT000000069" class="holdIcon c"></a>
                        <a href="/M/TT000000069">我要祭酒</a>

                    </div>
                    <div class="col-md-3">
                        <a href="" class="holdIcon e"></a>
                        <a href="">我要行礼</a>

                    </div>
                    <div class="col-md-3">
                        <a href="/Memorial/RemarkIndex/69.html" class="holdIcon g"></a>
                        <a href="/Memorial/RemarkIndex/69.html">我要写信</a>

                    </div>
                    <div class="col-md-3">
                        <a href="/Memorial/ReList/69.html" class="holdIcon h"></a>
                        <a href="/Memorial/ReList/69.html">发表祭文</a>

                    </div>
                </div>
            </div>
            <div class="blank"></div>


            <link href="/Resource/Scripts/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css">
            <link href="/Resource/Scripts/plugins/owl-carousel/owl.theme.css" rel="stylesheet">
            <link href="/Resource/Scripts/plugins/owl-carousel/owl.transitions.css" rel="stylesheet" type="text/css">
            <div class="box">
                <div class="side-title">
                    <a class="tit" href="/Memorial/AlbumList/69.html">音容笑貌</a>
                    <a class="more" href="/Memorial/AlbumList/69.html">更多>></a>
                </div>
                <div class="photo">
                    <div id="owl-img" class="owl-carousel">
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/100109092055208.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115193707015.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115193617125.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115193141687.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115193000734.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115192901359.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115192638625.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115192433265.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115192316828.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115192225234.jpg">
                        </div>
                        <div>
                            <img onload="AutoResizeImage(250, 200, this)" src="http://imgs.5201000.com/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091112223318312.jpg">
                        </div>

                    </div>


                </div>
            </div>
            <script src="/Resource/Scripts/plugins/owl-carousel/owl.carousel.js"></script>
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
                <form action="/Search" method="get">
                    <div class="side-title"><a class="tit" href="#">搜索纪念馆</a><a class="more" href="/Search">高级搜索</a></div>
                    <input name="keyword" class="form-control" type="text" />
                    <button class="tt-btn tt-btn-default"><i class="smIcon search"></i> 搜索</button>
                </form>
            </div>
            <div class="blank"></div>
            <div class="col-md-12">
                <div class="row">
                    <a href="/MemberCenter/Memorial/Add"><img class="img-responsive center-block" src="../../../../resource/images/memorials/right-avd.gif" alt="免费创建纪念馆" /></a>
                </div>
            </div>
            <div class="blank"></div>


            <div class="box">
                <div class="side-title"><a class="tit" href="#">到过这里的访客</a><a class="more" href="#">更多>></a></div>
                <div class="xp-huiyuan">
                    <ul>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=889768" href="javascript:void(0)">
                                <img width="73" height="83" alt="344803800@qq.com" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="344803800@qq.com" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=889768" href="javascript:void(0)">344803800@qq.com</a>
                            </p>
                            <span>07月17日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                <img width="73" height="83" alt="153*****363" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="153*****363" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=890058" href="javascript:void(0)">153*****363</a>
                            </p>
                            <span>07月11日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=890159" href="javascript:void(0)">
                                <img width="73" height="83" alt="180*****805" src="http://imgs.5201000.com/UploadFiles/Image/2017/7/4/Heaven/Member/HeadPic/20170704180312.JPG">
                            </a>
                            <p class="ellipsis">
                                <a title="180*****805" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=890159" href="javascript:void(0)">180*****805</a>
                            </p>
                            <span>07月04日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=889981" href="javascript:void(0)">
                                <img width="73" height="83" alt="565853277@qq.com" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="565853277@qq.com" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=889981" href="javascript:void(0)">565853277@qq.com</a>
                            </p>
                            <span>06月25日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                <img width="73" height="83" alt="pan.conan@gmail.com" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="pan.conan@gmail.com" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=890013" href="javascript:void(0)">pan.conan@gmail.com</a>
                            </p>
                            <span>06月21日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=890009" href="javascript:void(0)">
                                <img width="73" height="83" alt="Bluebaryamy@gmail.com" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="Bluebaryamy@gmail.com" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=890009" href="javascript:void(0)">Bluebaryamy@gmail.com</a>
                            </p>
                            <span>06月21日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=889992" href="javascript:void(0)">
                                <img width="73" height="83" alt="a0024a1@yacons.com.tw" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="a0024a1@yacons.com.tw" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=889992" href="javascript:void(0)">a0024a1@yacons.com.tw</a>
                            </p>
                            <span>06月21日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=542979" href="javascript:void(0)">
                                <img width="73" height="83" alt="李赴朝" src="http://imgs.5201000.com/UploadFiles/Image/2017/4/13/Heaven/Member/HeadPic/20170413051559.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="李赴朝" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=542979" href="javascript:void(0)">李赴朝</a>
                            </p>
                            <span>06月18日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog"
                               data-url="/MemberInfo?id=611876" href="javascript:void(0)">
                                <img width="73" height="83" alt="刘" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="刘" data-toggle="modal" data-target=".user-info-dialog"
                                   data-url="/MemberInfo?id=611876" href="javascript:void(0)">刘</a>
                            </p>
                            <span>06月17日</span>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
        <!---------------左边结束----------------->
        <!---------------右边开始----------------->
        <div class="col-md-9 mb20">
            <div class="box">
                <div class="row page-nav">
                    <ul class="list-unstyled">
                        <li class="active"><a href="/Memorial/ReList/69.html">追忆文章</a></li>
                        <li class="pull-right">
                            <div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="blank"></div>
                <div id="ArticlePage">

                    <div class="main-page">

                        <style type="text/css">
                            .PaginationMain {
                                float: left;
                                text-align: center;
                                /*margin:20px auto;*/
                            }

                            .PaginationMain .Jump {
                                width: 40px;
                                height: 30px;
                                text-align: center;
                                background-color: #fff;
                                background-image: none;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
                                color: #555;
                                font-size: 14px;
                            }

                            .PaginationMain button {
                                margin: -5px 0 0 0;
                            }
                        </style>

                        <div class="memorials-pager">
                            <div style="float:left ">
                                <ul class="pagination pagination-sm m-t-none m-b-none">

                                    <li class="disabled"><a aria-label="Previous" href="javascript:void(0)"><span aria-hidden="true">首页</span></a></li>
                                    <li class="disabled"><a aria-label="Previous" href="javascript:void(0)"><span aria-hidden="true">«上一页</span></a></li>
                                    <li class="active"><a href="javascript:void(0)">1</a></li>
                                    <li>
                                        <a href="/Memorial/ReList/69P2.html">2</a>
                                    </li>
                                    <li>
                                        <a href="/Memorial/ReList/69P3.html">3</a>
                                    </li>
                                    <li>
                                        <a href="/Memorial/ReList/69P4.html">4</a>
                                    </li>
                                    <li>
                                        <a href="/Memorial/ReList/69P5.html">5</a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" href="/Memorial/ReList/69P2.html"><span aria-hidden="true">下一页»</span></a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" href="/Memorial/ReList/69P5.html"><span aria-hidden="true">尾页</span></a>
                                    </li>
                                </ul>
                            </div>
                            <form class="PaginationMain" islocation="true" method="get" id="form35" onsubmit="return false">
                                <div>
                                    &nbsp;
                                    <span style="display:inline-block">共5页,到第</span>
                                    <input class="Jump" name="PageIndex" type="text" value="1" />页&nbsp;
                                    <input name="Keyword" type="hidden" />
                                    <input name="Sort" type="hidden" value="" />
                                    <input name="Order" type="hidden" value="" />
                                    <button class="btn btn-default btn-sm" onclick="GetSubmitUrl(&#39;form35&#39;)" type="submit">确定</button>
                                </div>
                            </form>
                        </div>


                        <script type="text/javascript">
                            var backdropLoading = {
                                create: function (ele) {
                                    var html = '<div class="backdropLoading" style="background-color:#000;background-color:rgba(0,0,0,.6);width:100%;height:100%;position:absolute;left:0;top:0;z-index:99999;">'
                                        + '<div style="position:absolute;top:10px;left:0;color:#fff;font-size:18px;width:100%;text-align:center;">正在加载中...</div>'
                                        + '<div style="position:absolute;bottom:10px;left:0;color:#fff;font-size:18px;width:100%;text-align:center;">正在加载中...</div></div>';
                                    ele = ele ? ele : 'body';
                                    $(ele).css({ 'position': 'relative' }).append(html);
                                },
                                remove: function (ele) {
                                    ele = ele ? ele : 'body';
                                    $('.backdropLoading', ele).remove();
                                }
                            };

                            function GetSubmitUrl(formIdName) {
                                var form = $("#" + formIdName);
                                var PageUrlRule = "/Memorial/ReList/69P{PageIndex}.html";
                                if (PageUrlRule != "") {
                                    PageUrlRule = PageUrlRule.replace("{PageIndex}", form.find("[name=PageIndex]").val());
                                    location.href = PageUrlRule;
                                }
                            }

                            function GetAjaxData(url) {
                                $.ajax({
                                    type: "get",
                                    url: url + "&_r=" + Math.random() * new Date().getTime(),
                                    beforeSend: function () {
                                        if ("" == "") {
                                            backdropLoading.create()
                                        }
                                        else {
                                            backdropLoading.create('#');
                                        }
                                    },
                                    success: function (data) {
                                        $("#").html(data);

                                        if ("" == "") {
                                            backdropLoading.remove()
                                        }
                                        else {
                                            backdropLoading.remove('#');
                                        }

                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
                                        if ("" == "") {
                                            backdropLoading.remove()
                                        }
                                        else {
                                            backdropLoading.remove('#');
                                        }
                                    }
                                })
                            }
                        </script>
                    </div>
                    <div class="blank"></div>
                    <div class="line"></div>
                    <div class="blank"></div>
                    <!---------------内容开始----------------->
                    <div class="news-list">
                        <ul>
                            <li>
                                <h4><a href="/Memorial/ReView/69i627002.html">向中山先生致敬!!</a></h4>
                                <div class="new-cont">
                                    偉大的中山先生，我們向您致敬!
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                                        pan.conan@gmail.com
                                                    </a>
                                            </span><span>
                                                阅读（362）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2017-06-21 23:05:10</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568658.html">祝福</a></h4>
                                <div class="new-cont">

                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=540675" href="javascript:void(0)">
                                                        蒙哥
                                                    </a>
                                            </span><span>
                                                阅读（2679）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2015-11-21 23:27:02</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568657.html">新闻社会娱乐军事大连枪杀1男1女嫌犯被抓获(图)人社部：大部分省份公务员涨工资男子实名举报妻子遭村官多次强奸NASA宣布发现“另一个地球”(图)辞职看世界教师：丈夫就是我世界</a></h4>
                                <div class="new-cont">
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
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=587800" href="javascript:void(0)">
                                                        蝙蝠
                                                    </a>
                                            </span><span>
                                                阅读（3631）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2015-07-24 17:19:59</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568656.html">孙中山先生你好</a></h4>
                                <div class="new-cont">
                                    孙中山先生你好
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=591689" href="javascript:void(0)">
                                                        zwmseo
                                                    </a>
                                            </span><span>
                                                阅读（3303）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2015-04-27 15:07:39</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568655.html">伟大革命先行者</a></h4>
                                <div class="new-cont">
                                    推翻帝制，使民主共和深入人心
                                    为中国的发展提出了宏大的蓝图，孙中山一心要建设中国，希望把中国建设成为政治修明，人民安乐，为民所有，为民所治，为民所享的共和民主富强康乐国家。他为中国民族自由、政治民主、人民幸福，致力革命，尽瘁一生。虽然遇到袁世凯篡权，军阀混战，陈炯明及蒋介石先后叛变，使孙中山的建设设想和计划，未能实现，但是，中国人民追求未来美好的生活，建设中国美好的愿望，始终未衰。多少志士仁
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=612488" href="javascript:void(0)">
                                                        521孙钰紫
                                                    </a>
                                            </span><span>
                                                阅读（4093）
                                            </span><span>
                                                评论（1次）
                                            </span><span>点赞（1次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2014-04-07 09:59:01</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568654.html">缅怀您先生</a></h4>
                                <div class="new-cont">

                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=544737" href="javascript:void(0)">
                                                        勇敢的活着
                                                    </a>
                                            </span><span>
                                                阅读（2562）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2014-03-26 15:09:30</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568653.html">1</a></h4>
                                <div class="new-cont">
                                    1
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=627413" href="javascript:void(0)">
                                                        智能倒
                                                    </a>
                                            </span><span>
                                                阅读（1815）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2013-11-18 19:20:53</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568652.html">追忆孙中山</a></h4>
                                <div class="new-cont">
                                    孙中山纪念馆解说员张万利介绍，现在大家所见的孙中山故居，是中山先生于1892年亲手设计督造并保存完好的一片住宅。故居正门贴有他当年手书的门联&mdash;&mdash; 一椽得所，五桂安居 ，虽过百年，但字迹殷红。
                                    　　孙中山，学名文，乳名帝象，字德明，号载之、公武、日新、逸仙，旅居日本时曾化名中山樵，故有 中山 之名。辛亥革命后，章士钊把中山这个名字加上姓，并称为孙中山。自此，这个姓名便在
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                                        hu
                                                    </a>
                                            </span><span>
                                                阅读（2199）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2013-04-06 20:40:12</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568651.html">我心目中的孙中山</a></h4>
                                <div class="new-cont">
                                    孙中山是一个十分令人尊重的人
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                                        hu
                                                    </a>
                                            </span><span>
                                                阅读（1733）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2013-04-03 21:52:15</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568650.html">投身民主的革命</a></h4>
                                <div class="new-cont">
                                    孙中山在1925年3月12日逝世前夕签署的遗嘱。包括《国事遗嘱》、《家事遗嘱》和《致苏俄遗书》三个文件。在国事遗嘱中，他总结了40年的革命经验，得出结论说： 必须唤起民众，及联合世界上以平等待我之民族，共同奋斗。 发出了 革命尚未成功，同志仍须努力 的号召，希望他的革命主张和革命主义能够得到实现。在家事遗嘱中，说明将遗下的书籍、衣物、住宅等留给宋庆龄作为纪念，要求子女们继承他的革命遗志。在致苏俄遗
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=648528" href="javascript:void(0)">
                                                        李坤
                                                    </a>
                                            </span><span>
                                                阅读（1080）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2013-04-03 18:20:21</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568649.html">在有</a></h4>
                                <div class="new-cont">
                                    555
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                                        hu
                                                    </a>
                                            </span><span>
                                                阅读（1130）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2013-03-27 17:13:41</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568648.html">纪念孙中山逝世88周年</a></h4>
                                <div class="new-cont">
                                    南都讯 记者刘倩 通讯员张跃 昨日上午，广东省、广州市各界人士在广州市中山纪念堂举行纪念我国伟大的民主革命先行者孙中山先生逝世88周年仪式。
                                    副省长刘志庚代表广东省、广州市人民政府，省政协副主席唐豪代表广东省、广州市政协，省委统战部副部长唐晓萍代表广东省、广州市委统战部，民革广东省委会副主委、广州市委会主委于欣伟代表广东省、广州市民革，分别向孙中山先生铜像敬献花篮。
                                    纪念仪式上，全体肃
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                                        hu
                                                    </a>
                                            </span><span>
                                                阅读（954）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2013-03-13 21:06:51</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568647.html">孙中山出生在夏威夷，是美国公民？</a></h4>
                                <div class="new-cont">
                                    孙中山伪称 1870年出生在夏威夷的Ewa 的自述证言（第一页）
                                    （广州大元帅府纪念馆供图）
                                    这次展览的很多内容，相信很多人都没见过，比如那张夏威夷出生证 ，孙中山的曾侄孙、73岁的孙必胜，站在广州大元帅府北楼走廊，倚在国父曾经靠过的栏杆旁，回忆往昔。
                                    昨日上午， 孙中山与美国 特展，在广州大元帅府纪念馆开幕。来自大西洋彼岸美国国家档案局的95张珍贵照片和21件复制文物，首次在中
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                                        hu
                                                    </a>
                                            </span><span>
                                                阅读（983）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2013-03-13 21:06:21</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568646.html">民主革命的先行者永远活在人民心中</a></h4>
                                <div class="new-cont">
                                    民主革命的先行者永远活在人民的心中。湖北武汉民主人士马军默哀！致敬！
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                                        hu
                                                    </a>
                                            </span><span>
                                                阅读（1112）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2012-11-29 14:01:51</span>
                                </div>
                            </li>
                            <li>
                                <h4><a href="/Memorial/ReView/69i568645.html">天堂纪念网</a></h4>
                                <div class="new-cont">
                                    天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网天堂纪念网
                                </div>
                                <div class="new-data">
                                            <span>
                                                发布人：
                                                    <a data-toggle="modal" data-target=".user-info-dialog"
                                                       data-url="/MemberInfo?id=632858" href="javascript:void(0)">
                                                        hu
                                                    </a>
                                            </span><span>
                                                阅读（961）
                                            </span><span>
                                                评论（0次）
                                            </span><span>点赞（0次）</span>
                                    <span>打赏（0个天堂币）</span>
                                    <span>发布时间:2012-11-28 13:23:09</span>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <!---------------内容结束----------------->

                    <div class="main-page">

                        <style type="text/css">
                            .PaginationMain {
                                float: left;
                                text-align: center;
                                /*margin:20px auto;*/
                            }

                            .PaginationMain .Jump {
                                width: 40px;
                                height: 30px;
                                text-align: center;
                                background-color: #fff;
                                background-image: none;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
                                color: #555;
                                font-size: 14px;
                            }

                            .PaginationMain button {
                                margin: -5px 0 0 0;
                            }
                        </style>

                        <div class="memorials-pager">
                            <div style="float:left ">
                                <ul class="pagination pagination-sm m-t-none m-b-none">

                                    <li class="disabled"><a aria-label="Previous" href="javascript:void(0)"><span aria-hidden="true">首页</span></a></li>
                                    <li class="disabled"><a aria-label="Previous" href="javascript:void(0)"><span aria-hidden="true">«上一页</span></a></li>
                                    <li class="active"><a href="javascript:void(0)">1</a></li>
                                    <li>
                                        <a href="/Memorial/ReList/69P2.html">2</a>
                                    </li>
                                    <li>
                                        <a href="/Memorial/ReList/69P3.html">3</a>
                                    </li>
                                    <li>
                                        <a href="/Memorial/ReList/69P4.html">4</a>
                                    </li>
                                    <li>
                                        <a href="/Memorial/ReList/69P5.html">5</a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" href="/Memorial/ReList/69P2.html"><span aria-hidden="true">下一页»</span></a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" href="/Memorial/ReList/69P5.html"><span aria-hidden="true">尾页</span></a>
                                    </li>
                                </ul>
                            </div>
                            <form class="PaginationMain" islocation="true" method="get" id="form19" onsubmit="return false">
                                <div>
                                    &nbsp;
                                    <span style="display:inline-block">共5页,到第</span>
                                    <input class="Jump" name="PageIndex" type="text" value="1" />页&nbsp;
                                    <input name="Keyword" type="hidden" />
                                    <input name="Sort" type="hidden" value="" />
                                    <input name="Order" type="hidden" value="" />
                                    <button class="btn btn-default btn-sm" onclick="GetSubmitUrl(&#39;form19&#39;)" type="submit">确定</button>
                                </div>
                            </form>
                        </div>


                        <script type="text/javascript">
                            var backdropLoading = {
                                create: function (ele) {
                                    var html = '<div class="backdropLoading" style="background-color:#000;background-color:rgba(0,0,0,.6);width:100%;height:100%;position:absolute;left:0;top:0;z-index:99999;">'
                                        + '<div style="position:absolute;top:10px;left:0;color:#fff;font-size:18px;width:100%;text-align:center;">正在加载中...</div>'
                                        + '<div style="position:absolute;bottom:10px;left:0;color:#fff;font-size:18px;width:100%;text-align:center;">正在加载中...</div></div>';
                                    ele = ele ? ele : 'body';
                                    $(ele).css({ 'position': 'relative' }).append(html);
                                },
                                remove: function (ele) {
                                    ele = ele ? ele : 'body';
                                    $('.backdropLoading', ele).remove();
                                }
                            };

                            function GetSubmitUrl(formIdName) {
                                var form = $("#" + formIdName);
                                var PageUrlRule = "/Memorial/ReList/69P{PageIndex}.html";
                                if (PageUrlRule != "") {
                                    PageUrlRule = PageUrlRule.replace("{PageIndex}", form.find("[name=PageIndex]").val());
                                    location.href = PageUrlRule;
                                }
                            }

                            function GetAjaxData(url) {
                                $.ajax({
                                    type: "get",
                                    url: url + "&_r=" + Math.random() * new Date().getTime(),
                                    beforeSend: function () {
                                        if ("" == "") {
                                            backdropLoading.create()
                                        }
                                        else {
                                            backdropLoading.create('#');
                                        }
                                    },
                                    success: function (data) {
                                        $("#").html(data);

                                        if ("" == "") {
                                            backdropLoading.remove()
                                        }
                                        else {
                                            backdropLoading.remove('#');
                                        }

                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
                                        if ("" == "") {
                                            backdropLoading.remove()
                                        }
                                        else {
                                            backdropLoading.remove('#');
                                        }
                                    }
                                })
                            }
                        </script>
                    </div>
                    <div class="blank"></div>
                </div>
            </div>
        </div>
        <!---------------右边结束----------------->
        <!--xw 2016/3/8  ADD  对应Article.js的MemorialHallID-->
        <input type="hidden" name="MemorialHallID" value="6b3eae8e-808b-4653-a41b-7f77585cc850" />
    </div>
</div>
<div class="blank"></div>

