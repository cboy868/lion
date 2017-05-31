<?php
use yii\helpers\Url;
?>
<style>
    ol.new-news-box li{
        height: 40px;
        line-height: 40px;
        font-size: 25px;
        color: #999;
    }
    ol.new-news-box li span{
        font-size: 18px;
    }
</style>
<div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
    <div class="widget-header">
        <h4 class="widget-title lighter"><i class="fa fa-newspaper-o"></i> 最新资讯</h4>
    </div>
    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">
            <ol class="new-news-box">
                <?php foreach ($models as $v):?>
                <li>
                    <a href="<?=Url::toRoute(['/news/home/default/view', 'id'=>$v->id])?>" target="_blank">
                    <?=$v->title?>
                    </a>
                    <span><?=date('m-d H:i', $v->created_at)?></span>
                    <span><?=$v->author?></span>
                </li>
                <?php endforeach;?>
            </ol>
        </div>
    </div>
</div>