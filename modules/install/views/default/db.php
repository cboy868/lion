<?php 
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\helpers\Url;
$this->title = '数据库配置';
?>
<div class="row well" style="margin:auto 0;">
    <div class="col-xs-3">
        <div class="progress" title="安装进度">
            <div class="progress-bar progress-bar-info progress-bar-striped active"
                 role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                60%
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                安装步骤
            </div>
            <ul class="list-group">
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-copyright-mark"></span> &nbsp; 许可协议</a>
                <a href="javascript:;" class="list-group-item list-group-item-success"><span class="glyphicon glyphicon-eye-open"></span> &nbsp; 环境监测</a>
                <a href="javascript:;" class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-cog"></span> &nbsp; 参数配置</a>
                <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span> &nbsp; 安装</a>
                <a href="javascript:;" class="list-group-item"><span class="glyphicon glyphicon-ok"></span> &nbsp; 成功</a>
            </ul>
        </div>
    </div>
    <div class="col-xs-9">

        <?php

        $form = ActiveForm::begin();
        $form->action = Url::toRoute(['install']);
        $form->fieldConfig['template'] = '{label}<div class="col-sm-5">{input}{error}</div>{hint}';

        ?>

            <div class="panel panel-default">
                <div class="panel-heading">数据库配置</div>
                <div class="panel-body">


                    <?= $form->field($model, 'host')->textInput(['maxlength' => true, 'value'=>'localhost'])
                        ->hint('数据库服务器地址一般为 <i class="text-danger">localhost</i> 或 <i class="text-danger">127.0.0.1</i>') ?>

                    <?= $form->field($model, 'dbname')->textInput(['maxlength' => true, 'value'=>'lion_test'])->hint('本程序所使用的数据库名,如已存在，则会覆盖'); ?>

                    <?= $form->field($model, 'dbuser')->textInput(['maxlength' => true, 'value'=>'yii'])->hint('数据库用户名') ?>

                    <?= $form->field($model, 'dbpwd')->passwordInput(['maxlength' => true, 'value'=>'yii2016'])->hint('数据库登录密码') ?>

                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">管理选项</div>
                <div class="panel-body">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'value'=>'admin'])->hint('由英文字母和下划线组成') ?>

                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'minlength'=>true, 'value'=>'admin123'])->hint('管理员密码不可为空,不少于6位') ?>

                    <?= $form->field($model, 'repassword')->passwordInput(['value'=>'admin123'])->hint('请再次输入密码') ?>

                    <?= $form->field($model, 'email')->textInput(['value'=>'cb@163.com'])->hint('用于站长联系等收取邮件功能') ?>
                </div>
            </div>
            <input type="hidden" name="do" id="do">
            <ul class="pager">

                <li class="previous">
                    <button class="btn btn-default" onclick="history.go(-1)"><span class="glyphicon glyphicon-chevron-left"></span> 返回</button>
                </li>
                <li class="previous">
                    <button class="btn btn-default">继续<span class="glyphicon glyphicon-chevron-right"></span></button>
                </li>
            </ul>
        <?php ActiveForm::end(); ?>
    </div>
</div>