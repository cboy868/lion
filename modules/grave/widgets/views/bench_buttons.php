<?php 
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<style type="text/css">
    .fa-app{
        display: block;
        margin-bottom: 5px;
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
<div class="col-md-12">
    <div class="page-header">
        <h4><i class="fa fa-cubes"></i> 业务操作</h4>
    </div>

    <div class="shortcut clearfix">

        <a href="<?=Url::toRoute(['/grave/admin/tomb/search'])?>" class="btn btn-default modalAddButton" data-toggle="modal" data-target="#myModal">
            <img src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
            墓位业务
            <!-- <span class="badge badge-pink">+3</span> -->
        </a>

        <a href="<?=Url::toRoute(['tomb'])?>" class="btn btn-default modalAddButton">
            <img src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
            这业务
            <!-- <span class="badge badge-pink">+3</span> -->
        </a>

        <a href="<?=Url::toRoute(['tomb'])?>" class="btn btn-default modalAddButton">
            <img src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
            那业务
            <!-- <span class="badge badge-pink">+3</span> -->
        </a>

        <a href="<?=Url::toRoute(['tomb'])?>" class="btn btn-default modalAddButton">
            <img src="http://hs.ibagou.com/framework/builtin/wxcard/icon.jpg" class="fa-app">
            ok业务
            <!-- <span class="badge badge-pink">+3</span> -->
        </a>
    </div>
</div>