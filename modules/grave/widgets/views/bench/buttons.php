<?php 
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<style type="text/css">
    .fa-app{
        display: block;
        margin-bottom: 5px;
    }
    .btn img{
        width:48px;
        height: 48px;
    }
    .widget-main .btn-default{
        border-radius: 5px;
        margin: 5px;
        width: 78px;
    }
</style>
<?php 
    Modal::begin([
        'header' => '业务办理',
        'id' => 'modalAdd',
        // 'size' => 'modal-lg'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
?>

<div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
<!--    <div class="widget-header">-->
<!--        <h4 class="widget-title lighter"><i class="fa fa-cubes"></i> 业务</h4>-->
<!--    </div>-->
    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">
            <a href="<?=Url::toRoute(['/grave/admin/tomb/search'])?>" class="btn btn-default modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                <img src="/static/images/icons/deal.png" class="fa-app">
                业务流程
            </a>
        </div>
    </div>
</div>
<?php foreach ($menus as $k=>$v):?>
<div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
    <div class="widget-header">
        <?php

        if (!isset($panels[$k])) {
            p($k);die;
        }
        ?>
        <h4 class="widget-title lighter"><i class="<?=$panels[$k]['icon']?>"></i> <?=$panels[$k]['name']?></h4>
        <!--
        <div class="widget-toolbar no-border">
            <a href="<?=Url::to(['/user/admin/default/buttons', 'group'=>$k])?>"
               class='btn btn-default modalAddButton' title="编辑快捷菜单"
               data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-edit"></i></a>
        </div>
        -->
    </div>
    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">
            <?php foreach ($v as $menu):?>
            <a href="<?=$menu['url']?>" target="_blank" class="btn btn-default">
                <img src="<?=$menu['ico']?>" class="fa-app">
                <?=$menu['name']?>
            </a>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endforeach;?>
