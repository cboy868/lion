<?php 
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\helpers\Url;
$this->title = '数据库配置';
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">安装向导---配置</h3>
        </div>
        <div class="panel-body">
          <h4 class="text-center">2.数据库及管理员配置</h4>
        </div>

        <?php 

           $form = ActiveForm::begin(); 
           $form->action = Url::toRoute(['install']);
           $form->fieldConfig['template'] = '{label}<div class="col-sm-5">{input}{error}</div>{hint}';

           ?>
        <div class="row">
          <div class="col-md-12" style="margin:10px;">
            <h4 class="text-primary">填写数据库信息</h4>
          <style type="text/css">
          .form-group{clear:both;}
          </style>


            <?= $form->field($model, 'host')->textInput(['maxlength' => true, 'value'=>'localhost'])->hint('数据库服务器地址一般为 <i class="text-danger">localhost</i> 或 <i class="text-danger">127.0.0.1</i>', ['class'=>'col-sm-5']) ?>

            <?= $form->field($model, 'dbname')->textInput(['maxlength' => true, 'value'=>'lion_test'])->hint('本程序所使用的数据库名,如已存在，则会覆盖'); ?>

            <?= $form->field($model, 'dbuser')->textInput(['maxlength' => true, 'value'=>'yii'])->hint('数据库用户名') ?>

            <?= $form->field($model, 'dbpwd')->passwordInput(['maxlength' => true, 'value'=>'yii2016'])->hint('数据库登录密码') ?>

            <h4 class="text-primary">填写管理员信息</h4>

              <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'value'=>'admin'])->hint('由英文字母和下划线组成') ?>

              <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'minlength'=>true, 'value'=>'admin123'])->hint('管理员密码不可为空,不少于6位') ?>

              <?= $form->field($model, 'repassword')->passwordInput(['value'=>'admin123'])->hint('请再次输入密码') ?>
            
              <?= $form->field($model, 'email')->textInput(['value'=>'cb@163.com'])->hint('用于站长联系等收取邮件功能') ?>
            
          </div>              
        </div>
        
        <div class="panel-footer text-right">
            <?=  Html::submitButton('下一步', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>