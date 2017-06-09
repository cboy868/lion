<?php
use yii\helpers\Url;

$this->title=$data['title'];
?>
<section class="main-container">

<div class="container">
    <div class="row">

        <!-- main start -->
        <!-- ================ -->
        <div class="main col-md-8">

            <!-- page-title start -->
            <!-- ================ -->
            <h1 class="page-title"><?=$data['title']?></h1>
            <!-- page-title end -->

            <!-- blogpost start -->
            <article class="clearfix blogpost full">
                <div class="blogpost-body">
                    <div class="side">
                        <div class="post-info">
                            <span class="day"><?=date('d', $data['created_at'])?></span>
                            <span class="month"><?=date('m月Y', $data['created_at'])?></span>
                        </div>
<!--                        <div id="affix"><span class="share">Share This</span><div id="share"></div></div>-->
                    </div>
                    <div class="blogpost-content">
                        <header>
                            <div class="submitted"><i class="fa fa-user pr-5"></i> 作者 <a href="#"><?=$data['author']?></a></div>
                        </header>
                        <div class="owl-carousel content-slider-with-controls">
                            <div class="overlay-container">
                                <img src="<?=$data['cover']?>" alt="">
                                <a href="<?=$data['cover']?>" class="popup-img overlay" title="<?=$data['title']?>">
                                    <i class="fa fa-search-plus"></i>
                                </a>
                            </div>
                        </div>
                        <?=$data['body']?>
                    </div>
                </div>
                <footer class="clearfix">
                    <ul class="links pull-left">
<!--                        <li><i class="fa fa-comment-o pr-5"></i> <a href="#">22 comments</a> |</li>-->
                        <li><i class="fa fa-tags pr-5"></i>
                            <?php foreach ($data['tags'] as $v):?>
                            <a target="_blank" href="<?=Url::toRoute(['/news/home/default/tags', 'id'=>$v['id']])?>">
                                <?=$v['tag_name']?>
                            </a>,
                            <?php endforeach;?>
                        </li>
                    </ul>
                </footer>
            </article>

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