<link href="/theme/zhuoxun/static/css/channel.css" rel="stylesheet" >
<link href="/theme/zhuoxun/static/css/base-page.min.css" media="screen" rel="stylesheet" type="text/css" />
<div class="news_con_banner" style="background:url(/theme/zhuoxun/static/image/article-news.jpg) no-repeat center top;background-size:cover;">
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
        <a href="/" class="more">&lt;返回首页</a></div>
    <!--con--></div>
<!--news_con_top-->
<div class="news_con">
    <?=$model->body?>
</div>
</div>
