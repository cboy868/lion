<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = '系统信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                感谢选用<strong>Lion信息管理</strong>系统
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 welcome-index">
                <div class="panel-heading bg-info">系统信息</div>
                <!-- <div class="panel-body">
                  欢迎使用 <?= Html::encode($this->title) ?>
                </div> -->
                <table class="table">
                  <tr><th width="200">程序版本</th><td>Release 20150320</td></tr>
                  <tr><th>服务器系统及 PHP</th><td><?=php_uname('s')?> /PHP <?=PHP_VERSION?></td></tr>
                  <tr><th>服务器软件</th><td><?=$_SERVER['SERVER_SOFTWARE']?></td></tr>
                </table>

                <div class="panel-heading bg-info">系统功能简介</div>

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>