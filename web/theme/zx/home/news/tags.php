<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title="卓迅网络有关".$tag->tag_name."的技术文章";
?>
<section class="main-container">
    <div class="container">
        <div class="row">

            <!-- main start -->
            <!-- ================ -->
            <div class="main col-md-8">

                <!-- page-title start -->
                <!-- ================ -->
                <h1 class="page-title">公墓管理系统功能模块分析</h1>
                <div class="separator-2"></div>
                <p class="lead">
                    卓迅公墓管理系统模块开发思路及使用介绍
                    <br class="hidden-sm hidden-xs">
                    在这里您可以了解到本系统最新的研发消息与系统使用技巧
                </p>
                <!-- page-title end -->

                <?php foreach ($list as $k => $v): ?>
                    <!-- blogpost start -->
                    <article class="clearfix blogpost object-non-visible"
                             data-animation-effect="fadeInUpSmall"
                             data-effect-delay="200">
                        <div class="overlay-container">
                            <img src="<?=$v['cover']?>" alt="<?=$v['title']?>">
                            <div class="overlay">
                                <div class="overlay-links">
                                    <a href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>">
                                        <i class="fa fa-link"></i>
                                    </a>
                                    <a href="<?=$v['cover']?>" class="popup-img-single" title="<?=$v['title']?>">
                                        <i class="fa fa-search-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="blogpost-body">
                            <div class="post-info">
                                <span class="day"><?=date('d', $v['created_at'])?></span>
                                <span class="month"><?=date('m月Y', $v['created_at'])?></span>
                            </div>
                            <div class="blogpost-content">
                                <header>
                                    <h2 class="title">
                                        <a href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>"><?=$v['title']?></a>
                                    </h2>
                                    <div class="submitted">
                                        <i class="fa fa-user pr-5"></i>
                                        作者 <a href="#"><?=$v['author']?></a>
                                    </div>
                                </header>
                                <p>
                                    <?=$v['summary']?>
                                </p>
                            </div>
                        </div>
                        <footer class="clearfix">
                            <ul class="links pull-left">
                                <!--
                                <li>
                                    <i class="fa fa-comment-o pr-5"></i>
                                    <a href="#">22 comments</a> |
                                </li>
                                -->
                                <li><i class="fa fa-tags pr-5"></i>
                                    <?php foreach ($v['tags'] as $tag):?>
                                        <a target="_blank" href="<?=Url::toRoute(['/news/home/default/tags', 'id'=>$tag['id']])?>">
                                            <?=$tag['tag_name']?>
                                        </a>,
                                    <?php endforeach;?>
                                </li>
                            </ul>
                            <a class="pull-right link" href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>"><span>详细</span></a>
                        </footer>
                    </article>
                    <!-- blogpost end -->
                <?php endforeach;?>

                <!-- pagination start -->
                <ul class="pagination">
                    <?php
                    echo LinkPager::widget([
                        'pagination' => $pagination
                    ]);
                    ?>
                </ul>
                <!-- pagination end -->
            </div>
            <!-- main end -->

            <!-- sidebar start -->
            <aside class="col-md-3 col-md-offset-1">
                <?=$this->render('_right');?>
            </aside>
            <!-- sidebar end -->
        </div>
    </div>
</section>
<!-- main-container end -->