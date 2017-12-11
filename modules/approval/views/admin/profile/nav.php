<?php
use yii\helpers\Url;
$cur_nav = $this->context->action->id;
?>
<style>
    ul.nav-work li.active a{
        background-color: lightseagreen;
        color: #fff;
    }
    ul.nav-work li a:hover{
        background-color: lightseagreen;
        color: #fff;
    }
</style>
<ul class="nav navbar-nav nav-work">
    <li class="<?php if($cur_nav == 'work') echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/work'])?>">
            出勤情况
        </a>
    </li>

    <li class="<?php if($cur_nav == 'leave') echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/leave'])?>">
            请假
        </a>
    </li>
    <li class="<?php if($cur_nav == 'overtime') echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/overtime'])?>">
            加班
        </a>
    </li>
    <li class="<?php if($cur_nav == 'adjust') echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/adjust'])?>">
            调休
        </a>
    </li>
    <li class="<?php if($cur_nav == 'trip') echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/trip'])?>">
            出差
        </a>
    </li>
    <li class="<?php if($cur_nav == 'out') echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/out'])?>">
            外出
        </a>
    </li>
</ul>