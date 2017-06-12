<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
\app\assets\JqueryuiAsset::register($this);
?>

<style>
    .online-intxt {
        width: 380px;
        height: 24px;
        border: 1px solid #eaeaea;
        box-shadow: inset 0 2px 2px #eaeaea;
    }
    .remarks-info td {
        padding-bottom: 16px;
    }
    .btnsubmit{
        font-size: 20px;
        border-radius: 5px;
        padding: 5px 15px;
        color: #fff;
        background-color: #B67136;
    }
    .has-error{
        color:red;
    }
</style>
<link rel="stylesheet" type="text/css" href="/theme/m2/static/gls/css/product.css">
<div class="product details common">
    <div class="container clearfix bgcolor1">
        <!--        <div class="skin_img"><img src="/theme/m2/static/gls/img/product/skin_product.jpg" /></div>-->
        <div class="main right">
            <div class="borbox">
                <h2 class="tit2">
                    <span class="txtd"><?=g('cp_name')?>产品</span>
                </h2>
                <div class="det clearfix">
                    <p class="breadcrumb">当前位置：
                        <a href="/">首页</a><span>&gt;</span>
                        <a href="<?=\yii\helpers\Url::toRoute(['/grave/home/default/index'])?>">预约服务</a>
                        <span>&gt;</span> <?=$grave->name?></p>

                    <?=\app\core\widgets\Alert::widget();?>

                    <div class="environment remarks-info">
                        <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($model, 'res_name')
                            ->hiddenInput(['maxlength' => true, 'class'=>'online-intxt'])
                            ->label(false) ?>
                        <?= $form->field($model, 'res_id')
                            ->hiddenInput(['maxlength' => true, 'class'=>'online-intxt'])
                            ->label(false) ?>
                        <table width="100%">
                            <tr>
                                <th>姓名 <font color="red">(*)</font></th>
                                <td><?= $form->field($model, 'username')
                                        ->textInput(['maxlength' => true, 'class'=>'online-intxt'])
                                        ->label(false) ?></td>
                            </tr>
                            <tr>
                                <th>电话 <font color="red">(*)</font></th>
                                <td><?= $form->field($model, 'mobile')
                                        ->textInput(['maxlength' => true, 'class'=>'online-intxt'])
                                        ->label(false) ?></td>
                            </tr>
                            <tr>
                                <th>标题 <font color="red">(*)</font></th>
                                <td><?= $form->field($model, 'title')
                                        ->textInput(['maxlength' => true, 'class'=>'online-intxt'])
                                        ->label(false) ?></td>
                            </tr>
                            <tr>
                                <th>邮箱</th>
                                <td><?= $form->field($model, 'email')
                                        ->textInput(['maxlength' => true, 'class'=>'online-intxt'])
                                        ->label(false) ?></td>
                            </tr>
                            <tr>
                                <th>预约备注</th>
                                <td><?= $form->field($model, 'intro')
                                        ->textArea(['style'=>'width:430px;height:100px;'])
                                        ->label(false) ?></td>
                            </tr>
                            <tr>
                                <th>预约时间</th>
                                <td><?= $form->field($model, 'term')
                                        ->textInput(['maxlength' => true, 'class'=>'online-intxt', 'id'=>'pre-date'])
                                        ->label(false) ?></td>
                            </tr>
                            <tr>
                                <th>验证码</th>
                                <td style="position: relative"><?= $form->field($model, 'verifyCode')
                                        ->textInput(['maxlength' => true, 'style'=>'width:100px;'])
                                        ->label(false) ?>
                                    <div style="position: absolute;top:-10px;left:120px">
                                        <?php
                                        echo Captcha::widget(['name'=>'captchaimg',
                                            'captchaAction'=>'/home/default/captcha',
                                            'imageOptions'=>[
                                                'id'=>'captchaimg',
                                                'title'=>'换一个', 'alt'=>'换一个',
                                                'style'=>'cursor:pointer'],
                                            'template'=>'{image}']);
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <a href="javascript:;" onclick="history.go(-1)">返回</a>
                                    <?=  Html::submitButton('保 存',['class'=>'btnsubmit']) ?>
                                </td>
                            </tr>

                        </table>

                        <?php ActiveForm::end(); ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="aside">
            <div class="list_nav borbox">
                <h2 class="tit2">
                    <span class="txta">自助服务</span>
                </h2>
                <div class="det">
                    <ul>
                        <li><a href="#">墓碑墓型</a></li>
                        <li><a href="#">远程祭祀</a></li>
                        <li><a href="#">网上订花</a></li>
                        <li><a href="#">随葬用品</a></li>
                        <li><a href="#">瓷像制作</a></li>
                    </ul>
                </div>
            </div>
            <div class="record borbox">
                <h2 class="tit2">
                    <span class="txtb">浏览过......</span>
                </h2>
                <div class="det clearfix">
                    <div class="items">
                        <div class="right">
                            <a href="#">这是标题1</a>
                            <p>这是内容内容...</p>
                        </div>
                        <a class="img" href="#"><img width="80" height="80" src="/theme/m2/static/gls/img/product/a_03.jpg" alt="" /></a>
                    </div>
                    <div class="items">
                        <div class="right">
                            <a href="#">这是标题1</a>
                            <p>这是内容内容...</p>
                        </div>
                        <a class="img" href="#"><img width="80" height="80" src="/theme/m2/static/gls/img/product/a_03.jpg" alt="" /></a>
                    </div>
                    <div class="items">
                        <div class="right">
                            <a href="#">这是标题1</a>
                            <p>这是内容内容...</p>
                        </div>
                        <a class="img" href="#"><img width="80" height="80" src="/theme/m2/static/gls/img/product/a_03.jpg" alt="" /></a>
                    </div>
                    <a href="" class="right">清空</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('cate') ?>
$(function () {
// 日期插件
    $('#pre-date').datepicker({
        dateFormat : "yy-mm-dd",
        minDate : "<?=date('Y-m-d', strtotime('+2 day'))?>",
    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>
