<?php 
use app\core\helpers\Url;
?>
<div class="row well" style="margin:auto 0;">
    <div class="col-xs-3">
        <div class="progress" title="安装进度">
            <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar"
                 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                100%
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                安装步骤
            </div>
            <ul class="list-group">
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-copyright-mark"></span> &nbsp; 许可协议</a>
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-eye-open"></span> &nbsp; 环境监测</a>
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-cog"></span> &nbsp; 参数配置</a>
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-inbox"></span> &nbsp; 安装</a>
                <a href="javascript:;" class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-ok"></span> &nbsp; 成功</a>
            </ul>
        </div>
    </div>
    <div class="col-xs-9">
        <div class="panel panel-default">
            <div class="panel-heading">安装成功</div>
            <div class="panel-body" style="overflow-y:scroll;max-height:400px;line-height:20px;">
                <h4 class="text-center">恭喜，系统安装成功</h4>
                <div class="row">
                    <div class="col-md-12">
                        <a href="<?=Url::toRoute(['/admin'])?>">进入后台</a>
                        <a href="<?=Url::toRoute(['/'])?>">去首页</a>
                    </div>

                    <div class="col-md-12">
                        <p>
                            <br>

                            <?=Yii::$app->getSession()->getFlash('notice'); ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
