<div class="inside-focus">
    <img src="<?=$data['cover']?>" alt="">
</div>
<div class="inside-local wrap">
    <a href="URL">首页</a>
    <span> &gt; </span>
    <a href="<?=url(['/news/home/default/index'])?>">媒体中心</a>
</div>
<style type="text/css">
    .detail_right { width:30%; border:1px solid #ccc; padding:2%; /*background:#f1f1f1;*/float: right;}
    .detail_right .p1 { position:relative;}
    .detail_right .p1 h3 { font-size:18px; color:#870000; line-height:20px; border-bottom:1px solid #ccc;}
    .detail_right .p1 .more { position:absolute; right:0; top:0; bottom:0; margin:auto; height:12px; font-size:12px; line-height:12px;}
    .detail_right .tui_list ul li { margin-top:7px; margin-bottom:10px;display:inline-table; width:100%;border-bottom:1px solid #ccc;height:120px;}
    .detail_right .tui_list ul li p { display:inline-table; width:96%;text-align: left;}
    .detail_right .tui_list ul li p a{ color: #aa0002;}
    .detail_right .tui_list ul li p span{font-size: 12px;}
    .detail_right .tui_list ul li .tu { display:table-cell;width: 40%;}
    .mbigcontent{display:none;}
    .bigcontent{display:block;}
    .mdetail{display:none;}
</style>
<style>
    @media (max-width: 768px) {
        .detail_right{display:none;}
        .mdetail{display:block!important;}
    }
    @media (max-width: 640px) {
        .bigcontent {
            display: none;
        }
        .mbigcontent {
            display: block;
        }


    }

</style>
<div class="detail_right">
    <div class="p1">
        <h3>推荐资讯</h3>
    </div>
    <div class="tui_list">
        <?php
        $news = news(null, 8, '320x240', null, true);
        ?>
        <ul>
            <?php foreach ($news as $v):?>
            <li class="clearfix">
                <p>
                    <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>" title="<?=$v['title']?>"><?=$v['title']?></a><br>
                    <span><?=$v['summary']?></span>
                </p>
                <div class="tu">
                    <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>">
                        <img src="<?=$v['cover']?>" style="width: 100%;">
                    </a>
                </div>
            </li>
            <?php endforeach;?>

        </ul>
    </div>
</div>

<div class="inside-title" style="width:65%;float:left;margin-top:20px;margin-bottom:0px;">
    <p class="tn" style="font-size:22px;"><?=$data['title']?></p>
    <p class="cn" style="padding:10px 0;color:#a9a9a9;"><?=date('Y-m-d', $data['created_at'])?></p>
    <!--
    <div class="tn" style="text-align:center; margin-top:10px;margin-bottom:10px;">
        <ul class="clearfix bdsharebuttonbox bdshare-button-style0-16" style="width:20%; margin:0 auto; " data-bd-bind="1497418971137">
            <li style="float:left;width:33%;">
                <a href="#" style="width:30px; height:22px; background-color: #ccc; display:block; background:url(/Public/guangfan/images/b.jpg) 0 center no-repeat; margin:0 auto;" class="bds_tsina" data-cmd="tsina"></a>
            </li>
            <li style="float:left;width:33%;">
                <a href="#" style="width:30px; height:22px; background-color: #ccc; display:block; background:url(/Public/guangfan/images/w.jpg) 0 center no-repeat; margin:0 auto;" class="bds_weixin iconfont" data-cmd="weixin"></a>
            </li>
            <li style="float:left;width:33%;  ">
                <a href="#" style="width:30px; height:22px; background-color: #ccc; display:block; background:url(/Public/guangfan/images/q.jpg) 0 center no-repeat; margin:0 auto;" class="bds_sqq" data-cmd="sqq"></a>
            </li>
        </ul>
    </div>
    -->
</div>
<div class="news wrap" style="margin-bottom:-20px;">

    <div class="mbigcontent">
        <div class="newmain" style="width:100%;overflow: hidden;">
<?=$data['body']?>
        </div>
    </div>

    <div class="bigcontent">
        <div class="newmain" style="width:63%;float: left;overflow: hidden;">
            <?=$data['body']?>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="b-main clearfix" style="margin-top:30px;">
        <div class="b-main-l" style="float:left;">

            <?php if (isset($data['pre'])): ?>
            <p><a href="<?=url(['/news/home/default/view', 'id'=>$data['pre']['id']])?>" class="case-prev">上一篇：<?=$data['pre']['title']?></a></p>
            <?php endif;?>
            <?php if (isset($data['next'])): ?>
            <p><a href="<?=url(['/news/home/default/view', 'id'=>$data['next']['id']])?>" class="case-next">下一篇：<?=$data['next']['title']?></a></p>
            <?php endif;?>
        </div>
        <div class="b-main-r" style="float:right;">
            <a href="<?=url(['/news/home/default/index'])?>">返回列表</a>
        </div>
    </div>
</div>

<div class="detail_right mdetail">
    <div class="p1">
        <h3>推荐资讯</h3>
    </div>
    <div class="tui_list">
        <ul>
            <?php foreach ($news as $v):?>
                <li class="clearfix">
                    <p>
                        <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>"
                           title="<?=$v['title']?>"><?=$v['title']?></a><br>
                        <span>提要：<?=$v['summary']?></span>
                    </p>
                    <div class="tu">
                        <a href="<?=url(['/news/home/default/view', 'id'=>$v['id']])?>">
                            <img src="<?=$v['cover']?>" style="width: 100%;"></a>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>