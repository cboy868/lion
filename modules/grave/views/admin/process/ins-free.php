<?php
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\modules\grave\models\Ins;
use app\assets\ExtAsset;
// use app\assets\PluploaduiAssets;
use app\core\models\Attachment;
use app\core\widgets\Ueditor\Ueditor;
use app\modules\grave\models\Tomb;
use app\assets\PluploadAssets;
// PluploaduiAssets::register($this);
ExtAsset::register($this);
PluploadAssets::register($this);
\app\assets\ColorBoxAsset::register($this);
\app\assets\InsCanvasAsset::register($this);
?>

<style type="text/css">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        line-height: 1.4;
        border: none;
    }
    .help-block {
        margin-bottom: 0;
        margin-top: 0;
    }
    .table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td
    {
        padding: 2px;
    }
    /*.detail{display: none;}*/
    .insnote img{max-width: 100px;}
    .blank{
        margin-width:20px;
    }
</style>


<div class="page-content" id="ins-container">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->

        <?=\app\core\widgets\Alert::widget();?>


        <?php
        $tomb = Tomb::findOne(Yii::$app->request->get('tomb_id'));
        $back = $ins_info['back'];
        $front = $ins_info['front'];
        $attach = isset($ins_info['attach']) ? $ins_info['attach'] : [];
        ?>
        <?php if ($tomb->hasIns()): ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <img class="img-rounded" style="float:left;max-height: 100px;max-width: 100px;" src="<?=$goods->getThumb('100x100')?>">

                    <div style="display:inline-block;float:left;margin-left:20px;">
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
                <ul class="nav nav-tabs col-xs-12">
                    <li class="sel-type" rel="3">
                        <a href="<?=Url::current(['type'=>0])?>" >上传图片</a>
                    </li>
                    <li class="sel-type" rel="1">
                        <a href="<?=Url::current(['type'=>1])?>">自动碑文</a>
                    </li>
                    <li class="active sel-type" rel="1">
                        <a href="<?=Url::current(['type'=>2])?>">自由碑文</a>
                    </li>

                </ul>
            <?php endif;?>

            <?php $form = ActiveForm::begin(['id'=>'auto-ins-form', 'options'=>['class'=> 'form-horizontal']]); ?>
            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">&nbsp;
                            <span class="blank">
                                <a  href="javascript:;" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#select-ins">
                                    选择碑文样式
                                </a>
                            </span>
                            <?php if(!$model['is_stand']):?>
                                <span class="blank">繁体简体
                                    <select name="is_tc" id="is_tc">
                                        <option value="0" <?php if ($model->is_tc == 0): ?>selected<?php endif ?>>简体</option>
                                        <option value="1" <?php if ($model->is_tc == 1): ?>selected<?php endif ?>>繁体</option>
                                    </select>
                                </span>
                                <span class="blank">字体
                                    <select name="font_style" id="font_style">
                                        <option value="0" <?php if ($model->font == 0): ?>selected<?php endif ?>>华文新魏</option>
                                        <option value="2" <?php if ($model->font == 2): ?>selected<?php endif ?>>方正隶书</option>
                                        <option value="3" <?php if ($model->font == 3): ?>selected<?php endif ?>>宋 体</option>
                                    </select>
                                </span>
                            <?php else:?>
                                <input type="hidden" name="is_tc" id="is_tc" value="<?=$model->is_tc?>"/>
                                <input type="hidden" name="font" value="<?=$model->font?>"/>
                            <?php endif;?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="select-ins" class="collapse">
                                        <div class="row-fluid ">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">&nbsp;
                                                    碑前文
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
                                        </div><!-- PAGE CONTENT ENDS -->

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
                                </div>
                                <div class="col-lg-12">
                                    <div class="canvas" style="border:1px solid #ccc;;width:702px;float:left;margin-right:20px;">
                                        <div style="font-size:14px;width:100%;padding: 10px;">
                                            <fieldset style="float:left;">
                                                <div id="toolsOptions">
                                                    <button class="tools_trash" type="button">清空</button>&nbsp;&nbsp;&nbsp;
                                                    <button class="tools_download" type="button">下载</button>&nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="btn btn-default"
                                                            id="edit_front"
                                                            data-toggle="modal"
                                                            data-target="#ins_front"
                                                            data-keyboard=false
                                                            data-backdrop="static"
                                                    >
                                                        修改内容
                                                    </button>

                                                    <button type="button" class="btn btn-default"
                                                            data-toggle="modal"
                                                            data-target="#ins_front_attach"
                                                            data-keyboard=false
                                                            data-backdrop="static"
                                                    >
                                                        附加内容
                                                    </button>
                                                </div>

                                            </fieldset>
                                            <div style="clear:both;"></div>
                                        </div>
                                        <canvas id="frontCanvas" height="700" width="700"></canvas>
                                        <input type="hidden" name="front-canvas-img" class="front-canvas-img" >
                                        <img src="" alt="" id="abcde">
                                    </div>

                                    <div class="canvas" style="border:1px solid #ccc;width:702px;float: left;">
                                        <div style="font-size:14px;width:100%;padding: 10px;">
                                            <fieldset style="float:left;">
                                                <div id="toolsOptions">
                                                    <button class="tools_trash" type="button">清空</button>&nbsp;&nbsp;&nbsp;
                                                    <button class="tools_download" type="button">下载</button>&nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="btn btn-default"
                                                            id="edit_back"
                                                            data-toggle="modal"
                                                            data-target="#ins_back"
                                                            data-keyboard=false
                                                            data-backdrop="static"
                                                    >
                                                        修改内容
                                                    </button>&nbsp;
                                                    <button type="button" class="btn btn-default"
                                                            data-toggle="modal"
                                                            data-target="#ins_back_attach"
                                                            data-keyboard=false
                                                            data-backdrop="static"
                                                    >
                                                        附加内容
                                                    </button>
                                                    <span class="pull-right">
                                                        <select name="text" id="selectback" class="form-control">
                                                            <option>点此快速更换碑后文</option>
                                                            <?php foreach ($back_word as $v): ?>
                                                                <option value="<?=$v?>"><?=$v?></option>
                                                            <?php endforeach ?>
                                                            <option value="">空</option>
                                                        </select>
                                                    </span>
                                                </div>

                                            </fieldset>
                                            <div style="clear:both;"></div>
                                        </div>
                                        <canvas id="backCanvas" height="700" width="700"></canvas>
                                        <input type="hidden" name="back-canvas-img" class="back-canvas-img">
                                    </div>
                                </div>
                            </div>
                            <div id="front_prices" style="display:none;"></div>
                            <div id="back_prices" style="display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Tab panes -->
            <div class="row" role="">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">明细 <small style="color:red;">以下自动计算价格做为参考，请核对</small> </div>
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


                <style>
                    .modal .table > thead > tr > th, .table > tbody > tr > th, .table > tbody > tr > td {
                        padding: 2px;
                    }
                </style>
                <!-- Modal -->
                <div class="modal fade" id="ins_front" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">修改碑正文</h4>
                            </div>
                            <div class="modal-body">
                                <div class="panel panel-default">
                                    <div class="panel-heading">公共部分</div>
                                    <div class="panel-body">
                                        <table class="table" style="margin-bottom: 5px;">
                                            <tr>
                                                <td>标签一</td>
                                                <td>
                                                    <input type="text" name="front[born][content]" class="form-control input-sm born0con"
                                                           value="<?=isset($front['born'][0]['content']) ? $front['born'][0]['content'] : ''?>">

                                                    <input type="hidden" name="front[born][pos]" value="<?=isset($front['born'][0]['pos']) ? $front['born'][0]['pos'] : ''?>"
                                                           class="form-control input-sm born0">

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>标签二</td>
                                                <td><input type="text" name="front[die][content]" class="form-control input-sm die0con"
                                                           value="<?=isset($front['die'][0]['content']) ? $front['die'][0]['content'] : ''?>">
                                                    <input type="hidden" name="front[die][pos]" value="<?=isset($front['die'][0]['pos']) ? $front['die'][0]['pos'] : ''?>"
                                                           class="form-control input-sm die0">
                                                </td>
                                            </tr>


                                            <tr>
                                                <td>尊称</td>
                                                <td><input type="text" name="front[honorific][content]" class="form-control input-sm honorific0con"
                                                           value="<?=isset($front['honorific'][0]['content']) ? $front['honorific'][0]['content'] : ''?>">
                                                    <input type="hidden" name="front[honorific][pos]" value="<?=isset($front['honorific'][0]['pos']) ? $front['honorific'][0]['pos'] : ''?>"
                                                           class="form-control input-sm honorific0">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>之墓</td>
                                                <td>
                                                    <input name="front[tail][content]" type="text" class="form-control input-sm tail0con"
                                                           value="<?=isset($front['tail'][0]['content']) ? $front['tail'][0]['content'] : ''?>">
                                                    <input type="hidden" name="front[tail][pos]" value="<?=isset($front['tail'][0]['pos']) ? $front['tail'][0]['pos'] : ''?>"
                                                           class="form-control input-sm tail0">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>落款</td><td>
                                                    <input type="text" name="front[inscribe][content]" class="form-control input-sm inscribe0con"
                                                                      value="<?= isset($front['inscribe'][0]['content']) ? $front['inscribe'][0]['content'] : '' ?>">
                                                    <input type="hidden" name="front[inscribe][pos]" value="<?= isset($front['inscribe'][0]['pos']) ? $front['inscribe'][0]['pos'] : '' ?>"
                                                           class="form-control input-sm inscribe0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>落款时间</td><td><input type="text" name="front[inscribe_date][content]"  class="form-control input-sm inscribe_date0con"
                                                                        value="<?=isset($front['inscribe_date'][0]['content']) ? $front['inscribe_date'][0]['content'] : ''?>">
                                                    <input type="hidden" name="front[inscribe_date][pos]" value="<?=isset($front['inscribe_date'][0]['pos']) ? $front['inscribe_date'][0]['pos'] : ''?>"
                                                           class="form-control input-sm inscribe_date0">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>享年标签</td><td><input type="text" name="front[agelabel1][content]" class="form-control input-sm agelabel1con"
                                                                        value="<?=isset($front['agelabel1'][0]['content']) ? $front['agelabel1'][0]['content'] : ''?>">
                                                    <input type="hidden" name="front[agelabel1][pos]" value="<?=isset($front['agelabel1'][0]['pos']) ? $front['agelabel1'][0]['pos'] : ''?>"
                                                           class="form-control input-sm agelabel1">
                                                </td>
                                                <td>享年尾标签</td><td><input type="text" name="front[agelabel2][content]"  class="form-control input-sm agelabel2con"
                                                                         value="<?=isset($front['agelabel2'][0]['content']) ? $front['agelabel2'][0]['content'] : ''?>">
                                                    <input type="hidden" name="front[agelabel2][pos]" value="<?=isset($front['agelabel2'][0]['pos']) ? $front['agelabel2'][0]['pos'] : ''?>"
                                                           class="form-control input-sm agelabel2">
                                                </td>
                                            </tr>

                                            <tr>
                                                <?php if($is_god):?>
                                                    <td>圣名标签</td>
                                                    <td>
                                                        <input type="text" name="front[second_name_label][content]" class="form-control input-sm second_name_label0con"
                                                               value="<?=isset($front['second_name_label'][0]['content']) ? $front['second_name_label'][0]['content'] : ''?>">

                                                        <input type="hidden" name="front[second_name_label][pos]" value="<?=isset($front['second_name_label'][0]['pos']) ? $front['second_name_label'][0]['pos'] : ''?>"
                                                               class="form-control input-sm second_name_label0">
                                                    </td>
                                                <?php endif;?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel panel-default">

                                    <?php foreach ($front['dead'] as $key=>$vo): ?>

                                        <?php if($dead_list[$key]['is_ins']==0):?>
                                        <?php else:?>
                                            <div class="panel-heading">
                                                <a class="btn btn-info btn-dis btn-xs" href="#" rel="detail-<?=$key?>">
                                                    <?=$vo['title']['content']?> <?=$vo['name']['content']?>
                                                </a>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-noborder detail detail-<?=$key?>" style="margin-bottom: 0;">
                                                    <input type="hidden" name="dead[<?=$key?>][name][is_die]"  value="<?=$vo['name']['is_die']?>" />
                                                    <tr>
                                                        <td>称谓</td>
                                                        <td>
                                                            <input type="text" name="dead[<?=$key?>][title][content]" class="form-control input-sm title<?=$key?>con"
                                                                   value="<?=$vo['title']['content']?>" />
                                                            <input type="hidden" name="dead[<?=$key?>][title][pos]" value="<?=$vo['title']['pos']?>"
                                                                   class="form-control title<?=$key?>">
                                                        </td>
                                                        <td>姓名</td>
                                                        <td><input type="text" name="dead[<?=$key?>][name][content]" class="form-control input-sm name<?=$key?>con"
                                                                   value="<?=$vo['name']['content']?>" />
                                                            <input type="hidden" name="dead[<?=$key?>][name][pos]" value="<?=$vo['name']['pos']?>"
                                                                   class="form-control name<?=$key?>">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>生日</td>
                                                        <td><input name="dead[<?=$key?>][birth][content]"
                                                                   value="<?=$vo['birth']['content']?>"  type="text" class="form-control input-sm birth<?=$key?>con">
                                                            <input type="hidden" name="dead[<?=$key?>][birth][pos]" value="<?=$vo['birth']['pos']?>" class="form-control birth<?=$key?>">
                                                        </td>
                                                        <!--
                                                        <td>携子</td>
                                                        <td><input name="dead[<?=$key?>][follow][content]" value="" type="text" class="form-control input-sm follow<?=$key?>con">
                                                            <input type="hidden" name="dead[<?=$key?>][follow][pos]" class="form-control follow<?=$key?>">
                                                        </td>
                                                        -->
                                                    </tr>

                                                    <?php if($dead_list[$key]['is_alive']==0):?>
                                                        <tr>
                                                            <td>祭日</td><td>
                                                                <input name="dead[<?=$key?>][fete][content]" value="<?=$vo['fete']['content']?>"
                                                                       type="text" class="form-control input-sm fete<?=$key?>con">
                                                                <input type="hidden" name="dead[<?=$key?>][fete][pos]" value="<?=$vo['fete']['pos']?>" class="form-control fete<?=$key?>">
                                                            </td>
                                                            <td>享年</td><td>
                                                                <input name="dead[<?=$key?>][age][content]" value="<?=$vo['age']['content']?>"
                                                                       type="text" class="form-control input-sm age<?=$key?>con">
                                                                <input type="hidden" name="dead[<?=$key?>][age][pos]" value="<?=$vo['age']['pos']?>" class="form-control age<?=$key?>">
                                                            </td>
                                                        </tr>
                                                    <?php endif;?>
                                                    <?php if($is_god):?>
                                                        <tr>
                                                            <td>圣名</td>
                                                            <td>
                                                                <input  name="dead[<?=$key?>][second_name][content]" value="<?=$vo['second_name']['content']?>"
                                                                        type="text" class="form-control input-sm second_name<?=$key?>con">
                                                                <input type="hidden" name="dead[<?=$key?>][second_name][pos]" value="<?=$vo['second_name']['pos']?>"
                                                                       class="form-control second_name<?=$key?>">
                                                            </td>
                                                        </tr>
                                                    <?php endif;?>
                                                </table>
                                            </div>
                                        <?php endif;?>
                                    <?php endforeach ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> 取 消 </button>
                                <button type="button" class="btn btn-primary front-edit-save"> 保 存 </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="ins_back" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content cbox">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">修改碑后文</h4>
                            </div>
                            <div class="modal-body backmain">
                                <table class="table table-noborder back-line">
                                    <?php foreach ($back['main']['content'] as $key => $bk): ?>
                                        <tr class="main-line">
                                            <td>正文</td>
                                            <td>

                                                <input name="back[main][content][]" value="<?=$bk?>" type="text" class="form-control input-sm main<?=$key?>con">
                                                <input type="hidden" name="back[main][pos][]"
                                                       value="<?=isset($back['main']['pos'][$key])?$back['main']['pos'][$key]:''?>"
                                                       class="form-control main<?=$key?>">

                                            </td>
                                            <td  colspan="2">
                                                <button type="button" class="btn btn-default btn-xs del-line"> 删 除 </button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </table>
                                <!-- <a href="#" target="_blank">碑文范例</a> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default add-back"> 添 加 一 行 </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"> 取 消 </button>
                                <button type="button" class="btn btn-primary back-edit-save"> 保 存 </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="ins_front_attach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content cbox">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">碑前文附加字段</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-noborder back-line">
                                    <?php if(isset($attach['front'])):$index=0;?>
                                        <?php foreach ($attach['front'] as $key => $bk): ?>
                                            <tr class="main-line">
                                                <td>
                                                    <input name="attach[front][<?=$index?>][content]" value="<?=$bk['content']?>"
                                                           type="text" class="form-control input-sm attach_front<?=$index?>con">

                                                    <input type="hidden" name="attach[front][<?=$index?>][pos]"
                                                           value="<?=isset($bk['pos'])?$bk['pos']:''?>"
                                                           class="form-control attach_front<?=$index?>">
                                                </td>
                                                <td><label for="">
                                                        <input type="checkbox" name="attach[front][<?=$index?>][is_big]"
                                                               value="1" <?php if(isset($bk['is_big'])){echo "checked";}?>>大字</label></td>
                                                <td colspan="2">
                                                    <button type="button" class="btn btn-default del-line btn-xs"> 删 除 </button>
                                                </td>
                                            </tr>
                                            <?php $index++;endforeach ?>
                                    <?php endif;?>
                                </table>
                                <!-- <a href="#" target="_blank">碑文范例</a> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default add-front-attach"> 添 加 一 行 </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"> 取 消 </button>
                                <button type="button" class="btn btn-primary front-attach-save"> 保 存 </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="ins_back_attach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content cbox">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">碑后文附加字段</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-noborder back-line">
                                    <?php if(isset($attach['back'])):$index=0;?>
                                        <?php foreach ($attach['back'] as $key => $bk): ?>
                                            <tr class="main-line">
                                                <td>
                                                    <input name="attach[back][<?=$index?>][content]" value="<?=$bk['content']?>"
                                                           type="text" class="form-control input-sm attach_back<?=$index?>con">

                                                    <input type="hidden" name="attach[back][<?=$index?>][pos]"
                                                           value="<?=isset($bk['pos'])?$bk['pos']:''?>"
                                                           class="form-control attach_back<?=$index?>">
                                                </td>
                                                <td><label for=""><input type="checkbox" name="attach[back][<?=$index?>][is_big]"
                                                                         value="1" <?php if(isset($bk['is_big'])){echo "checked";}?>
                                                        >大字</label></td>
                                                <td colspan="2">
                                                    <button type="button" class="btn btn-default del-line btn-xs"> 删 除 </button>
                                                </td>
                                            </tr>
                                            <?php $index++;endforeach ?>
                                    <?php endif;?>
                                </table>
                                <!-- <a href="#" target="_blank">碑文范例</a> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default add-back-attach"> 添 加 一 行 </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"> 取 消 </button>
                                <button type="button" class="btn btn-primary back-attach-save"> 保 存 </button>
                            </div>
                        </div>
                    </div>
                </div>


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
                            <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                            <?php if ($model->is_confirm): ?>
                                <span class="btn btn-default btn-lg" type="button">碑文已确认，不可修改</span>
                            <?php else:?>
                                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg  save-ins', 'style'=>'padding: 10px 36px']) ?>
                            <?php endif;?>
                            <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
                        </div>
                    </div>
                    <!-- </form> -->

                </div><!--auto row-->
            </div>
            <?php ActiveForm::end(); ?>
            <hr />

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

        <?=$this->render('_order', ['order'=>$order]) ?>

    </div>
    <!-- 碑后文的每一行 -->
    <table id="backclone" style="display:none;">
        <tr class="main-line">
            <td>正文</td>
            <td><input name="back[main][content][]" class="form-control input-sm input"></td>
            <td  colspan="2">
                <button type="button" class="btn btn-default del-line"> 删 除 </button>
            </td>
        </tr>
    </table>
    <!--
    <link href="/static/assets/js/colorbox/colorbox.css" rel="stylesheet" type="text/css">
    <script src="/static/assets/js/colorbox/jquery.colorbox-min.js"></script> -->

