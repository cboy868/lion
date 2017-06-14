<?php
$this->title = $model['title'];
?>
<!-- 内容区 -->
<div class="inside-focus">
    <img src="/Uploads/201607/577c752b40a58.jpg" alt="" />
</div>
<div class="inside-local wrap">
    <div class="pos"><b></b>
        <span>当前位置：
            <a href="/">网站首页</a> &gt
            <a href="<?=url(['/cms/home/case/index'])?>">成功案例</a> &gt;
            <a href="<?=url(['/cms/home/case/view', 'id'=>$model['id']])?>"><?=$model['title']?></a>
        </span>
    </div>
    <div class="inside-title" style="width:65%;float:left;margin-top:20px;margin-bottom:10px;">
        <p class="tn" style="font-size:22px;"><?=$model['title']?></p>
        <p class="cn" style="padding:10px 0;color:#a9a9a9;"><?=date('Y-m-d H:i', $model['created_at'])?></p>
        <!--
        <div class="tn" style="text-align:center; margin-top:10px;">
            <ul class="clearfix" style="width:20%; margin:0 auto; " >
                <li style="float:left;width:33%;">
                    <a href="#" style="width:30px; height:22px; background-color: #ccc; display:block; background:url(/Public/guangfan/images/b.jpg) 0 center no-repeat; margin:0 auto;"></a>
                </li>
                <li style="float:left;width:33%;">
                    <a href="#" style="width:30px; height:22px; background-color: #ccc; display:block; background:url(/Public/guangfan/images/w.jpg) 0 center no-repeat; margin:0 auto;"></a>
                </li>
                <li style="float:left;width:33%;  ">
                    <a href="#" style="width:30px; height:22px; background-color: #ccc; display:block; background:url(/Public/guangfan/images/q.jpg) 0 center no-repeat; margin:0 auto;"></a>
                </li>
            </ul>
        </div>
        -->
    </div>
    <style type="text/css">
        .detail_right { width:20%; border:1px solid #ccc; padding:2%; /*background:#f1f1f1;*/float: right}
        .detail_right .p1 { position:relative}
        .detail_right .p1 h3 { font-size:18px; color:#870000; line-height:20px; border-bottom:1px solid #ccc}
        .detail_right .p1 .more { position:absolute; right:0; top:0; bottom:0; margin:auto; height:12px; font-size:12px; line-height:12px}
        .detail_right .tui_list ul li { display:inline-table; width:100%;padding:10px 0; border-bottom:1px solid #ccc;}
        .detail_right .tui_list ul li p { display:inline-table; width:96%;text-align: left;}
        .detail_right .tui_list ul li p a{ color: #aa0002}
        .detail_right .tui_list ul li p span{font-size: 12px;}
        .detail_right .tui_list ul li .tu { display:table-cell;width: 40%;}
        .case-mdetail{display:none;}
        @media (max-width: 768px) {
            .detail_right{display:none;}
            .case-mdetail{display:block!important;}
        }
    </style>

    <?php $case=cmsNewArticle(1, 8, '290x210');?>
    <div class="detail_right" style="margin-right:20px;">
        <div class="p1">
            <h3>最新案例</h3>
            <a class="more" href="<?=url(['/cms/home/case/index'])?>" target="_blank">更多>></a>
        </div>
        <div class="tui_list">
            <ul>
                <?php foreach ($case as $v):?>
                <li >
                    <p>
                        <a href="<?=url(['/cms/home/default/view', 'id'=>$v['id']])?>"
                           title="<?=$v['title']?>" target="_blank"><?=$v['title']?></a><br/>
                        <span>提要：<?=$v['summary']?></span>
                    </p>
                    <div class="tu">
                        <a href="<?=url(['/cms/home/default/view', 'id'=>$v['id']])?>" target="_blank"
                           title="<?=$v['title']?>"><img src="<?=$v['cover']?>" style="width: 100%;" /></a>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <div class="news wrap" style="margin-bottom:-20px;">
        <div class="newmain" style="width:63%;float: left;overflow: hidden;">
            <?=$model['body']?>
        </div>

        <div style="clear: both;"></div>

        <div class="b-main clearfix" style="margin-top:30px;">
            <div class="b-main-l" style="float:left;">

                <?php if(isset($pre)):?>
                <p><a href="<?=url(['/cms/home/case/view', 'id'=>$pre['id']])?>" class="case-prev" target="_blank"
                      title="<?=$pre['title']?>">上一篇：<?=$pre['title']?></a></p>
                <?php endif;?>

                <?php if(isset($next)):?>
                <p><a href="<?=url(['/cms/home/case/view', 'id'=>$next['id']])?>" class="case-next" target="_blank"
                      title="<?=$next['title']?>">下一篇：<?=$next['title']?></a></p>
                <?php endif;?>

            </div>
            <div class="b-main-r" style="float:right;">
                <a href="<?=url(['/cms/home/case/index'])?>">返回列表</a>
            </div>
        </div>
    </div>
    <div class="detail_right case-mdetail" style="margin-right:20px;">
        <div class="p1">
            <h3>最新案例</h3>
        </div>
        <div class="tui_list">
            <ul>
                <?php foreach ($case as $v):?>
                    <li >
                        <p>
                            <a href="<?=url(['/cms/home/default/view', 'id'=>$v['id']])?>"
                               title="<?=$v['title']?>" target="_blank"><?=$v['title']?></a><br/>
                            <span>提要：<?=$v['summary']?></span>
                        </p>
                        <div class="tu">
                            <a href="<?=url(['/cms/home/default/view', 'id'=>$v['id']])?>" target="_blank"
                               title="<?=$v['title']?>">
                                <img src="<?=$v['cover']?>" style="width: 100%;" /></a>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>