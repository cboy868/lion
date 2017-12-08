<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\core\widgets\GridView;
$this->params['profile_nav'] = 'approval';

$this->title = '我的任务';
$this->params['breadcrumbs'][] = ['label' => '个人中心', 'url' => ['/user/admin/profile/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-content">
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->
    </div>


    <ul class="nav">
        <li class="">
            <a href="<?=Url::toRoute(['/user/admin/profile/index'])?>">
                <i class="bigger-120 blue fa fa-user"></i>
                个人信息
            </a>
        </li>

        <li class="">
            <a href="<?=Url::toRoute(['/task/admin/profile/index'])?>">
                <i class="bigger-120 blue fa fa-list"></i>
                我的任务
            </a>
        </li>
        <li class="">
            <a href="<?=Url::toRoute(['/blog/admin/profile/index'])?>">
                <i class="bigger-120 blue fa fa-file-text"></i>
                我的博客
            </a>
        </li>
        <li class="">
            <a href="<?=Url::toRoute(['/mess/admin/profile/index'])?>">
                <i class="bigger-120 blue fa fa-file-text"></i>
                我的食堂
            </a>
        </li>

    </ul>
</div>