<div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
    <div class="widget-header">
        <h4 class="widget-title lighter"><i class="fa fa-newspaper-o"></i> 今日更新</h4>
    </div>
    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">
            <ul class="media-list">
                <?php foreach ($models as $k => $model): ?>
                    <li class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?=$model->getThumb('48x48')?>" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#"><?=$model->title?></a></h4>
                            <p>
                                <?=$model->summary?>...
                            </p>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>

        </div>
    </div>
</div>

