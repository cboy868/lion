<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;
use app\core\helpers\Url;
use app\assets\SelectAsset;
use app\assets\PluploaduiAssets;


use app\modules\shop\models\Category;
use app\modules\shop\models\Attr;
use app\modules\shop\models\AvRel;

/* @var $this yii\web\View */
/* @var $model shop\models\Goods */
/* @var $form yii\widgets\ActiveForm */
SelectAsset::register($this);
PluploaduiAssets::register($this);
?>

<style type="text/css">
    div.webuploader-pick {
         display: block; 
         background: #fff; 
         padding: 0; 
    }

    div.col-md-5 {
        padding-right: 40px;
    }
</style>

<?php $form = ActiveForm::begin([
                'fieldConfig'=>['template'=>'{label}{input}{hint}{error}', 'labelOptions' => ['class' => '']], 
                'options' => ['class' => '']
                    ]); ?>


            <?= $form->field($model, 'id')->hiddenInput(['maxlength' => true, 'style'=>"width:50%;"])->label(false) ?>

      <div class="goods-form">
            <div class="rows">
                <div><h3>记录原材料</h3></div>
                <div>
                    <p>
                    小提示：<br>
                        1、输入食材后，下方会弹出相应食材可选择；如果没有弹出，可能是您输入的食材有误，或者没有当前食材（请联系小编）<br>
                        2、“适量、少许”尽量少用或者不用，用量精确对您的粉丝更有帮助
                    </p>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">主料</label>
                <div class="col-md-12">
                    <div class="rows" style="height:40px;">
                        <div class="wrap">

                        <?php foreach ($mixrel[0] as $k => $v): ?>
                            <div class="col-md-5 liao">
                                <div class="input-group"> 
                                    <select name="zl[mix_id][]" class="form-control selectpicker" data-live-search="true" title="请填写主料名称 如:土豆">
                                        <?php foreach ($mixs as $mix): ?>
                                            <option value="<?=$mix->id?>" <?php if($v->mix_id == $mix->id){echo "selected";} ?>><?=$mix->name?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="input-group-btn input-btn"> 
                                        <input type="text" name="zl[measure][]" value="<?=$v->measure?>" class="form-control" style="width:100px;" placeholder="用量 如:200克"> 
                                        <?php if ($k>0): ?>
                                            <a href="" style="color:#aaa" class="btn btn-sm btn-del"><i class="fa fa-times-circle fa-2x"></i></a>
                                        <?php endif ?>
                                    </div><!-- /btn-group --> 
                                </div><!-- /input-group --> 
                            </div>
                        <?php endforeach ?>
                        </div>
                    
                        <div class="col-md-12">
                            <button class="btn btn-success btn-add zl" type="button">添加一项</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label">辅料</label>
                <div class="col-md-12">
                    <div class="rows" style="height:40px;">
                        <div class="wrap">

                        <?php foreach ($mixrel[1] as $k => $v): ?>
                            <div class="col-md-5 liao">
                                <div class="input-group"> 
                                    <select name="fl[mix_id][]" class="form-control selectpicker" data-live-search="true" title="请填写主料名称 如:食盐">
                                        <?php foreach ($mixs as $mix): ?>
                                            <option value="<?=$mix->id?>" <?php if($v->mix_id == $mix->id){echo "selected";} ?>><?=$mix->name?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="input-group-btn input-btn"> 
                                        <input type="text" name="fl[measure][]" value="<?=$v->measure?>" class="form-control" style="width:100px;" placeholder="用量 如:20克"> 
                                        <?php if ($k>0): ?>
                                            <a href="" style="color:#aaa" class="btn btn-sm  btn-del"><i class="fa fa-times-circle fa-2x"></i></a>
                                        <?php endif ?>
                                    </div><!-- /btn-group --> 
                                </div><!-- /input-group --> 
                            </div>
                        <?php endforeach ?>
                         
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-success  btn-add fl" type="button">添加一项</button>
                        </div>
                    </div>
                </div>

            </div>



            <div class="form-group">
                <div><h3>菜品制作步骤</h3></div>
                <div>
                    <p>
                    小提示：<br>
                    1、步骤图宽度在400像素至550像素，如果拼接请横向拼接2至3张（当宽度大于550时会自动压缩，不用裁切）<br>
                    2、每个步骤只用一段话描述，请勿在步骤中再细分“1.2.3.”
                    </p>
                </div>
            </div>
            <div class="steps">

            <?php foreach ($process as $k => $v): ?>
                <div class="form-group step">
                    <label class="control-label">第 <span class="step-num"><?=$k;?></span> 步</label>
                    <div class="rows">
                        <div class="col-md-3" style="padding-right:0;padding-left:0">
                        <a href="javascript:;" id="filePicker-<?=$k?>" class="thumbnail filelist-<?=$k?> filePicker" use="step">
                              <img src="<?=$v->img_url?>"  style="height: 243px; width: 100%; display: block;">
                              <input name="step[img][]" class="step-img" type="hidden" value="<?=$v->thumb?>" />
                        </a>

                        </div>
                        <div class="col-md-8" style="padding-left:0;padding-right:0">
                            <textarea id="foods-intro" class="form-control" placeholder="请输入简单的菜品介绍" name="step[intro][]" style="height:250px;"><?=$v->intro?></textarea>
                            <div class="help-block"></div>
                        </div>
                        <div class="col-md-1" style="padding-left:0">
                            <div class="btn-group-vertical">
                                <button class="btn btn-default step-add"><i class="fa fa-plus"></i></button>
                                <button class="btn btn-default step-del"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-default move-up"><i class="fa fa-chevron-up"></i></button>
                                <button class="btn btn-default move-down"><i class="fa fa-chevron-down"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endforeach ?>

                
            </div>
             <div class="form-group field-goods-intro">
                <button class="btn btn-info btn-lg step-add big"> 加一步 </button>
             </div>

            <div class="form-group">
                <div><h3>最终效果图<button type="button" id="filePicker-patch" class="btn btn-danger patch filePicker" num="4" use="pic">批量上传</button></h3></div>
            </div>

            <div class="form-group field-goods-name">
                <div class="row filelist-patch">

                <?php foreach ($pics as $k => $v): ?>
                    <a class="col-xs-3 col-md-3 filelist-a filePicker" id="pic-<?=$k?>" href="javascrip:;" use="pic">
                        <img src="<?=$v->url?>" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">
                        <input name="pic[]" type="hidden" value="<?=$v->id?>" />
                    </a>
                <?php endforeach ?>

                </div>
            </div>

            <?= $form->field($model, 'skill')->textArea(['style'=>'height:200px;']) ?>
            
            </div>

            <div class="form-group">

                <div class="col-sm-offset-2 col-sm-3" id="myButton" data-loading-text="图片上传中，请稍后..." autocomplete="off">
                    <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>
            
            <?php ActiveForm::end(); ?>

