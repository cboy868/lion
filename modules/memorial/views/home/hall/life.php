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

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'track','mid'=>Yii::$app->request->get('id')])?>
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