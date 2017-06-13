<?php
use yii\widgets\LinkPager;
?>
<div class="inside-focus">
    <img src="http://www.hennissy.com/Uploads/201607/577e2d3c9b848.jpg" alt="">
</div>

<div class="inside-local wrap">
    <div class="pos"><b></b><span>当前位置：
            <a href="/">网站首页</a> &gt;
            <a href="<?=url(['/news/home/default/index'])?>">媒体中心</a>
            <?php if (isset($category)):?>
                &gt; <a href="<?=url(['/news/home/default/index', 'cid'=>$category['id']])?>"><?=$category['name']?></a>
            <?php endif;?>
        </span>
    </div>
</div>

<div class="inside-title">
    <h2 class="en">CORPORATE NEWS</h2>
    <?php if (isset($category)):?>
    <h2 class="cn"><?=$category['name']?> </h2>
    <?php else:?>
    <h2 class="cn">媒体中心 </h2>
    <?php endif;?>
</div>

<script src="/theme/juding/static/js/blocksit.min.js"></script>
<div class="news wrap">
    <ul class="news-list clearfix">
        <?php foreach ($list as $v):?>
        <li>
            <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>"
               class="news_list_pic"
               title="<?=$v['title']?>" target="_blank">
                <span class="pic" style="background-image:url(<?=$v['cover']?>)"></span>
            </a>
            <div class="dongtai-text">
                <h2><a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>"
                       class="fx"
                       title="<?=$v['title']?>" target="_blank">
                        <?=$v['title']?>
                    </a></h2>
                <p><?=$v['summary']?></p>
            </div>
            <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>"
               class="dongB clearfix" title="<?=$v['title']?>" target="_blank">
                <div class="fl">
                    <h3><?=date('m-d', $v['created_at'])?></h3>
                    <i><?=date('Y', $v['created_at'])?></i>
                </div>
                <span class="fr"></span>
            </a>
        </li>
        <?php endforeach;?>
    </ul>


    <div class="page">

        <?php
        echo LinkPager::widget([
            'pagination' => $pagination,
            'nextPageLabel' => '>',
            'prevPageLabel' => '<',
            'firstPageLabel' => '首页',
            'lastPageLabel' => '尾页',
        ]);
        ?>

    </div>
</div>