<div class="box">
    <div class="side-title">
        <a class="tit" href="javascript:void(0)">到过这里的访客</a>
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
                <span><?=$track->m?>月<?=$track->d?>日</span>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>