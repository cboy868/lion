<div class="box">
    <p>
        <img class="img-responsive img-rounded center-block" src="<?=$model->getThumbImg('153x174')?>">
    </p>
    <div class="blank"></div>
    <div class="blank"></div>
    <div class="ny-ren-xx">
        <ul class="list-unstyled">
            <li><span>馆名：</span><?=$model->title?></li>
            <?php if ($model->deads): ?>
            <li>
                <span>逝者</span><br>
                <?php foreach ($model->deads as $dead):?>
                    <?=$dead->dead_name;?>(<?=$dead->birth?>~<?=$dead->fete?>) <br>
                <?php endforeach;?>
            </li>
            <?php endif;?>
            <li>
                <span>建馆者：</span>
                <a href="javascript:void(0)">
                    <?=$model->user->username?>
                </a>
            </li>
            <li><span>建馆时间：</span><?=date('Y年m月d日', $model->created_at)?></li>
            <li><span>查看次数：</span><?=$model->view_all?>次</li>
        </ul>
    </div>
</div>