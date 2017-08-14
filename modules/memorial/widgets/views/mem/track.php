<div class="box">
    <div class="side-title">
        <a class="tit" href="javascript:void(0)">到过这里的访客</a>
        <a class="more" href="javascript:void(0)">更多&gt;&gt;</a>
    </div>
    <div class="xp-huiyuan">
        <ul>
            <?php foreach($tracks as $track):?>
            <li>
                <a href="javascript:void(0)">
                    <img width="73" height="83" src="<?=$track->user->getAvatar('136x174')?>">
                </a>
                <p class="ellipsis">
                    <a href="javascript:void(0)">
                        <?=$track->user->username?>
                    </a>
                </p>
                <span><?=date('m月d日', $track->created_at)?></span>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>