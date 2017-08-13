<?php
$this->params['current_nav'] = 'life';
?>
<div class="container memorial-container">
    <div class="row">
        <!---------------左边开始----------------->
        <div class="col-md-3 hidden-sm no-padding-right mb20">
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>Yii::$app->request->get('id')])?>
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

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>Yii::$app->request->get('id')])?>

            <div class="blank"></div>
            <div class="box">
                <form action="/Search" method="get">
                    <div class="side-title"><a class="tit" href="#">搜索纪念馆</a><a class="more" href="/Search">高级搜索</a></div>
                    <input name="keyword" class="form-control" type="text">
                    <button class="tt-btn tt-btn-default"><i class="smIcon search"></i> 搜索</button>
                </form>
            </div>
            <div class="blank"></div>
            <div class="col-md-12">
                <div class="row">
                    <a href="/MemberCenter/Memorial/Add"><img class="img-responsive center-block" src="../../../../resource/images/memorials/right-avd.gif" alt="免费创建纪念馆"></a>
                </div>
            </div>
            <div class="blank"></div>


            <div class="box">
                <div class="side-title"><a class="tit" href="#">到过这里的访客</a><a class="more" href="#">更多&gt;&gt;</a></div>
                <div class="xp-huiyuan">
                    <ul>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889768" href="javascript:void(0)">
                                <img width="73" height="83" alt="344803800@qq.com" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="344803800@qq.com" data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889768" href="javascript:void(0)">344803800@qq.com</a>
                            </p>
                            <span>07月17日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">
                                <img width="73" height="83" alt="153*****363" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="153*****363" data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890058" href="javascript:void(0)">153*****363</a>
                            </p>
                            <span>07月11日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890159" href="javascript:void(0)">
                                <img width="73" height="83" alt="180*****805" src="http://imgs.5201000.com/UploadFiles/Image/2017/7/4/Heaven/Member/HeadPic/20170704180312.JPG">
                            </a>
                            <p class="ellipsis">
                                <a title="180*****805" data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890159" href="javascript:void(0)">180*****805</a>
                            </p>
                            <span>07月04日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889981" href="javascript:void(0)">
                                <img width="73" height="83" alt="565853277@qq.com" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="565853277@qq.com" data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=889981" href="javascript:void(0)">565853277@qq.com</a>
                            </p>
                            <span>06月25日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">
                                <img width="73" height="83" alt="pan.conan@gmail.com" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="pan.conan@gmail.com" data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890013" href="javascript:void(0)">pan.conan@gmail.com</a>
                            </p>
                            <span>06月21日</span>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890009" href="javascript:void(0)">
                                <img width="73" height="83" alt="Bluebaryamy@gmail.com" src="http://imgs.5201000.com/Resource/Images/Default/Member.jpg">
                            </a>
                            <p class="ellipsis">
                                <a title="Bluebaryamy@gmail.com" data-toggle="modal" data-target=".user-info-dialog" data-url="/MemberInfo?id=890009" href="javascript:void(0)">Bluebaryamy@gmail.com</a>
                            </p>
                            <span>06月21日</span>
                        </li>


                    </ul>
                </div>
            </div>

        </div>
        <!---------------左边结束----------------->




        <!---------------右边开始----------------->
        <div class="col-md-9 mb20">
            <div class="box">
                <h2 style="text-align: center">生平简介</h2>
                <div class="about">
                    <?php foreach ($deads as $dead):?>
                    <h3><?=$dead->dead_name?> <small>(<?=$dead->birth?> ~ <?=$dead->fete?>)</small></h3>
                    <p>
                        <?=$dead->desc?>
                    </p>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <!---------------右边结束----------------->
    </div>
</div>