<?php $this->beginBlock('deal') ?>  
$(function(){
    upinit();
    $('body').on('click', '.btn-del', function(e){
        e.preventDefault();
        $(this).closest('.col-md-5').remove();
    });

    $('body').on('click', '.btn-add', function(e){
        e.preventDefault();

        var wrap = $(this).closest('.rows')
        var str = $(this).hasClass('zl') ? '请填写主料名称 如土豆' : '请填写辅料名称 如食盐';
        var type = $(this).hasClass('zl') ? 'zl' : 'fl';


        var htm = '<div class="col-md-5 liao">' +
                        '<div class="input-group"> '+
                            '<select name="'+type+'[mix_id][]" class="form-control selectpicker" data-live-search="true" title="'+str+'">'+
                                <?php foreach ($mixs as $k => $mix): ?>
                                    '<option value="<?=$mix->id?>"><?=$mix->name?></option>' +
                                <?php endforeach ?>
                            '</select>' +
                           ' <div class="input-group-btn input-btn"> ' +
                                '<input type="text" name="'+type+'[measure][]" class="form-control" style="width:100px;" placeholder="用量 如:20克">' +
                                '<a href="" style="color:#aaa" class="btn btn-sm  btn-del"><i class="fa fa-times-circle fa-2x"></i></a>'+
                            '</div><!-- /btn-group --> '+
                        '</div><!-- /input-group --> '+
                    '</div>';


        wrap.find('.wrap').append(htm);

        $('.selectpicker').selectpicker();
    })

    $('body').on('click', '.step-add', function(e){
        e.preventDefault();
        var wrap = $('.steps');
        var cnt = wrap.find('.step').length;
        if (cnt >= 20) {
            alert('大神，　您这是要做一道什么菜哇！！');
            return false;
        }

        var obj = wrap.find('.step:first').clone();
        cnt++;
        obj.find('.rows .thumbnail').attr('id', 'filePicker-' + cnt).addClass('filePicker');
        obj.find('.rows .thumbnail').find('img').attr('src', '/static/images/up.png').parent().find('input').val('');
        var html = obj.prop("outerHTML");

        $(html).find('.rows .thumbnail').addClass('abcde');

        if ($(this).hasClass('big')) {
            wrap.append(html);
        } else {
            $(this).closest('.step').after(html);
        }
        
        sort();
        upinit();
    })

    $('body').on('click', '.step-del', function(e){
        e.preventDefault();
        var cnt = $('.steps').find('.step').length;
        if (cnt <= 1) {
            alert('大神，　别删了！！');
            return false;
        }
        $(this).closest('.step').remove();
        sort();
    })

    $('body').on('click', '.move-up, .move-down', function(e){
        e.preventDefault();
        var current = $(this).closest('.step')
        var pre = current.prev();
        var next = current.next();
        $(this).hasClass('move-down') ? next.insertBefore(current) : current.insertBefore(pre);
        sort();
    })

    function upinit() {
        $('.filePicker').each(function(i){
            var imgNum = $(this).attr('num');
            imgNum = imgNum ? imgNum : 'false';
            var that = this;
            var index = parseInt(i) +1;
            var uploader = [];
            btn = $(this).attr('id');
            var use = $(this).attr('use');
            var bt;
            $(this).removeClass('filePicker'); //去除 此class 防止再次each时，多次循还

            uploader[index] = new plupload.Uploader({
                runtimes : 'html5,flash,silverlight,html4',
                browse_button : btn, // you can pass an id...
                url : '<?=Url::toRoute(["pl-upload"])?>',
                flash_swf_url : '/static/libs/plupload-2.1.9/js/Moxie.swf',
                silverlight_xap_url : '/static/libs/plupload-2.1.9/js//Moxie.xap',
                file_data_name:'file',
                multi_selection: eval(imgNum),
                filters : {
                    max_file_size : '10mb',
                    mime_types: [
                        {title : "Image files", extensions : "jpg,gif,png"},
                        {title : "Zip files", extensions : "zip"}
                    ],
                    prevent_duplicates: true//不允许选择重复文件
                },
                multipart_params:{
                    res_name : 'meal',
                    'use' : use
                },

                init: {
                    PostInit: function() {},
                    FilesAdded: function(up, files) {



                    bt = $('#myButton').button('loading');


                        if (files.length > imgNum) {
                            alert('最多只能上传'+imgNum+'张图片哦');
                            uploader[index].splice(imgNum, files.length-imgNum);
                        } 

                        plupload.each(files, function(file, i) {
                            if (!file || !/image\//.test(file.type)) return; //确保文件是图片
                                if (file.type == 'image/gif') {//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
                                    var fr = new mOxie.FileReader();
                                    fr.onload = function () {
                                        if (imgNum > 1) {
                                            $('.filelist-patch').find('img').eq(i).attr('src', fr.result);
                                        }
                                        $(that).find('img').eq(i).attr('src', fr.result);
                                        fr.destroy();
                                        fr = null;
                                    }
                                    fr.readAsDataURL(file.getSource());
                                } else {
                                    var preloader = new mOxie.Image();
                                    preloader.onload = function () {
                                        preloader.downsize(404, 486);//先压缩一下要预览的图片,宽300，高300
                                        var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                                        if (imgNum > 1) {
                                            $('.filelist-patch').find('img').eq(i).attr('src', imgsrc);
                                        } else {
                                            $(that).find('img').eq(i).attr('src', imgsrc);
                                        }
                                        
                                        preloader.destroy();
                                        preloader = null;
                                    };
                                    preloader.load(file.getSource());
                                }
                           
                        });

                        uploader[index].start();
                    },

                    UploadProgress: function(up, file) {
                        //document.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                    },

                    FileUploaded: function(up, file, info) {
                        res = $.parseJSON(info.response);

                        if (imgNum > 1) {
                            var files = uploader[index].files;
                            i = 0;
                            for ( f in files) {
                                if (files[f] == file) {
                                    i = f;
                                }
                            }

                            $(".filelist-patch").find('input').eq(i).val(res.mid);
                        } else {

                            $(that).find('input').val(res.mid);
                        }
                    },
                    UploadComplete:function(up,file){
                        bt.button('reset')
                    },

                    Error: function(up, err) {
                        //document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
                    }
                }
            });

            uploader[index].init();
        });
    }
    

})

function sort()
{
    $('.steps').find('.step').each(function(index, ele){
        $(this).find('.step-num').text(parseInt(index)+1);
    });
}


<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['deal'], \yii\web\View::POS_END); ?> 