<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\wechat\models\Menu;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use \app\modules\wechat\models\MenuMain;


$this->title = '微信菜单';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table td input, table td select{
        width:100%;
    }
    .hint-block.success{
        color:green;
    }
    .hint-block.wrong{
        color:red;
    }
    /*.main-info{*/
        /*border: 1px solid #ccc;*/
        /*margin-left: 15px;*/
        /*margin-right: 15px;*/
        /*pading-top: 15px;*/
        /*padding-top: 15px;*/
        /*padding-left: 15px;*/
        /*margin-bottom:15px;*/
    /*}*/
</style>

<link rel="stylesheet" href="/css/wechat.css">

<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">

        <?= $this->render('../default/left');?>
        <div class="right-content">
            <div class="page-header">
                <h1>
                    <small>
                        <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create-menu','main_id'=>$model->id],
                            [
                                'class' => 'btn btn-primary btn-sm modalAddButton',
                                'data-loading-text'=>"页面加载中, 请稍后...",
                                'onclick'=>"return false"
                            ]) ?>

                        <?php if ($model->type == MenuMain::TYPE_PERSONAL): ?>
                            <?= Html::a('激活此菜单', ['a-sync', 'id'=>$model->id], ['class'=>'btn btn-danger btn-sm btn-sync']);?>
                        <?php else:?>
                            <?= Html::a('激活此菜单', ['sync', 'id'=>$model->id], ['class'=>'btn btn-danger btn-sm btn-sync']);?>
                        <?php endif;?>
                    </small>
                </h1>
            </div><!-- /.page-header -->


            <?php
            Modal::begin([
                'header' => '新增',
                'id' => 'modalAdd',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
            ?>

            <?php
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                'clientOptions' => ['backdrop' => 'static', 'show' => false]
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
            ?>

            <div class="row">
                <?=\app\core\widgets\Alert::widget(); ?>
                <div class="col-xs-12 search-box">
                    <div class="alert alert-info" style="padding:5px;">
                        一级菜单名称名字不多于4个汉字或8个字母, 最多3个<br>
                        二级菜单名称名字不多于8个汉字或16个字母,最多7个
                    </div>
                </div>
                <div class="col-xs-12 w-form">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'name')->textInput(['class'=>'form-control main-name'])->hint('可在此修改菜单组名称') ?>
                    <?php if($type == MenuMain::TYPE_PERSONAL): ?>
                        <?=  $this->render('_ruleform', ['model'=>$model, 'form'=>$form])?>
                    <?php endif;?>
                </div>

                <div class="col-xs-12 merchant-index">

                    <?=  $this->render('_form', ['menus'=>$menus,'typemap'=>$typemap])?>

                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->

                <?php ActiveForm::end(); ?>
            </div><!-- /.row -->

        </div>
    </div>
</div>


<?php $this->beginBlock('tree') ?>
$(function(){

    $('.main-name').change(function(){
        var name = $(this).val();
        var id = "<?=$model->id?>";
        var csrf = "<?=Yii::$app->request->getCsrfToken()?>";


        var data = {id:id, name:name,_csrf:csrf};
        var that = this;
        $.post("<?=Url::toRoute(['update-main'])?>",data,function(xhr){
            if(xhr.status){
                $(that).siblings('.hint-block').text('菜单组名修改成功').addClass('success').removeClass('wrong');
            } else {
                $(that).siblings('.hint-block').text('菜单组名修改失败').addClass('wrong').removeClass('success');
            }

        },'json');

    });

    $('.w-form form input, .w-form form select').change(function(){
        var data = $('.w-form form').serialize();

        var that = this;
        $.post("<?=Url::toRoute(['update-main', 'id'=>Yii::$app->request->get("id")])?>",data,function(xhr){
            if(xhr.status){
                $(that).siblings('.hint-block').text('菜单信息修改成功').addClass('success').removeClass('wrong');
            } else {
                $(that).siblings('.hint-block').text('菜单信息修改失败').addClass('wrong').removeClass('success');
            }

        },'json');

    });


    $('.btn-sync').click(function(e){
        e.preventDefault();

        var url = $(this).attr('href');

        $.get(url, {}, function(xhr){
            if (xhr.status) {
                location.reload();
            }
        },'json');
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>


