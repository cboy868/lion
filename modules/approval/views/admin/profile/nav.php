<?php
use yii\helpers\Url;
use app\modules\approval\models\ApprovalLeave;
$cur_nav = $this->context->action->id;
$adjust = Yii::$app->request->get('adjust');
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

    <li class="<?php if($adjust == ApprovalLeave::GENRE_LEAVE) echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/list', 'adjust'=>ApprovalLeave::GENRE_LEAVE])?>">
            请假
        </a>
    </li>
    <li class="<?php if($adjust == ApprovalLeave::GENRE_OVERTIME) echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/list', 'adjust'=>ApprovalLeave::GENRE_OVERTIME])?>">
            加班
        </a>
    </li>
    <li class="<?php if($adjust == ApprovalLeave::GENRE_ADJUST) echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/list', 'adjust'=>ApprovalLeave::GENRE_ADJUST])?>">
            调休
        </a>
    </li>
    <li class="<?php if($adjust == ApprovalLeave::GENRE_TRIP) echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/trip', 'adjust'=>ApprovalLeave::GENRE_TRIP])?>">
            出差
        </a>
    </li>
    <li class="<?php if($adjust == ApprovalLeave::GENRE_OUT) echo'active';?>">
        <a href="<?=Url::toRoute(['/approval/admin/profile/out', 'adjust'=>ApprovalLeave::GENRE_OUT])?>">
            外出
        </a>
    </li>
</ul>