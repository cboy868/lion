<?php
use yii\helpers\Url;
?>
<div class="sidebar">
    <div class="block clearfix">
        <h3 class="title">导航</h3>
        <div class="separator"></div>
        <nav>
            <ul class="nav nav-pills nav-stacked">
                <li><a href="<?=Url::toRoute('/')?>" >首页</a></li>
                <li><a href="<?=Url::toRoute('/home/default/about')?>">关于我们</a></li>
                <li class="active"><a href="<?=Url::toRoute('/blog/home/default/index')?>">公墓系统思考/博客</a></li>
                <li><a href="<?=Url::toRoute('/shop/home/default/index')?>">产品</a></li>
                <li><a href="<?=Url::toRoute('/home/default/contact')?>">联系我们</a></li>
            </ul>
        </nav>
    </div>
    <div class="block clearfix">
        <h3 class="title">推荐博客</h3>
        <div class="separator"></div>
        <?php $new_news = news(null, 5, null, null, true); ?>
        <?php foreach ($new_news as $v):?>
            <div class="image-box">
                <div class="overlay-container">
                    <img src="<?=$v['cover']?>" alt="">
                    <div class="overlay">
                        <div class="overlay-links">
                            <a href="<?=Url::toRoute(['/blog/home/default/view', 'id'=>$v['id']])?>">
                                <i class="fa fa-link"></i>
                            </a>
                            <a href="<?=$v['cover']?>" class="popup-img-single" title="<?=$v['title']?>">
                                <i class="fa fa-search-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="image-box-body">
                    <h3 class="title"><a target="_blank" href="<?=Url::toRoute(['/blog/home/default/view', 'id'=>$v['id']])?>">
                            <?=$v['title']?></a>
                    </h3>
                    <p><?=$v['summary']?></p>
                    <a target="_blank" href="<?=Url::toRoute(['/blog/home/default/view', 'id'=>$v['id']])?>" class="link">
                        <span>详细</span>
                    </a>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="block clearfix">
        <h3 class="title">快捷标签</h3>
        <div class="separator"></div>
        <div class="tags-cloud">
            <?php $tags = tags('news', 10);?>
            <?php foreach ($tags as $v):?>
                <div class="tag">
                    <a href="<?=Url::toRoute(['/news/home/default/tags', 'id'=>$v['id']])?>"><?=$v['tag_name']?></a>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <!--
    <div class="block clearfix">
        <form role="search">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Search">
                <i class="fa fa-search form-control-feedback"></i>
            </div>
        </form>
    </div>
    -->
</div>