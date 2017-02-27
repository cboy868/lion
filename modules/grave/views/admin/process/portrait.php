<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\core\models\Attachment;

use app\assets\ExtAsset;
ExtAsset::register($this);

use app\assets\PluploaduiAssets;
PluploaduiAssets::register($this);
?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->
        
         <?=\app\core\widgets\Alert::widget();?>
        
        <?php 
            $form = ActiveForm::begin();
            $form->fieldConfig['labelOptions']['class']='control-label col-sm-2';
            $form->fieldConfig['template'] = '{label}<div class="col-sm-10">{input}{hint}{error}</div>'; 
        ?>
        <div class="row">
            
                <div class="col-xs-12 address-index">
                    <div class="panel panel-info">
                        <div class="dHandler panel-heading">瓷像信息
                            <small class="pull-right">
                                <?php 

                                    $portrait = $this->context->module->params['goods']['cate']['portrait'];
                                 ?>
                                <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$portrait, 'tomb_id'=>Yii::$app->request->get('tomb_id')])?>" class="modalAddButton btn btn-info" target="_blank">
                                    购买瓷像
                                </a>
                            </small>
                        </div>
                        <div class="row">
                        

                        <?php if ($models): ?>
                        
                        <?php foreach ($models as $index => $model): ?>
                            <?php 
                                $sku = $model->getSkuInfo();
                                $model->dead_ids = explode(',', $model->dead_ids);

                             ?>
                            <div class=" col-md-6">
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    
                                    <div class="row" style="height:100px">
                                        <div class="col-md-8">
                                            <div style="float:left;margin-right:10px;">
                                                <img class="img-rounded" style="float:left;max-height: 100px;max-width: 100px;" src="<?=$sku->goods->getThumb('100x100')?>">
                                            </div>

                                            <p>
                                              瓷像名: <?=$sku->goods->name.$sku->name;?>
                                              属性: 
                                              <?php foreach ($sku->goods->getAv()['attr'] as $k => $av): ?>
                                                    <?=$av['attr_name'] ?> : <?=$av['attr_val']?$av['attr_val']:$av['value']?>,
                                                <?php endforeach ?>
                                            </p>
                                          
                                          <div class="hr hr-18 dotted hr-double" style="clear:both;"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div style="float:right;margin-right:10px;">
                                                <a href="javascript:;" id="filePicker-<?=$index?>" class="thumbnail filelist-<?=$index?> filePicker" style="max-width:380px;max-height:280px;" rid="<?=$model->id?>">
                                                      <img src="<?=Attachment::getById($model->photo_original, '380x265', '/static/images/up.png')?>"  style="max-height: 100px;max-width: 100px;">
                                                      <?= $form->field($model, "[$index]photo_original")->hiddenInput(['class'=>'portrait-img', 'value'=>$model->photo_original])->label(false) ?>
                                                </a>
                                            </div>
                                            <div class="hr hr-18 dotted hr-double" style="clear:both;"></div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-12">
                                            <?= $form->field($model, "[$index]dead_ids")->checkBoxList($dead, ['style'=>'width:50%'])->label('使用人选择') ?>
                                            <?= $form->field($model, "[$index]use_at")->textInput(['style'=>'width:150px;', 'dt'=>'true']) ?>
                                            <?= $form->field($model, "[$index]note")->textArea() ?>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                        <?php else: ?>

                        <div class="col-md-12">
                             <?php 
                             $goods = $this->context->module->params['goods'];
                             $portrait = $goods['cate']['portrait'];
                             ?>
                            <div class="alert alert-success" role="alert" style="height: 100px; text-align: center; font-size: 40px;">
                            请
                            <small>
                                <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$portrait, 'tomb_id'=>Yii::$app->request->get('tomb_id')])?>" class="modalAddButton btn btn-info" target="_blank">
                                    选择并订购瓷像
                                </a>
                             </small>
                            </div>
                        </div>
                           

                        <?php endif ?>  

                        </div>

                        <div class="hr hr-18 dotted hr-double"></div>
                    </div>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            
        </div><!-- /.row -->
        <div class="form-group">
            <div class="col-sm-12" style="text-align:center;">
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <?=$this->render('_order', ['order'=>$order]) ?>
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
        var res_id = $(this).attr('rid');
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
                res_name : 'portrait',
                use : 'original',
                res_id : res_id
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





	


	

				

