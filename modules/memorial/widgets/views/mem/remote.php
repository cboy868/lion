<?php
use app\core\helpers\Url;
?>
<div class="box">
    <div class="side-title">
        <a class="tit" href="javascript:void(0)">祭奠记录</a>
        <a class="more" href="<?=Url::toRoute(['/memorial/home/hall/remote', 'id'=>$memorial_id])?>">更多祭奠记录&gt;&gt;</a></div>
    <div class="scoll-up">
        <ul class="list-unstyled">
            <?php foreach ($list as $v): ?>
            <li class="">
                <p>
                    <a href="javascript:void(0)"><?=$v->user->username;?></a>
                    敬献了<?=$v->goodsSkuName?>
                </p>
                <span>敬献时间：<?=date('Y-m-d H:i', $v->created_at)?></span>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>