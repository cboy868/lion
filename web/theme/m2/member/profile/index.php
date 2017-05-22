<?php
use app\core\helpers\Url;
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
?>
<style>
    input, select,textarea{
        font-size: 25px;
        padding: 5px;
    }
    label{
        font-size: 20px;
    }
    .field{
        margin-bottom:10px;
    }
</style>
<div id="main-content">
    <div class="setting">
        <h2>个人设置</h2>
        <!-- 个人设置导航 start -->
        <div class="tab-header">
            <ul class="tabs clearfix">
                <li class="curr">
                    <a href="<?=Url::toRoute(['/user/member/profile/index'])?>">个人设置</a>
                </li>
                <li>
                    <a href="<?=Url::toRoute(['/user/member/profile/avatar'])?>">修改头像</a>
                </li>
                <li>
                    <a href="<?=Url::toRoute(['/user/member/profile/passwd'])?>">修改密码</a>
                </li>
            </ul>
        </div>

        <div class="setting-info">


<?php $form = ActiveForm::memberBegin(); ?>

    <div class="xb6 xl12">
        <?= $form->field($addition, 'real_name')->textInput(['maxlength' => true])->label('真实姓名') ?>
        <?= $form->field($addition, 'gender')->radioList(['1'=> '男', '2'=>'女'])->label('性别') ?>
        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label('手机号') ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('邮箱') ?>
        <?= $form->field($addition, 'qq')->textInput(['maxlength' => true]) ?>
        <?= $form->field($addition, 'address')->textArea(['style'=>'width:500px;height:100px;']) ?>
    </div>


    <?php foreach ($attach as $k => $v): ?>
        <div class="xb6 xl12">
        <?php if ($v['html'] == 'input'): ?>
            <?= $form->field($addition, $v['name'])->textInput(['value'=>isset($addition)?$addition->$v['name']:'']) ?>
        <?php elseif($v['html'] == 'textarea'): ?>
            <?= $form->field($addition, $v['name'])->textarea(['rows' => 6, 'value'=>isset($addition)?$addition->$v['name']:'']) ?>
        <?php elseif($v['html'] == 'fulltext'): ?>
            <?= $form->field($addition,$v['name'])->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'post', 'use'=>'ue'], 'value'=>isset($addition)?$addition->$v['name']:''])->label($v['title']); ?>
        <?php endif ?>
        </div>
    <?php endforeach ?>


    <div class="xb12 xl12">
        <div class="form-group">
            <div class="x4">
                <?=  Html::submitButton('保 存', ['class' => 'button button-block bg-sub']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>
        </div>

    </div>
</div>