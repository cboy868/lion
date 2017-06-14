<?php
$this->title = '成功案例 ';
?>
<div class="inside-focus">
    <img src="<?=$module['logo']?>" alt="">
</div>
<div class="inside-local wrap">
    <a href="/">首页</a>
    <span> &gt; </span>
    <a href="<?=url(['/cms/home/case/index'])?>">成功案例</a>

</div>
<div class="inside-title">
    <h2 class="en">success</h2>
    <h2 class="cn">成功案例 </h2>
</div>
<div class="news wrap">
    <ul class="news-list clearfix">
        <?php foreach ($data as $v):?>
        <li>
            <a href="<?=url(['/cms/home/about/view', 'id'=>$v['id']])?>" target="_blank">
                <img src="<?=$v['cover']?>" alt="<?=$v['title']?>">
            </a>
            <div class="dongtai-text">
                <h2><a href="<?=url(['/cms/home/about/view', 'id'=>$v['id']])?>" class="fx"><?=$v['title']?></a></h2>
                <p><?=$v['summary']?></p>
            </div>
            <a href="<?=url(['/cms/home/about/view', 'id'=>$v['id']])?>" class="dongB clearfix" target="_blank">
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

        <li class="disable"><a href="/Cases/list/55.html" class="page-prev">&lt;</a></li><li><a>1</a></li><li class="disable"><a href="/Cases/list/55-2.html">2</a></li><li class="disable"><a href="/Cases/list/55-2.html" class="page-next">&gt;</a></li>
    </div>
</div>