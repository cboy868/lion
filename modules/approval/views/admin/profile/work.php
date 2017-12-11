<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\core\widgets\GridView;
$this->params['profile_nav'] = 'work';

?>

<div class="page-content">
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>

                    <ul class="nav navbar-nav nav-work">
                        <li class="active">
                            <a href="<?=Url::toRoute(['/approval/admin/profile/work'])?>">
                                出勤情况
                            </a>
                        </li>

                        <li class="">
                            <a href="<?=Url::toRoute(['/approval/admin/profile/leave'])?>">
                                请假
                            </a>
                        </li>
                        <li class="">
                            <a href="<?=Url::toRoute(['/approval/admin/profile/overtime'])?>">
                                加班
                            </a>
                        </li>
                        <li class="">
                            <a href="<?=Url::toRoute(['/approval/admin/profile/index'])?>">
                                调休
                            </a>
                        </li>
                        <li class="">
                            <a href="<?=Url::toRoute(['/approval/admin/profile/index'])?>">
                                出差
                            </a>
                        </li>
                        <li class="">
                            <a href="<?=Url::toRoute(['/approval/admin/profile/index'])?>">
                                外出
                            </a>
                        </li>
                    </ul>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-md-12">
            </div>
        </div>


    </div>


</div>