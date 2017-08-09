<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\ActiveForm;
use app\core\models\Attachment;
use yii\bootstrap\Modal;

\app\assets\ExtAsset::register($this);
\app\assets\PluploadAssets::register($this);


$this->title = '修改纪念馆基本信息';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

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
        <div class="row">
            <style>
                .panel-heading .nav-tabs {
                    margin: -17px -20px;
                }
                .panel-body{
                    padding:0;
                }
                .tab-content{
                    border-top:none;
                }
                .panel{
                    border:none;
                }


            </style>
            <div class="col-xs-2">
                <div class="list-group no-radius no-border no-bg ">
                    <a href="#" class="list-group-item">基本信息</a>
                    <a href="#" class="list-group-item active">逝者资料</a>
                    <a href="#" class="list-group-item ">档案资料</a>
                    <!--                    <a href="#" class="list-group-item">模板设置</a>-->
                    <a href="#" class="list-group-item">追忆文章</a>
                    <a href="#" class="list-group-item">回忆相册</a>
                    <a href="#" class="list-group-item">祝福管理</a>
                </div>
            </div>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>
                <div class="page-header">
                    <h1>修改逝者资料

                        <small>
                            <div class="pull-right nc">
                                <a href="<?=Url::to(['create-dead', 'id'=>$model->id])?>" class='btn btn-danger btn-sm modalAddButton'
                                   data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>添加逝者</a>
                            </div>
                        </small>
                    </h1>

                </div>


                    <div class="row row-sm">
                        <div class="panel-body">
                            <section class="panel panel-default">
                                <header class="panel-heading bg-light">
                                    <ul class="nav nav-tabs" id="sel_template_tab">
                                        <?php foreach ($deads as $k=>$dead):?>
                                        <li class="<?php if($k==0)echo'active'?>">
                                            <a data-toggle="tab" href="#d_<?=$k?>">
                                                <?=$dead->dead_name?>
                                            </a>
                                        </li>
                                        <?php endforeach;?>

                                    </ul>
                                </header>
                                <div class="panel-body wrapper-sm padder-v">
                                    <div class="tab-content">
                                        <?php foreach ($deads as $k=>$dead):?>
                                        <div id="d_<?=$k?>" class="tab-pane fade <?php if($k==0)echo'active in'?>">
                                            <?php $form = ActiveForm::begin(); ?>
                                            <div class="form-group field-dead-dead_name required">
                                                <label class="control-label" for="dead-dead_name">头像</label>

                                                <div style="">
                                                    <a href="javascript:;" id="filePicker-<?=$k?>"
                                                       class=" filelist-<?=$k?> filePicker"
                                                       style="max-width:380px;max-height:280px;"
                                                       rid="<?=$dead->id?>"
                                                       data-url="<?=Url::toRoute(["pl-upload"])?>"
                                                       data-res_name="dead"
                                                       data-use="original">
                                                        <img src="<?=Attachment::getById($dead->avatar, '380x265', '/static/images/up.png')?>"  style="max-height: 100px;max-width: 100px;">
                                                        <?= $form->field($dead, "[$k]avatar")->hiddenInput(['class'=>'avatar', 'value'=>$dead->avatar])->label(false) ?>
                                                    </a>
                                                </div>

                                                <div class="help-block"></div>
                                            </div>

                                            <?= $form->field($dead, "[$k]dead_name")->textInput(['maxlength' => true]) ?>

                                            <?= $form->field($dead, "[$k]second_name")->textInput()->label('别名') ?>

                                            <?php
                                            if ($dead->dead_title && !in_array($dead->dead_title, $dead_titles)) {
                                                $dead_titles[$dead->dead_title] = $dead->dead_title;
                                            }
                                            ?>
                                            <?= $form->field($dead, "[$k]dead_title")->dropDownList($dead_titles,[
                                                'class'=>'selize-rel'
                                            ])->hint('如无选项 请直接输入'); ?>


                                            <?= $form->field($dead, "[$k]birth")->textInput(['maxlength' => true, 'dt'=>'true', 'dt-year'=>'true', 'dt-month'=>'true']) ?>

                                            <?= $form->field($dead, "[$k]fete")->textInput(['maxlength' => true,'dt'=>'true','dt-year'=>'true', 'dt-month'=>'true'])->label('去逝日期') ?>

                                            <?= $form->field($dead, "[$k]gender")->radioList([1=>'男',2=>'女']) ?>

                                            <?= $form->field($dead, "[$k]age")->textInput() ?>



                                            <?= $form->field($dead, "[$k]birth_place")->textarea(['rows'=>5]) ?>

                                            <div class="xb12 xl12">
                                                <div class="form-group">
                                                    <div class="x1-move x4">
                                                        <?=  Html::submitButton(' 保 存 ', ['class' => 'button bg-sub btn btn-success btn-lg','style'=>'width:100px;']) ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php ActiveForm::end(); ?>
                                        </div>
                                        <?php endforeach;?>

                                        <div class="hr hr-18 dotted hr-double" style="clear: both;"></div>
                                    </div>
                                </div>
                            </section>
                        </div>

                    </div>

                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('cate') ?>
$(function(){
    $('.selize-rel').each(function(index, item){
        var $this = $(item);
        if ( !$this.data('select-init') ) {
            $this.selectize({
                create: true
            });
        }
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>




