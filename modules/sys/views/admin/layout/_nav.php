<?php 
use app\core\helpers\Url;
?>
<small class="pull-right">
    <a href="<?=Url::toRoute('/admin/sys/auth-permission/index')?>" class="btn bg-info">初始化权限</a> &gt;
    <a href="<?=Url::toRoute('/admin/sys/auth-group/index')?>" class="btn bg-success">权限分组</a> &gt;
    <a href="<?=Url::toRoute('/admin/sys/auth-role/index')?>" class="btn bg-danger">角色管理</a>
</small>