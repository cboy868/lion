<?php
$this->params['current_nav'] = 'album';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/photo.css');
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
                                    <li><span>点击数：</span>638580次</li>
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
                    </div>


                </div>
            </div>

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
        <!---------------分组右边开始----------------->
        <div class="col-md-9 mb20">
            <div class="box">
                <div class="row page-nav">
                    <ul class="list-unstyled">
                        <li class="active"><a href="/Memorial/AlbumList/69.html">照片</a></li>
                        <li><a href="/Memorial/VideoList/69.html">视频</a></li>
                        <li><a href="/Memorial/MusicList/69.html">音频</a></li>
                        <li class="pull-right">
                            <div>
                                <span style="display:none;" id="post-msg"></span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="blank"></div>
                <div id="containerPhoto">
                    <!---------------内容开始----------------->
                    <div class="album-list">
                        <ul class="list-unstyled">
                            <li>
                                <div class="album-cover">
                                    <a onclick="ViewModel(this)" href="/Memorial/Photolist/69i35871.html">
                                        <img width="132" height="101" alt="孙中山" src="/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/091115193707015.jpg" />
                                    </a>
                                </div>
                                <div name="Group_35871" class="album-pro">
                                    <a href="/Memorial/PhotoList/69i35871.html">孙中山（<label>10</label>）</a>
                                    <p></p>
                                    <span></span>
                                </div>
                                <div class="album-handle">
                                    <a onclick="ViewModel(this)" href="/Memorial/PhotoList/69i35871.html"><span class="albumIcon camera"></span>普通浏览</a>
                                </div>
                            </li>
                            <li>
                                <div class="album-cover">
                                    <a onclick="ViewModel(this)" href="/Memorial/Photolist/69i35872.html">
                                        <img width="132" height="101" alt="" src="/UploadFiles/Image/2016/12/29/Heaven/ImgInfo/BreviaryImgPath/100109092055208.jpg" />
                                    </a>
                                </div>
                                <div name="Group_35872" class="album-pro">
                                    <a href="/Memorial/PhotoList/69i35872.html">孙中山相册（<label>1</label>）</a>
                                    <p></p>
                                    <span></span>
                                </div>
                                <div class="album-handle">
                                    <a onclick="ViewModel(this)" href="/Memorial/PhotoList/69i35872.html"><span class="albumIcon camera"></span>普通浏览</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!---------------内容结束----------------->
                </div>
            </div>
        </div>
        <!---------------分组右边结束----------------->
    </div>
</div>
