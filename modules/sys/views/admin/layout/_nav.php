<?php 
use app\core\helpers\Url;
?>
<small class="pull-right">
    <?php if (Yii::$app->user->can('sys/auth-permission/index')):?>
    <a href="<?=Url::toRoute('/admin/sys/auth-permission/index')?>" class="btn bg-info">初始化权限</a> &gt;
    <?php endif;?>
    <?php if (Yii::$app->user->can('sys/auth-group/index')):?>
    <a href="<?=Url::toRoute('/admin/sys/auth-group/index')?>" class="btn bg-success">权限分组</a> &gt;
    <?php endif;?>
    <?php if (Yii::$app->user->can('sys/auth-role/index')):?>
    <a href="<?=Url::toRoute('/admin/sys/auth-role/index')?>" class="btn bg-danger">角色管理</a>
    <?php endif;?>
</small>