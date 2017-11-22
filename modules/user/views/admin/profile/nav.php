<?php
use yii\helpers\Url;
$profile_nav = $this->params['profile_nav'];
?>
<li class="<?php if($profile_nav == 'user') echo 'active'?>">
    <a href="<?=Url::toRoute(['/user/admin/profile/index'])?>">
        <i class="bigger-120 blue fa fa-user"></i>
        个人信息
    </a>
</li>

<li class="<?php if($profile_nav == 'task') echo 'active'?>">
    <a href="<?=Url::toRoute(['/task/admin/profile/index'])?>">
        <i class="bigger-120 blue fa fa-list"></i>
        我的任务
    </a>
</li>
<li class="<?php if($profile_nav == 'blog') echo 'active'?>">
    <a href="<?=Url::toRoute(['/blog/admin/profile/index'])?>">
        <i class="bigger-120 blue fa fa-file-text"></i>
        我的博客
    </a>
</li>
<li class="<?php if($profile_nav == 'mess') echo 'active'?>">
    <a href="<?=Url::toRoute(['/mess/admin/profile/index'])?>">
        <i class="bigger-120 blue fa fa-file-text"></i>
        我的食堂
    </a>
</li>

