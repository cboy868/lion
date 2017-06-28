<?php
$this->title = $model->title;

?>
<link href="/theme/zhuoxun/static/css/channel.css" rel="stylesheet" >
<link href="/theme/zhuoxun/static/css/base-page.min.css" media="screen" rel="stylesheet" type="text/css" />


<?php $focus = focus(8, 1, '2560x600')?>
<div class="news_con_banner" style="background:url(<?=$focus['focus'][0]['cover']?>) no-repeat center top;background-size:cover;">
    <h1><?=$model->title?></h1>
</div>
<!--mews_banner-->
<div class="news_con_top">
    <div class="con">
        <ul>
            <li>
                <strong><?=$model->author?> <?=date('Y-m-d', $model->created_at)?> </strong>
            </li>
        </ul>
        <a href="<?=url(['/cms/home/knowledge/index', 'cid'=>$model->category_id])?>" class="more">&lt;返回知识库</a></div>
    <!--con--></div>
<!--news_con_top-->
<div class="news_con">
    <?=$model->body?>
</div>
<!--news_con-->

<?php $post = cmsRand(8, null, 3, '270x180')?>
<div class="news_box or">
    <h1>更多阅读</h1>
    <div class="news_box_list or">
        <?php foreach ($post as $k=> $v):?>
        <dl class="<?php if($k==2)echo'last'?>">
            <dd style="background:url(<?=$v['cover']?>) no-repeat center center; background-size:cover;">
                <a href="<?=url(['/cms/home/knowledge/view', 'id'=>$v['id']])?>"></a></dd>
            <dt>
            <h2><a href="<?=url(['/cms/home/knowledge/view', 'id'=>$v['id']])?>"><?=$v['title']?></a></h2>
            </dt>
            <dt>产品设计   <?=date('Y-m-d', $v['created_at'])?></dt>
            <dt><?=$v['summary']?>
                <a href="<?=url(['/cms/home/knowledge/view', 'id'=>$v['id']])?>" class="bt">查看全文</a>
            </dt>
        </dl>
        <?php endforeach;?>
    </div>
    <a href="<?=url(['/cms/home/knowledge/index'])?>" class="allnews">返回知识库</a></div>
</div>
