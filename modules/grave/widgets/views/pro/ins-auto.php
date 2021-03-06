<?php

use app\modules\grave\models\Tomb;
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\modules\grave\models\Ins;
use app\assets\ExtAsset;
// use app\assets\PluploaduiAssets;
use app\core\models\Attachment;
use app\core\widgets\Ueditor\Ueditor;
use app\assets\PluploadAssets;
// PluploaduiAssets::register($this);
ExtAsset::register($this);
PluploadAssets::register($this);
\app\assets\ColorBoxAsset::register($this);
?>
<style>
    .table > thead > tr > th, .table > tbody > tr > th,
    .table > tfoot > tr > th, .table > thead > tr > td,
    .table > tbody > tr > td, .table > tfoot > tr > td{
        padding:2px;
    }
</style>
<!--碑文信息-->
<div class="widget-box transparent ui-sortable-handle">
    <div class="widget-header">
        <h4 class="widget-title lighter">4、碑文</h4>

        <div class="widget-toolbar no-border">

            <a href="#collapseIns"
               data-toggle="collapse"
               aria-expanded="false"
               aria-controls="collapseIns">
                <i class="ace-icon fa fa-chevron-down"></i>
                编辑
            </a>

        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main padding-6 no-padding-left no-padding-right">
            <p>
                办事员:沈河 李小丰，导购员:小张三
            </p>
            <p>
                客户：李四先生(18588887777),邮箱:abc@qq.com
            </p>
            <p>
                地址：河南洛阳凤后山21号
            </p>
        </div>

        <div class="collapse" id="collapseIns">
            <div class="well" id="ins-container">
                <?php
                $tomb = Tomb::findOne(Yii::$app->request->get('tomb_id'));
                $back = $ins_info['back'];
                $front = $ins_info['front'];
                ?>

                <?php if ($tomb->hasIns()): ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img class="img-rounded" style="float:left;max-height: 100px;max-width: 100px;" src="<?=$goods->getThumb('100x100')?>">

                        <div style="display:inline-block;float:left;">
                            碑名: <?=$goods->name?> <br>
                            碑属性:
                            <?php foreach ($goods->getAv()['attr'] as $k => $av): ?>
                                <?=$av['attr_name'] ?> : <?=$av['attr_val']?$av['attr_val']:$av['value']?>,
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>

                <!-- Nav tabs -->

                <?php if (!$model->is_confirm):?>

                <div class="row" role="">
                    <?php $form = ActiveForm::begin(['id'=>'auto-ins-form', 'options'=>['class'=> 'form-horizontal']]); ?>
                        <ul class="nav nav-tabs col-xs-12">
                            <li class="sel-type" rel="3">
                                <a href="<?=Url::current(['type'=>0])?>" >上传图片</a>
                            </li>
                            <li class="active sel-type" rel="1">
                                <a href="<?=Url::current(['type'=>1])?>">自动碑文</a>
                            </li>
                            <li class="sel-type" rel="1">
                                <a href="<?=Url::current(['type'=>2])?>">自由碑文</a>
                            </li>
                            <?php if(!$model['is_stand']):?>
                                <span class="pull-right">繁体简体
	                                <select name="is_tc" id="is_tc">
	                                    <option value="0" <?php if ($model->is_tc == 0): ?>selected<?php endif ?>>简体</option>
	                                    <option value="1" <?php if ($model->is_tc == 1): ?>selected<?php endif ?>>繁体</option>
	                                </select>
	                            </span>

                                <span class="pull-right">字体
	                                <select name="font_style" id="font_style">
	                                    <option value="0" <?php if ($model->font == 0): ?>selected<?php endif ?>>华文新魏</option>
	                                    <option value="2" <?php if ($model->font == 2): ?>selected<?php endif ?>>方正隶书</option>
	                                    <option value="3" <?php if ($model->font == 3): ?>selected<?php endif ?>>宋 体</option>
	                                </select>
	                            </span>
                            <?php else:?>
                                <input type="hidden" name="is_tc" value="<?=$model->is_tc?>"/>
                                <input type="hidden" name="font" value="<?=$model->font?>"/>
                            <?php endif;?>

                            <span class="pull-right">碑后文快速修改&nbsp;
                                <select name="text" id="selectback">
                                    <option>点此更换碑后文</option>
                                    <?php foreach ($back_word as $v): ?>
                                        <option value="<?=$v?>"><?=$v?></option>
                                    <?php endforeach ?>
                                    <option value="">空</option>
                                </select>
                            </span>
                        </ul>
                    <?php endif;?>
                    <!-- <form role="form" id='auto-ins-form' method='post' action='' class="tab-content"> -->
                    <div class="col-xs-12">
                        <div class="row">
                        <div class="panel panel-default ">

                            <div id="front_prices" style="display:none;"></div>
                            <div id="back_prices" style="display:none;"></div>

                            <div class="panel-body">
                                <div class="row" id="select-ins">
                                    <div class="col-md-8">
                                        <div class="">
                                            <div class="row-fluid ">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">&nbsp;
                                                        碑前文 <span style="font-size:11px;color:red;">此功能只适用于常规碑文，如果碑文排版过于特殊，请使用图片上传方式保存碑文</span>
                                                    </div>
                                                    <div class="panel-body front_images">
                                                        <?php foreach ($cases['front_cases'] as $case): ?>
                                                            <div style="float:left;" class="ins_image">
                                                                <img cfg_id="<?=$case['cfg_id']?>" case_id="<?=$case['id']?>" class="img-thumbnail sel <?php if ($case['id'] == $cases['front_current_case_id']): ?>front_selected<?php endif ?>" alt="140x140" src="<?=$case['img']?>" style="width: 140px; height: 140px;" rel="front">
                                                                <div class="caption">
                                                                    <h5><?=$case['note']?>
                                                                        <span class="sel_style">
                                                                        <?php if ($case['id'] == $cases['front_current_case_id']): ?>
                                                                            (<i class="red fa fa-check fa-2"></i>)
                                                                        <?php endif ?>
                                                                        </span>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="row-fluid">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">&nbsp;
                                                    碑后文
                                                </div>
                                                <div class="panel-body back_images">
                                                    <?php foreach ($cases['back_cases'] as $case): ?>
                                                        <div style="float:left;">
                                                            <img cfg_id="<?=$case['cfg_id']?>" case_id="<?=$case['id']?>" class="img-thumbnail sel <?php if ($case['id'] == $cases['back_current_case_id']): ?>back_selected<?php endif ?>" alt="140x140" src="<?=$case['img']?>" rel="back" style="width: 140px; height: 140px;">
                                                            <div class="caption">
                                                                <h5><?=$case['note']?>
                                                                    <span class="sel_style">
                                                                        <?php if ($case['id'] == $cases['back_current_case_id']): ?>
                                                                            (<i class="red fa fa-check fa-2"></i>)
                                                                        <?php endif ?>
                                                                    </span>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>

                                                </div>

                                            </div>
                                        </div><!-- PAGE CONTENT ENDS -->
                                    </div>


                                    <div class="col-xs-8">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-5">
                                                <div class="thumbnail">
                                                    <a href="<?=$model->getImg('front')?>" class="artimg ">
                                                        <img class="front_img image" src="<?=$model->getImg('front')?>" alt="...">
                                                        <input type="hidden" name="front_img" />
                                                    </a>
                                                    <div class="caption">
                                                        <h3>碑前文</h3>
                                                        <p> 大字<i class='front_big_count'>0</i> 小字<i class='front_small_count'>0</i>&nbsp;
                                                            <span class="label_kezi">
							                       刻字费<i class='front_letter_price'>0</i>元&nbsp;
							                       颜料费<i class='front_paint_price'>0</i>元&nbsp;
	                                                </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-5">
                                                <div class="thumbnail">
                                                    <a href="<?=$model->getImg('back')?>" class="artimg">
                                                        <img class="back_img image" src="<?=$model->getImg('back')?>" alt="...">
                                                        <input type="hidden" name="back_img" />
                                                    </a>
                                                    <div class="caption">
                                                        <h3>碑后文</h3>
                                                        <p> 大字<i class='back_big_count'>0</i> 小字<i class='back_small_count'>0</i>&nbsp;
                                                            <span class="label_kezi">
							                       刻字费<i class='back_letter_price'>0</i>元&nbsp;
							                       颜料费<i class='back_paint_price'>0</i>元&nbsp;
	                                                </span>
                                                        </p>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4" >
                                        <div style="border:1px solid #ccc;border-radius: 5px;">
                                            <table class="table noborder" style="margin-bottom: 5px;">
                                                <caption>公共信息</caption>
                                                <tr>
                                                    <td>生于</td>
                                                    <td><input type="text" name="front[born][content]" class="input-sm" value="<?=isset($front['born'][0]['content']) ? $front['born'][0]['content'] : ''?>"></td>
                                                    <td>故于</td>
                                                    <td><input type="text" name="front[die][content]" class="form-control input-sm" value="<?=isset($front['die'][0]['content']) ? $front['die'][0]['content'] : ''?>"></td>
                                                </tr>

                                                <tr>
                                                    <td>尊称</td>
                                                    <td><input type="text" name="front[honorific][content]" class="form-control input-sm" value="<?=isset($front['honorific'][0]['content']) ? $front['honorific'][0]['content'] : ''?>"></td>
                                                    <td>之墓</td>
                                                    <td><input name="front[tail][content]" type="text" class="form-control input-sm" value="<?=isset($front['tail'][0]['content']) ? $front['tail'][0]['content'] : ''?>"></td>
                                                </tr>

                                                <tr>
                                                    <td>落款</td><td><input type="text" name="front[inscribe][content]" class="form-control input-sm" value="<?= isset($front['inscribe'][0]['content']) ? $front['inscribe'][0]['content'] : '' ?>"></td>
                                                    <td>落款时间</td><td><input type="text" name="front[inscribe_date][content]"  class="form-control input-sm" value="<?=isset($front['inscribe_date'][0]['content']) ? $front['inscribe_date'][0]['content'] : ''?>"></td>
                                                </tr>

                                                <tr>
                                                    <td>享年</td><td><input type="text" name="front[agelabel1][content]" class="form-control input-sm" value="<?=isset($front['agelabel1'][0]['content']) ? $front['agelabel1'][0]['content'] : ''?>"></td>
                                                    <td>享年尾</td><td><input type="text" name="front[agelabel2][content]"  class="form-control input-sm" value="<?=isset($front['agelabel2'][0]['content']) ? $front['agelabel2'][0]['content'] : ''?>"></td>
                                                </tr>

                                                <tr>
                                                    <?php if($is_god):?>
                                                        <td>圣名标签</td>
                                                        <td><input type="text" name="front[second_name_label][content]" class="form-control input-sm" value="<?=isset($front['second_name_label'][0]['content']) ? $front['second_name_label'][0]['content'] : ''?>"></td>
                                                    <?php endif;?>
                                                </tr>
                                            </table>
                                            <?php foreach ($front['dead'] as $key=>$vo): ?>

                                                <?php if($dead_list[$key]['is_ins']==0):?>
                                                <?php else:?>
                                                    <table class="table noborder detail detail-<?=$key?>" style="margin-bottom: 0;">
                                                        <caption><?=$vo['title']['content']?> <?=$vo['name']['content']?></caption>
                                                        <input type="hidden" name="dead[<?=$key?>][name][is_die]"  value="<?=$vo['name']['is_die']?>" />
                                                        <tr>
                                                            <td>称谓</td>
                                                            <td><input type="text" name="dead[<?=$key?>][title][content]" class="form-control input-sm" value="<?=$vo['title']['content']?>" /></td>
                                                            <td>姓名</td>
                                                            <td><input type="text" name="dead[<?=$key?>][name][content]" class="form-control input-sm" value="<?=$vo['name']['content']?>" /></td>
                                                        </tr>

                                                        <tr>
                                                            <td>生日</td>
                                                            <td><input name="dead[<?=$key?>][birth][content]" value="<?=$vo['birth']['content']?>"  type="text" class="form-control input-sm"></td>
                                                            <td>携子</td>
                                                            <td><input name="dead[<?=$key?>][follow][content]" value="" type="text" class="form-control input-sm"></td>
                                                        </tr>

                                                        <?php if($dead_list[$key]['is_alive']==0):?>
                                                            <tr>
                                                                <td>祭日</td><td><input name="dead[<?=$key?>][fete][content]" value="<?=$vo['fete']['content']?>"  type="text" class="form-control input-sm"></td>
                                                                <td>享年</td><td><input name="dead[<?=$key?>][age][content]" value="<?=$vo['age']['content']?>" type="text" class="form-control input-sm"></td>
                                                            </tr>
                                                        <?php endif;?>
                                                        <notempty name="is_god">
                                                            <tr>
                                                                <td>圣名</td>
                                                                <td><input  name="dead[<?=$key?>][second_name][content]" value="<?=$vo['second_name']['content']?>" type="text" class="form-control input-sm"></td>
                                                            </tr>
                                                        </notempty>
                                                    </table>
                                                <?php endif;?>
                                            <?php endforeach ?>
                                        </div>
                                        <div style="border:1px solid #ccc;border-radius: 5px;">

                                            <table class="table noborder back-line">
                                                <caption>碑后文</caption>
                                                <?php foreach ($back['main']['content'] as $key => $bk): ?>
                                                    <tr class="main-line">
                                                        <td>正文</td>
                                                        <td><input name="back[main][content][]" value="<?=$bk?>" type="text" class="form-control input-sm"></td>
                                                        <td  colspan="2">
                                                            <eq name="key" value="0">
                                                                <button type="button" class="btn btn-default add-line"> 添 加 </button>
                                                            </eq>

                                                            <neq name="key" value="0">
                                                                <button type="button" class="btn btn-default del-line"> 删 除 </button>
                                                            </neq>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">明细</div>
                            <div class="panel-body  form-horizontal row" role="form">
                                <?php
                                $form->fieldConfig['labelOptions']['class']='control-label col-sm-3';
                                $form->fieldConfig['template'] = '{label}<div class="col-sm-9">{input}{hint}{error}</div>';

                                ?>
                                <div class="col-xs-6">
                                    <?= $form->field($model, 'paint')->dropDownList(Ins::paint(), ['style'=>'width:70%;padding: 6px 2px;', 'class'=>'paint']) ?>
                                    <?php //echo $form->field($model, 'new_font_num')->textInput(['style'=>'width:70%', 'id'=>'letter_num'])->label('总字数') ?>
                                    <?= $form->field($model, 'new_big_num')->textInput(['style'=>'width:70%', 'id'=>'big_new'])->label('大字') ?>
                                    <?= $form->field($model, 'new_small_num')->textInput(['style'=>'width:70%', 'id'=>'small_new'])->label('小字') ?>
                                    <?= $form->field($model, 'paint_price')->textInput(['style'=>'width:70%', 'id'=>'paint_price']) ?>
                                    <?= $form->field($model, 'letter_price')->textInput(['style'=>'width:70%', 'id'=>'letter_price']) ?>
                                    <?= $form->field($model, 'tc_price')->textInput(['style'=>'width:70%', 'id'=>'tc_price']) ?>

                                    <?= $form->field($model, 'pre_finish')->textInput([
                                        'style'=>'width:70%',
                                        'dt'=>'true',
                                        'dt-year' => 'true',
                                        'dt-month' =>'true',
                                        'class'=>'dt_pre_finished'
                                    ])->hint('立碑日期在三天内，需收加急费') ?>
                                </div>
                                <div class="col-xs-5">

                                    <?php
                                    $form->fieldConfig['labelOptions']['class']='control-label';
                                    $form->fieldConfig['template'] = '{label}{input}{hint}{error}';
                                    ?>
                                    <?= $form->field($model, 'note')->textArea(['rows'=>5])->label('碑文备注') ?>

                                </div>
                                <?php if(!empty($insdes)):?>
                                    <div class="col-xs-12">
                                        <h3>碑文备注</h3>
                                        <table class="table insnote">
                                            <?php foreach ($insdes as $de): ?>
                                                <tr>
                                                    <td style='width:80px;'>
                                                        <?=$de['username']?><br/>
                                                        <textarea  style="display: none" class="con"><?=$de['content']?></textarea>
                                                        <a class="modifyNote" title="修改" rid="<?=$de['id']?>" href="#" rel="<?=$de['res_id']?>" style="margin-left:8px;">
                                                            <i class="icon-edit bigger-230"></i>修改备注
                                                        </a>
                                                    </td>
                                                    <td>添加时间：<?=$de['add_time']?><br/><?=$de['content']?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </table>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <!-- Button trigger modal -->

                    <input type="hidden" name="tomb_id" value="<?=$model->tomb_id?>" />
                    <input type="hidden" name="type" value="<?=$model->type?>" />

                    <input type="hidden" name="big_num" value="<?=$model->big_num?>" />
                    <input type="hidden" name="small_num" value="<?=$model->small_num?>" />

                    <input type="hidden" name="front_case" value="" />
                    <input type="hidden" name="back_case" value="" />
                    <input type="hidden" name="cover_case" value="" />

                    <div class="cache"></div>

                    <div class="text-center cols-md-12">

                        <div class="form-group">
                            <div class="col-sm-12" style="text-align:center;">
                                <?php if ($model->is_confirm): ?>
                                    <span class="btn btn-default btn-lg" type="button">碑文已确认，不可修改</span>
                                <?php else:?>
                                    <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg  save-ins', 'style'=>'padding: 10px 36px']) ?>
                                <?php endif;?>
                            </div>
                        </div>
                        <!-- </form> -->
                        <?php ActiveForm::end(); ?>
                        <hr />
                    </div><!--auto row-->

                </div>


                <?php else: ?>

                    <?php
                    $goods = $this->context->module->params['goods'];
                    $ins = $goods['cate']['ins'];
                    ?>
                    <div class="alert alert-success" role="alert" style="height: 100px; text-align: center; font-size: 40px;">
                        请
                        <small>
                            <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$ins, 'tomb_id'=>Yii::$app->request->get('tomb_id')])?>" class="modalAddButton btn btn-info" target="_blank" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                                购买墓碑
                            </a>
                        </small>
                    </div>
                <?php endif ?>


            </div>
        </div>
    </div>

