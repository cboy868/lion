<?php
use yii\helpers\Url;
use app\modules\grave\models\Grave;
use kartik\select2\Select2;
use app\core\widgets\ActiveForm;
use yii\bootstrap\Modal;

\app\assets\JqueryuiAsset::register($this);

$this->title = '我的工作台';
$this->params['breadcrumbs'][] = $this->title;
$this->params['profile_nav'] = 'admin';
?>

<style type="text/css">
    .fa-app{
        display: block;
        margin-bottom: 5px;
    }
    .btn img{
        width:48px;
        height: 48px;
    }
    .widget-main .btn-default{
        /*border-radius: 10px;*/
        margin: 5px;
        width: 78px;
    }
    .gsearch input{margin-top: 5px;margin-bottom:5px;}
    .gsearch .select2-container{
        width: 200px;
        float: left;
        margin-right:10px;
    }
    .select2-container--krajee .select2-selection{
        border-radius: 0;
    }
    .select2-container--krajee .select2-selection--single{
        /*margin-top:3px;*/
        height:37px;
    }


    .select2-container--krajee .select2-selection--single .select2-selection__arrow{
        /*top:3px;*/
        height:36px;
    }
    .table-tombs > tbody > tr > td{
        vertical-align: middle;
    }
</style>

<?php
Modal::begin([
    'header' => '<h4 class="modal-title">业务操作</h4>',
    'id' => 'modalAdd',
    'size' => Modal::SIZE_LARGE,
    'footer' => '<button class="btn btn-info" data-dismiss="modal">取消</button>',
]) ;

echo '<div id="modalContent"></div>';

Modal::end();
?>

<?php
Modal::begin([
    'header' => '<h4 class="modal-title"></h4>',
    'id' => 'modalEdit',
    'clientOptions' => ['backdrop' => 'static', 'show' => false]
    // 'size' => 'modal'
]) ;

echo '<div id="editContent"></div>';

Modal::end();
?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-md-6">
                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <div style="border: 1px solid #ccc;border-radius: 3px;padding:5px;">

                                <?php $form = ActiveForm::searchBegin();?>

                                <?php

                                $form->fieldConfig['options']['style']='width:200px;';
                                $form->fieldConfig['options']['class']='form-group ';
                                $form->options['id'] = 'search-tomb';
                                ?>

                                <?= $form->field($searchModel, 'grave_id')->textInput()->widget(Select2::classname(),[
                                    'data' => Grave::selTree(['is_leaf'=>1], 0, ''),
                                    'size' => Select2::MEDIUM,
                                    'options' => [
                                        'placeholder' => " --- 请选择墓区 --- ",
                                        // 'options' => $options,
                                        'class' => 'form-control input-lg gsel',
                                        'style' => 'width:200px;'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label(false)?>

                                <?php

                                $form->fieldConfig['options']['style']='';

                                ?>

                                <?=$form->field($searchModel, 'row')
                                    ->textInput(['class'=>'form-control input-lg','placeholder'=>'排','style'=>'width:60px;'])
                                    ->label(false)?>


                                <?=$form->field($searchModel, 'col')
                                    ->textInput(['class'=>'form-control input-lg','placeholder'=>'列','style'=>'width:60px;'])
                                    ->label(false)?>
                                <br>

                                <?=$form->field($searchModel, 'customer_name')
                                    ->textInput(['class'=>'form-control input-lg','placeholder'=>'客户名','style'=>'width:120px;'])
                                    ->label(false)?>


                                <?=$form->field($searchModel, 'mobile')
                                    ->textInput(['class'=>'form-control input-lg','placeholder'=>'客户手机号'])
                                    ->label(false)?>

                                <button class="btn btn-info btn-lg btn-search-tomb"><i class="fa fa-search"></i> 查找 </button>
                                <button class="btn btn-danger btn-lg reset" type="reset">重置</button>

                                <?php ActiveForm::end(); ?>

                                <div class="table-box">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!--
                <div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
                    <div class="widget-body">
                        <div class="widget-main padding-12 no-padding-left no-padding-right">
                            <div style="border: 1px solid #ccc;border-radius: 3px;padding:5px;">
                                <a href="#"
                                   class='btn btn-info'
                                   onclick="return false">这里是最重要的几个按扭</a>
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'announce'])?>

                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'task'])?>

                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'client'])?>

                <?=\app\modules\grave\widgets\Bench::widget(['name'=>'tombs'])?>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('cate') ?>
$(function(){
    $('.btn-search-tomb').click(function (e) {
        e.preventDefault();
        var data = $("#search-tomb").serialize();
        $('.table-box').load("<?=Url::toRoute(['/admin/default/tombs'])?>", data);
    });

    $('.reset').click(function(e){
        $('.table-box').html('');
    });

    $('.form-control').change(function(e){
        e.preventDefault();
        var val = $(this).val();
        if (!val){return false;}
        var data = $("#search-tomb").serialize();
        $('.table-box').load("<?=Url::toRoute(['/admin/default/tombs'])?>", data);
    });
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>