<?php $this->beginBlock('up') ?>

    if (typeof LN == 'undefined') {LN = {}};
    LN.insFree = function(){
        var changed = "<?=$model->changed?>";
        var insContainer = $('#ins-container');
        var selIns = insContainer.find('.sel');
        var fee = eval('(' + '<?=json_encode($fee)?>'+ ')');

        auto(changed);


        //碑前文的附加
        $('body').on('click','.add-front-attach',function(){
            var num = $('.main-line',$(this).closest('.cbox')).size();
            var html = '<tr class="main-line">' +
                '<td><input name="attach[front]['+num+'][content]" type="text" class="form-control input-sm attach_front'+num+'con">'+
                '<input type="hidden" name="attach[front]['+num+'][pos]" class="form-control attach_front'+num+'">'+

                '</td>'+
                '<td><label for=""><input type="checkbox" name="attach[front]['+num+'][is_big]">大字</label></td>'+
                '<td  colspan="2">'+
                '<button type="button" class="btn btn-default del-line btn-xs"> 删 除 </button>'+
                '</td>'+
                '</tr>';

            $(this).closest('.cbox').find('table').append(html);
        });

        //碑后文内容
        $('body').on('click','.add-back',function(){
            var num = $('.main-line',$(this).closest('.cbox')).size();

            var html = '<tr class="main-line">' +
                '<td>正文</td>' +
                '<td><input name="back[main][content]['+num+']" type="text" class="form-control input-sm main'+num+'con">'+
                '<input type="hidden" name="back[main][pos]['+num+']" class="form-control main'+num+'">'+
                '</td>'+
                '<td  colspan="2">'+
                '<button type="button" class="btn btn-default del-line btn-xs"> 删 除 </button>'+
                '</td>'+
                '</tr>';

            $(this).closest('.cbox').find('table').append(html);
        });

        //碑后文的附加
        $('body').on('click','.add-back-attach',function(){
            var num = $('.main-line',$(this).closest('.cbox')).size();
            var html = '<tr class="main-line">' +
                '<td><input name="attach[back]['+num+'][content]" type="text" class="form-control input-sm attach_front'+num+'con">'+
                '<input type="hidden" name="attach[front]['+num+'][pos]" class="form-control attach_back'+num+'">'+
                '</td>'+
                '<td><label for=""><input type="checkbox" name="attach[back]['+num+'][is_big]">大字</label></td>'+
                '<td  colspan="2">'+
                '<button type="button" class="btn btn-default del-line btn-xs"> 删 除 </button>'+
                '</td>'+
                '</tr>';

            $(this).closest('.cbox').find('table').append(html);
        });


        $('body').on('click','.del-line',function(){
            $(this).parents('tr').remove();
        })

        getImage('front_selected');
        getImage('back_selected');


        selIns.click(function(e){
            e.preventDefault();
            var driect = $(this).attr('rel');
            var cla = driect + '_selected';
            //调整样式
            $(this).parents('.panel-body').find('.sel_style').html('');
            $(this).parent().find('.sel_style').html('(<i class="red fa fa-check fa-2"></i>)');

            //选择标识
            $(this).closest('.' + driect + '_images').find('img').removeClass(cla);
            $(this).addClass(cla);

            searchCaseId();
            getImage(cla);
            getPrice();
        });

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

        $('.front-attach-save', insContainer).click(function(){
            getImage('front_selected');
            getPrice();
            $('#ins_front_attach').modal('hide');
        });

        $('.back-attach-save', insContainer).click(function(){
            getImage('back_selected');
            getPrice();
            $('#ins_back_attach').modal('hide');
        });


        $('#selectback', insContainer).change(function(){
            var str = $(this).val();
            var arr = str.split(',');
            $('.backmain .back-line .main-line').remove();



            for(k in arr){
                var tr = '<tr class="main-line">' +
                    '<td>正文</td>' +
                    '<td><input name="back[main][content]['+k+']" value="'+arr[k]+'" type="text" class="form-control input-sm main'+k+'con">'+
                    '<input type="hidden" name="back[main][pos]['+k+']" class="form-control main'+k+'">'+
                    '</td>'+
                    '<td  colspan="2">'+
                    '<button type="button" class="btn btn-default del-line btn-xs"> 删 除 </button>'+
                    '</td>'+
                    '</tr>';

                $('.backmain .back-line').append(tr);
            }
            getImage('back_selected');
            getPrice();
        });

//        $('#font_style', insContainer).change(function(){
//            getImage('front_selected');
//            getImage('back_selected');
//            getPrice();
//        });
//

//        // 简繁体切换
        $('#is_tc', insContainer).change(function() {
            getImage('front_selected');
            getImage('back_selected');
            getPrice();
        });

        $('.dt_pre_finished ').change(function(){
            var ur = "{$urgent}";
            if (ur == 1) return false;
            urgent();
        });


        $('#big_new, #small_new').change(function(){
            calFee();
        });

        $('.btn-dis').click(function(e){
            e.preventDefault();
            var rel = $(this).attr('rel');
            $('.'+rel).toggle();
        })

        function getImage(cla){
            var case_id = $('.'+cla).attr('case_id');
            var driect = $('.'+cla).attr('rel');
            var tomb_id = $('input[name=tomb_id]').val();
            var data = $('#auto-ins-form').serialize();
            var url = "<?=Url::toRoute(['/grave/home/ins/free-sel', 'tomb_id'=>$get['tomb_id']])?>";
            var tc = parseInt($('#is_tc').val());

            if (url.indexOf('?') >= 0) {
                url += '&case_id=' + case_id;
            } else {
                url += '?case_id=' + case_id;
            }
            if(isNaN(case_id)) return ;
            $.post(url, data, function(xhr){

                if(xhr.status){
                    if (cla == 'front_selected') {
                        var ctx = LN.insCanvas('#frontCanvas', <?=$get['tomb_id']?>);
                        ctx.setData({data:xhr.data,tc:tc,direction:'front'});
                    }

                    if (cla == 'back_selected') {
                        var ctx = LN.insCanvas('#backCanvas', <?=$get['tomb_id']?>);
                        ctx.setData({data:xhr.data,tc:tc,direction:'back'});
                    }

                } else {

                }
            },'json');
        }

        //取价格
        function getPrice(){

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



        return {  // 法三：通过匿名函数返回值得到一系列接口函数集合对象，赋值给全局变量mylib（推荐）
            getPrice: getPrice
        };
    }

    $(function(){
        LN.insFree();
    })


    <?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?>