</div>


<?php $this->beginBlock('up') ?>
var fee = eval('(' + '<?=json_encode($fee)?>'+ ')');
$(function(){


    $('#collapseIns').on('show.bs.collapse', function () {


        $("body").animate({
            scrollTop: parseInt($("#collapseIns").closest('.widget-body').position().top)+200,
            duration: 100,
            easing: "swing"
        });


    })




    var changed = "<?=$model->changed?>";
    var insContainer = $('#ins-container');
    var selIns = insContainer.find('.sel');

    $('.btn-dis').click(function(e){
        e.preventDefault();
        var rel = $(this).attr('rel');
        $('.'+rel).toggle();
    });

    $(".image").click(function(e) {
        e.preventDefault();
        var title = $(this).attr('title');
        $(".artimg").colorbox({
            rel: 'artimg',
            maxWidth:'800px',
            maxHeight:'800px',
            next:'',
            previous:'',
            close:'',
            current:""
        });
    });

    auto(changed);
    <?php if ($model->type == 2): ?>
    auto(true);
    <?php endif;?>


    $('.modifyNote').click(function(){
        var url = '{:U("record/addnote")}';
        var res_id   = $(this).attr('rel');
        var id = $(this).attr('rid');
        var type = 'inscription';
        var con = $(this).siblings('.con').val();
        bootbox.dialog({
            title: "编辑备注",
            message: '<textarea name="" id="add_note" style="height:100px;width:400px;">'+con+'</textarea>',
            buttons:
                {
                    "success" :
                        {
                            "label" : "<i class='icon-ok'></i> 修改",
                            "className" : "btn-sm btn-success",
                            "callback": function() {
                                var con = $('#add_note').val();
                                var data = {res_name:type,res_id:res_id,content:con,id:id};
                                $.post(url, data, function(json){
                                    if (json.status == 1) {
                                        window.location.reload();
                                    } else {
                                        alert(json.msg);
                                    }
                                },'json');
                            }
                        }
                }
        })

        return false;
    });



    selIns.click(function(e){
        e.preventDefault();
        var driect = $(this).attr('rel');
        var cla = driect + '_selected';
        //调整样式
        $(this).closest('.panel-body').find('.sel_style').html('');
        $(this).parent().find('.sel_style').html('(<i class="red fa fa-check fa-2"></i>)');

        //选择标识
        $(this).closest('.' + driect + '_images').find('img').removeClass(cla);
        $(this).addClass(cla);


        searchCaseId();
        getImage(cla);
        getPrice();

    });


    $('.paint', insContainer).change(function(){
        getPrice();
        if ($(this).val() == 4) {
            $('.label_kezi').hide();
        } else {
            $('.label_kezi').show();
        };
    });

    $('.front-edit-save', insContainer).click(function(){
        getImage('front_selected');
        getPrice();
        $('#ins_front').modal('hide');
    });

    $('.back-edit-save', insContainer).click(function(){
        getImage('back_selected');
        getPrice();
        $('#ins_back').modal('hide');
    });

    $('#selectback', insContainer).change(function(){
        var str = $(this).val();
        var arr = str.split(',');
        $('.back-line .main-line').remove();
        for(k in arr){
            var tr = $('#backclone tr').clone();
            tr.find('input').val(arr[k]);
            if (k==0) {
                tr.find('button.del-line').hide();
            } else {
                tr.find('button.add-line').hide();
            };
            $('.back-line').append(tr);
        }
        getImage('back_selected');
        getPrice();
    });

    $('#font_style', insContainer).change(function(){
        getImage('front_selected');
        getImage('back_selected');
        getPrice();
    });

    // 简繁体切换
    $('#is_tc', insContainer).change(function() {
        getImage('front_selected');
        getImage('back_selected');
        getPrice();
    });


    $('body').on('click','.add-line',function(){
        var obj = $(this).parents('tr');
        var line_obj = obj.clone();
        //line_obj.find('button').removeClass('add-line').addClass('del-line').html('删 除');
        line_obj.find('input').val('');
        $('.back-line').append(line_obj);
    });
    $('body').on('click','.del-line',function(){
        $(this).parents('tr').remove();
    })



    $('.dt_pre_finished ').change(function(){
        var ur = "{$urgent}";
        if (ur == 1) return false;
        urgent();
    });


    $('#big_new, #small_new').change(function(){
        calFee();
    });
})


