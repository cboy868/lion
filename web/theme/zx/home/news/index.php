<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/dynamic.css">
<div class="dynamic common">
    <div class="container">
        <div class="skin_img shadow"><img src="/theme/m2/static/gls/img/dynamic/skin_dynamic.jpg" /></div>
        <div class="special shadow">
            <h2 class="tit1">
                <span class="txta"><?=g('cp_name')?>专题</span>
            </h2>
            <div class="tabbox clearfix">
                <div class="items">
                    <div class="bor">
                        <div class="tab">
                            <div class="tabcon set_lastli">
                                <ul class="clearfix" style="display:block;">
                                    <?php
                                    $subject = subject('zixun',7, '133x87');
                                    ?>
                                    <?php foreach ($subject as $k => $v):?>
                                    <li>
                                        <a href="<?=$v['link']?>" class="pic" target="_blank">
                                            <img src="<?=$v['cover']?>" />
                                        </a>
                                        <a href="<?=$v['link']?>" class="tit"><?=$v['title']?></a>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vid_pic shadow">
            <h2 class="tit1">
                <span class="txtb"><?=g('cp_name')?>视频</span>
            </h2>
            <?php
            $list = newsCates([2,3,4], 6, '161x161', 'video');
            ?>
            <div class="tabbox clearfix">
                <div class="items">
                    <div class="bor">
                        <div class="tab">
                            <div class="tabtit">
                                <?php $i=0; foreach ($list as $v):?>
                                    <a href="javascript:;" class="<?php if($i==0):?>active<?php endif;?>"><?=$v['name']?></a>
                                <?php $i++; endforeach;?>
                            </div>
                            <div class="tabcon set_lastli">
                                <?php $i=0; foreach ($list as $val):?>
                                <ul class="clearfix tit_move_box" style="<?php if($i==0):?>display:block;<?php endif;?>">
                                    <?php foreach ($val['child'] as $v):?>
                                        <li>
                                            <a href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>">
                                                <img src="<?=$v['cover']?>">
                                            </a>
                                            <h2 class="tit_move">
                                                <span><?=$v['title']?></span>
                                            </h2>
                                            <a href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>" class="player_ico">
                                                <img src="/theme/m2/static/gls/img/global/player.png">
                                            </a>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                                <?php $i++; endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vid_pic shadow">
            <h2 class="tit1">
                <span class="txtc"><?=g('cp_name')?>图片</span>
            </h2>
            <?php
            $list = newsCates([2,3,4], 6, '161x161', 'image');
            ?>
            <div class="tabbox clearfix">
                <div class="items">
                    <div class="bor">
                        <div class="tab">
                            <div class="tabtit">
                                <?php $i=0; foreach ($list as $v):?>
                                <a href="javascript:;" class="<?php if($i==0):?>active<?php endif;?>"><?=$v['name']?></a>
                                <?php $i++; endforeach;?>
                            </div>
                            <div class="tabcon set_lastli">
                                <?php $i=0; foreach ($list as $val):?>
                                <ul class="clearfix tit_move_box" style="<?php if($i==0):?>display:block;<?php endif;?>">
                                    <?php foreach ($val['child'] as $v):?>
                                        <li>
                                            <a href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v['id']])?>">
                                                <img src="<?=$v['cover']?>">
                                            </a>
                                            <h2 class="tit_move">
                                                <span><?=$v['title']?></span>
                                            </h2>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                                <?php $i++; endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="the_events shadow">
            <h2 class="tit1">
                <span class="txtd"><?=g('cp_name')?>大事记</span>
            </h2>

            <?php
            $items = focus(2, 10);
            ?>
            ?>
            <div class="tabbox clearfix padt20">
                <div class="the_events_tabs">
                    <div class="tabcon right">
                        <?php foreach ($items as $k => $item):?>
                            <div class="items" style="<?php if($k == 0):?>display:block;<?php endif;?>">
                                <?=$item['intro']?>
                            </div>
                        <?php endforeach;?>

                    </div>
                    <div class="tabtit clearfix">
                        <?php foreach ($items as $k => $item):?>
                            <a href="javascript:;" class="<?php if($k == 0):?>active<?php endif;?>"><?=$item['title']?></a>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/theme/m2/static/libs/cSwitch/cSwitch.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('.tab').cSwitch({
            btnItems : '.tabtit a',
            bigImg : '.tabcon > ul',
            PNBtnShow : false,
            changeFade : false,
            autoPlay : false
        });
        $('.the_events_tabs').cSwitch({
            btnItems : '.tabtit a',
            bigImg : '.tabcon > div',
            PNBtnShow : false,
            changeFade : false,
            autoPlay : false
        });
        titMove.init(); // 判断鼠标移入方向
    });
</script>