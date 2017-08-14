<?php
$this->params['current_nav'] = 'achive';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/relist.css');
?>
<div class="container memorial-container">
    <!--这里加内容-->
        <div class="row">
            <!-- 左边开始 -->
            <div class="col-md-3 hidden-sm no-padding-right mb20">
                <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>Yii::$app->request->get('id')])?>
                <div class="blank"></div>

                <div class="box">
                    <div class="side-title">
                        微信扫一扫“码”上纪念 孙中山
                    </div>
                    <div style="text-align:center" class="side-tips">
        <span>
            <img src="/Generate?id=69">
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
            <!-- -------------左边结束--------------- -->
            <!-- -------------右边开始--------------- -->
            <div class="col-md-9 mb20">
                <div class="box">
                    <h2 style="text-align: center">档案资料</h2>
                    <div class="blank"></div>
                    <div class="line"></div>
                    <div class="blank"></div>
                        <!-- -------------内容开始--------------- -->
                    <div class="news-list">
                        <?php $archives = $dataProvider->getModels() ?>
                        <ul>
                            <?php foreach ($archives as $archive):?>
                            <li>
                                <h4><a href="#"><?=$archive->title?></a></h4>
                                <div class="new-cont">
                                    <?=\app\core\helpers\Html::cutstr_html($archive->body, 200)?>
                                </div>
                                <div class="new-data">
                                    <span>
                                        发布人：
                                        <a href="javascript:void(0)">
                                            <?=$archive->user->username?>
                                        </a>
                                    </span>
                                    <span>阅读（<?=$archive->view_all?>次）</span>
                                    <span>评论（<?=$archive->com_all?>次）</span>
                                    <span>发布时间: <?=date('Y-m-d H:i', $archive->created_at)?></span>
                                </div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <!-- -------------内容结束--------------- -->
                    <div class="page">
                        <?php
                            echo \yii\widgets\LinkPager::widget([
                                'pagination' => $dataProvider->getPagination(),
                                'nextPageLabel' => '>',
                                'prevPageLabel' => '<',
                                'lastPageLabel' => '尾页',
                                'firstPageLabel' => '首页',
                                'options' => [
                                    'class' => 'pull-right pagination'
                                ]
                            ])
                        ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <!-- -----------右边结束--------------- -->
        </div>

</div>