function getImage(cla){
    var case_id = $('.'+cla).attr('case_id');
    var driect = $('.'+cla).attr('rel');
    var tomb_id = $('input[name=tomb_id]').val();
    var data = $('#auto-ins-form').serialize();
    var url = "<?=Url::toRoute(['/grave/home/ins/sel', 'tomb_id'=>$get['tomb_id']])?>";

    if (url.indexOf('?') >= 0) {
        url += '&case_id=' + case_id;
    } else {
        url += '?case_id=' + case_id;
    }
    if(isNaN(case_id)) return ;
    $.post(url, data, function(xhr){
        if(xhr.status){
            var time = new Date().getTime();
            $('.' + driect + '_img').attr('src', xhr.data+'?time='+time)
                .parent('a')
                .attr('href', xhr.data+'?time='+time)
                .find('input[name='+driect+'_img]')
                .val(xhr.data + '?time=' + time);
        } else {

        }
    },'json');
}

//取价格
function getPrice($type){

    var front_case = $('.front_selected').attr('case_id');
    var back_case = $('.back_selected').attr('case_id');

    var url = "<?=Url::toRoute(['/grave/home/ins/price', 'tomb_id'=>$get['tomb_id']])?>";
    var data = $('#auto-ins-form').serialize();
    var date = +new Date();


    var cache = $('.cache');

    $.post(
        url + '?timstr=' + date + '&front_case='+front_case + '&back_case='+back_case,
        data,
        function(json) {
            if(json.status) {
                var data = json.data;


                $('.front_big_count').html(data.front.big);
                $('.front_small_count').html(data.front.small);
                $('.front_letter_price').html(data.front.letter_big_price + data.front.letter_small_price);
                $('.front_paint_price').html(data.front.paint_big_price + data.front.paint_small_price);


                $('.back_big_count').html(data.back.big);
                $('.back_small_count').html(data.back.small);
                $('.back_letter_price').html(data.back.letter_big_price + data.letter_small_price);
                $('.back_paint_price').html(data.back.paint_big_price + data.paint_small_price);

                $('#letter_price').val(data.total.letter_big_price + data.total.letter_small_price);
                $('#paint_price').val(data.total.paint_big_price + data.total.paint_small_price);
                $('#big_new').val(data.total.big);
                $('#small_new').val(data.total.small);
                $('#tc_price').val(data.tc_fee);
            }

        },'json');
}

