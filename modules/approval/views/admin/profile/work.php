<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\core\widgets\GridView;
$this->params['profile_nav'] = 'work';

?>
<div class="page-content">
    <div class="page-content-area">

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs padding-18">
                    <li class="active">
                        <a href="<?=Url::toRoute(['/user/admin/profile/index'])?>">
                            出勤情况
                        </a>
                    </li>

                    <li class="">
                        <a href="<?=Url::toRoute(['/task/admin/profile/index'])?>">
                            请假
                        </a>
                    </li>
                    <li class="">
                        <a href="<?=Url::toRoute(['/blog/admin/profile/index'])?>">
                            加班
                        </a>
                    </li>
                    <li class="">
                        <a href="<?=Url::toRoute(['/mess/admin/profile/index'])?>">
                            调休
                        </a>
                    </li>
                    <li class="">
                        <a href="<?=Url::toRoute(['/mess/admin/profile/index'])?>">
                            出差
                        </a>
                    </li>
                    <li class="">
                        <a href="<?=Url::toRoute(['/mess/admin/profile/index'])?>">
                            外出
                        </a>
                    </li>
                </ul>
            </div>
        </div>


    </div>


</div>