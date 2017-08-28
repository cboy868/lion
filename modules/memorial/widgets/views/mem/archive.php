<?php
use yii\helpers\Url;
use app\core\helpers\Html;
?>
<style>
    .news-list p{
        text-indent: 2em;
    }
    .blog li{
        border-bottom:1px solid #efefef;
    }
    .blog a{
        color: #333;
        line-height: 1.8em;
    }
</style>
<div class="box">
    <div class="side-title">
        <a class="tit" href="<?=Url::toRoute(['archive','id'=>$memorial_id])?>">档案资料</a>
        <a class="more" href="<?=Url::toRoute(['archive','id'=>$memorial_id])?>">更多>></a>
    </div>
    <hr>
    <ul class="list-unstyled blog">
        <?php foreach ($list as $v):?>
            <li><a href="<?=Url::toRoute(['archive-view', 'id'=>$memorial_id,'bid'=>$v->id])?>"><?=Html::cutstr_html($v->title, 10)?></a></li>
        <?php  endforeach;?>
    </ul>
</div>