function calFee()
{
    var big = $('#big_new').val();
    var small = $('#small_new').val();
    var paint = $('.paint').val();

    var letter = parseInt(big) * fee.letter.big[paint] + parseInt(small) * fee.letter.small[paint];
    var paint = parseInt(big) * fee.paint.big[paint] + parseInt(small) * fee.paint.small[paint];


    if (!isNaN(letter) && !isNaN(paint)) {
        $('#letter_price').val(letter);
        $('#paint_price').val(paint);
    }

}


function searchCaseId(){
    $('input[name=front_case]').val($('.front_selected').attr('case_id'));
    $('input[name=back_case]').val($('.back_selected').attr('case_id'));
    $('input[name=cover_case]').val($('.cover_selected').attr('case_id'));
}

function urgent(){
    var curVal = new Date($('input[name="ins[dt_pre_finished]"]').val());
    var curTime = Date.parse(curVal);
    var dt_tmp = new Date();
    var dt = new Date(dt_tmp.getTime()+60*60*24*3*1000);
    var dt_str = dt.toLocaleDateString();
    var is_second = $('.is_second').val();
    if(is_second) return ;
    if (curTime < dt_tmp.getTime()+60*60*24*2*1000) {
        $('.remind').html(dt_str);
        $('.mnMsg').show();
    } else {
        $('.mnMsg').hide();
    }
}

function auto(changed){

    searchCaseId();

    if (changed == 1) {
        getImage('front_selected');
        getImage('back_selected');
        //getImage('cover_selected');
    } else {
        //如果没有图片，就取新图片
        if ($('.front_img').attr('src') == '#'){
            getImage('front_selected');
        }
        if ($('.back_img').attr('src') == '#'){
            getImage('back_selected');
        }
        if ($('.cover_img').attr('src') == '#'){
            //getImage('cover_selected');
        }
    }
    //如果还没取价格，则新取
    getPrice();
}





<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?>



