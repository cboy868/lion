<?php
use yii\widgets\LinkPager;
$this->title = '成功案例 ';
?>
<div class="inside-focus">
    <img src="<?=$module['logo']?>" alt="">
</div>
<div class="inside-local wrap">

    <span>当前位置：
        <a href="/">网站首页</a> &gt;
        <a href="<?=url(['/cms/home/case/us'])?>">成功案例</a>
    </span>

</div>
<div class="inside-title">
    <h2 class="en">success</h2>
    <h2 class="cn">成功案例 </h2>
</div>
<div class="news wrap">
    <ul class="news-list clearfix">
        <?php foreach ($data as $v):?>
        <li>
            <a href="<?=url(['/cms/home/case/view', 'id'=>$v['id']])?>" target="_blank">
                <img src="<?=$v['cover']?>" alt="<?=$v['title']?>">
            </a>
            <div class="dongtai-text">
                <h2><a href="<?=url(['/cms/home/case/view', 'id'=>$v['id']])?>" class="fx"><?=$v['title']?></a></h2>
                <p><?=$v['summary']?></p>
            </div>
            <a href="<?=url(['/cms/home/case/view', 'id'=>$v['id']])?>" class="dongB clearfix" target="_blank">
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