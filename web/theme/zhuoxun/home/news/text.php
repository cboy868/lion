<?php
$this->title = $data['title'];

?>
<link href="/theme/zhuoxun/static/css/channel.css" rel="stylesheet" >
<link href="/theme/zhuoxun/static/css/base-page.min.css" media="screen" rel="stylesheet" type="text/css" />


<?php $focus = focus(4, 1, '2560x600')?>
<div class="news_con_banner" style="background:url(<?=$focus['focus'][0]['cover']?>) no-repeat center top;background-size:cover;">
    <h1><?=$data['title']?></h1>
</div>
<!--mews_banner-->
<div class="news_con_top">
    <div class="con">
        <ul>
            <li>
                <strong><?=$data['author']?> <?=date('Y-m-d', $data['created_at'])?> </strong>
            </li>
        </ul>
        <a href="<?=url(['/news/home/default/index', 'cid'=>$data['category_id']])?>" class="more">&lt;返回新闻动态</a></div>
    <!--con--></div>
<!--news_con_top-->
<div class="news_con">
    <?=$data['body']?>
</div>
<!--news_con-->

<?php $news = newsRand(null, 3, '270x180')?>
<div class="news_box or">
    <h1>更多阅读</h1>
    <div class="news_box_list or">
        <?php foreach ($news as $k=> $v):?>
            <dl class="<?php if($k==2)echo'last'?>">
                <dd style="background:url(<?=$v['cover']?>) no-repeat center center; background-size:cover;">
                    <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>"></a></dd>
                <dt>
                <h2><a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>"><?=$v['title']?></a></h2>
                </dt>
                <dt><?=$v['category_name']?>  <?=date('Y-m-d', $v['created_at'])?></dt>
                <dt><?=$v['summary']?>
                    <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>" class="bt">查看全文</a>
                </dt>
            </dl>
        <?php endforeach;?>
    </div>
    <a href="<?=url(['/news/home/default/index'])?>" class="allnews">返回</a></div>
</div>
