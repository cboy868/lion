<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\modules\grave\models\Ins;
use app\assets\ExtAsset;
use app\assets\PluploaduiAssets;
use app\core\models\Attachment;


PluploaduiAssets::register($this);
ExtAsset::register($this);
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
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->

         <div class="col-xs-12">
            <?php if (Yii::$app->session->has('success')): ?>
                <div class="alert alert-success" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>恭喜!</strong> <?=Yii::$app->session->getFlash('success')?>
                </div>
            <?php endif ?>

            <?php if (Yii::$app->session->has('error')): ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>提示!</strong> <?=Yii::$app->session->getFlash('error')?>
                </div>
            <?php endif ?>
        </div>
        

				   <?php 
            $form = ActiveForm::begin();
            $form->fieldConfig['labelOptions']['class']='control-label col-sm-4';
            $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>'; 
        ?>
        <div class="row">
            <?php foreach ($pos as $k => $v): ?>
                <div class="col-xs-4 address-index">
                    <div class="panel panel-info">
                        <div class="dHandler panel-heading"><?=$pos[$k]?>信息 
                            <button type="button" class="delit close" style="display:none;">
                               <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
                               <span class="sr-only">Close</span>
                            </button> 
                        </div>
                         <a href="javascript:;" id="filePicker-<?=$k?>" class="thumbnail filelist-<?=$k?> filePicker" style="max-width:380px;max-height:280px;">
                              <img src="<?=Attachment::getById($imgs->$k, '380x265', '/static/images/default.png')?>">
                              <input name="Ins[img][<?=$k?>]" class="ins-img" type="hidden" value="<?=$imgs->$k?>" />
                        </a>
                    </div>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            <?php endforeach ?>

        </div><!-- /.row -->

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <div class="dHandler panel-heading">详细信息 
                        <button type="button" class="delit close" style="display:none;">
                           <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
                           <span class="sr-only">Close</span>
                        </button> 
                    </div>

                    <table class="table table-condensed" style="width:70%">
                    <tr>
                        <td width="50%"><?= $form->field($model, 'paint')->dropDownList(Ins::getPaint(), ['style'=>'width:70%']) ?></td>
                        <td><?= $form->field($model, 'is_tc')->radioList(Ins::getIsTc(), ['style'=>'width:70%']) ?></td>
                    </tr>
                    <tr>
                        <td><?= $form->field($model, 'font_num')->textInput(['style'=>'width:70%']) ?></td>
                        <td><?= $form->field($model, 'pre_finish')->textInput([
                                        'style'=>'width:70%', 
                                        'dt'=>'true', 
                                        'y-chante' => 'true',
                                        'm-change' =>'true'
                                        ]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?= $form->field($model, 'paint_price')->textInput(['style'=>'width:70%']) ?></td>
                        <td><?= $form->field($model, 'letter_price')->textInput(['style'=>'width:70%']) ?></td>
                        
                    </tr>

                    <?php 
                        $form->fieldConfig['labelOptions']['class']='control-label col-sm-2';
                        $form->fieldConfig['template'] = '{label}<div class="col-sm-9">{input}{hint}{error}</div>'; 

                     ?>
                    <tr>
                        <td colspan="2">
                            <?= $form->field($model, 'note')->textArea(['rows'=>3])->label('碑文备注') ?>
                        </td>
                    </tr>

                   
                </table>
                </div>
            </div>
        </div>




        <div class="form-group">
            <div class="col-sm-12" style="text-align:center;">
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('up') ?>  

$(function(){
    upinit();
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
             }//init
        });//uploader

        uploader[index].init();
    });//each
}



<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?> 







	


	

				

