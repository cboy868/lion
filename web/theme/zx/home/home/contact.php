<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title="卓迅网络科技有限公司联系方式"
?>
<div class="page-intro">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><i class="fa fa-home pr-10"></i><a href="/">首页</a></li>
                    <li class="active">联系我们</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="main-container">

    <div class="container">
        <?=\app\core\widgets\Alert::widget();?>
        <div class="row">

            <!-- main start -->
            <!-- ================ -->
            <div class="main col-md-8">

                <!-- page-title start -->
                <!-- ================ -->
                <h1 class="page-title">联系我们</h1>
                <!-- page-title end -->
                <p>有任何想法或意见请联系我们，填写下方表单，我们会收到您的邮件，或直接使用右侧联系方式，祝生活愉快.</p>
                <div class="alert alert-success hidden" id="contactSuccess">
                    <strong>Success!</strong> Your message has been sent to us.
                </div>
                <div class="alert alert-error hidden" id="contactError">
                    <strong>Error!</strong> There was an error sending your message.
                </div>
                <div class="contact-form">
                    <?php
                        $form = ActiveForm::begin();
                        $form->fieldConfig['options']['class'] = 'form-group has-feedback';
                    ?>
                    <?php
                    $form->fieldConfig['template'] = "{label}{input}<i class=\"fa fa-user form-control-feedback\"></i>{hint}{error}";
                    ?>
                    <?= $form->field($model, 'username')->textInput()->label('您的称呼 <font color="red">*</font>') ?>
                    <?php
                    $form->fieldConfig['template'] = "{label}{input}<i class=\"fa fa-mobile form-control-feedback\"></i>{hint}{error}";
                    ?>
                    <?= $form->field($model, 'mobile')->textInput()->label('手机号 <font color="red">*</font>') ?>

                    <?php
                    $form->fieldConfig['template'] = "{label}{input}<i class=\"fa fa-qq form-control-feedback\"></i>{hint}{error}";
                    ?>
                    <?= $form->field($model, 'qq')->textInput()->label('QQ号') ?>

                    <?php
                    $form->fieldConfig['template'] = "{label}{input}<i class=\"fa fa-envelope form-control-feedback\"></i>{hint}{error}";
                    ?>
                    <?= $form->field($model, 'email')->textInput()->label('邮箱 <font color="red">*</font>') ?>
                    <?php
                    $form->fieldConfig['template'] = "{label}{input}<i class=\"fa fa-navicon form-control-feedback\"></i>{hint}{error}";
                    ?>
                    <?= $form->field($model, 'title')->textInput()->label('主题 <font color="red">*</font>') ?>
                    <?php
                    $form->fieldConfig['template'] = "{label}{input}<i class=\"fa fa-pencil form-control-feedback\"></i>{hint}{error}";
                    ?>
                    <?= $form->field($model, 'intro')->textarea(['rows'=>6])->label('内容 ') ?>
                    <?php
                    $form->fieldConfig['template'] = '{label}{input}{hint}{error}';
                    $form->fieldConfig['options']['style'] = ['width'=>'50%','float'=>'left'];
                    ?>

                    <div>
                        <?= $form->field($model, 'verifyCode')->textInput()->label('验证码 <font color="red">*</font>') ?>

                        <div style="width: 100px;float: left">
                            <?php
                            echo Captcha::widget(['name'=>'captchaimg',
                                'captchaAction'=>'/home/default/captcha',
                                'imageOptions'=>[
                                    'id'=>'captchaimg',
                                    'title'=>'换一个', 'alt'=>'换一个',
                                    'style'=>'cursor:pointer;margin-left:25px;margin-top:30px'],
                                'template'=>'{image}']);
                            ?>
                        </div>
                        <div style="clear: both"></div>
                    </div>


                    <div class="form-group">
                        <input type="submit" value="提 交" class="btn btn-default">
                    </div>

                    <?php
                    ActiveForm::end();
                    ?>
                </div>
            </div>
            <!-- main end -->

            <!-- sidebar start -->
            <aside class="col-md-4">
                <div class="sidebar">
                    <div class="side vertical-divider-left">
                        <h3 class="title">卓迅网络</h3>
                        <ul class="list">
                            <li><strong></strong></li>
                            <li><i class="fa fa-mobile pr-10 pl-5"></i><abbr title="Phone">Mobile:</abbr> 15910470214</li>
                            <li><i class="fa fa-envelope pr-10"></i><a href="mailto:info@zhuo-xun.com">info@zhuo-xun.com</a></li>
                        </ul>
                    </div>
                </div>
            </aside>
            <!-- sidebar end -->
        </div>
    </div>
</section>