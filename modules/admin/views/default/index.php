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
                感谢选用<strong>卓迅公墓管理</strong>系统
            </h1>
        </div><!-- /.page-header -->
        <p style="line-height: 2em;color:red;">
            请注意：目前本系统所有数据均为示例数据，如有疑问，请联系15910470214
        </p>

        <div class="row">
            <div class="col-xs-12 welcome-index">
                <div class="panel-heading bg-info">系统信息</div>
                <!-- <div class="panel-body">
                  欢迎使用 <?= Html::encode($this->title) ?>
                </div> -->
                <table class="table">
                  <tr><th width="200">程序版本</th><td>Release <?=Yii::$app->params['version']?></td></tr>
                  <tr><th>服务器系统及环境</th><td><?=php_uname('s')?> /PHP <?=PHP_VERSION?></td></tr>
                  <tr><th>服务器软件</th><td><?=$_SERVER['SERVER_SOFTWARE']?></td></tr>
                  <tr><th>技术支持邮箱</th><td><?=Yii::$app->params['supportEmail']?></td></tr>
                </table>

                <div class="panel-heading bg-info">以下是本系统主要模块 <small>
                        <a href="<?=\yii\helpers\Url::toRoute(['/grave/admin/workbench'])?>">进入工作台</a>
                    </small></div>


                <div class="hr hr-18 dotted hr-double">
                    <img src="/static/images/help/sys.png" alt="系统功能导图">
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>