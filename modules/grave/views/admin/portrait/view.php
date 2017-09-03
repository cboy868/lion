<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

use app\core\helpers\ArrayHelper;
use app\core\helpers\Url;

use app\assets\ColorBoxAsset;
ColorBoxAsset::register($this);

use app\assets\PluploaduiAssets;
PluploaduiAssets::register($this);

$this->params['current_menu'] = 'grave/portrait/index';

$this->title = '瓷像详情';
$this->params['breadcrumbs'][] = ['label' => '瓷像管理', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= implode(',', ArrayHelper::getColumn($model->getDeads(), 'dead_name')) . Html::encode($this->title) ?>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                  <div class="panel-heading">

                      墓位: <a href="<?=Url::toRoute(['/grave/admin/tomb/view', 'id'=>$model->tomb_id])?>" target="_blank">
                              <span class="text-success"><?=$model->tomb->tomb_no;?></span>
                            </a>
                      商品：<span class="text-success"><?=$model->sku->getName()?></span>
                      是否确认:<span class="text-success"><?=$model->confirm_by ? '已确认' : '未确认'?></span>
                  </div>
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                          <th>客户原始照片</th>
                          <th width="500">PS完成(点图片上传)</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                          <td>
                              <div class="row">
                                  <div class="col-sm-6">
                                    <a class="artimg ccboxElement" target="_blank" href="<?=$model->getOriginalImg('300x200')?>">
                                      <img width="240" class="img-rounded" src="<?=$model->getOriginalImg('300x200')?>">
                                     </a>
                                     <a target="_blank" href="<?=$model->getOriginalImg()?>">打开原图</a>
                                  </div>
                              </div>
                          </td>
                          <td class="position:relative">
                              <div class="done-photo">
                                <a href="javascript:;" class=" filelist filePicker thumbnail" id="filePicker" rid="<?=$model->id?>">
                                 <img width="240" src="<?=$model->getProcessedImg('300x200')?>" class="img-rounded "> 
                                </a>

                              </div>
                          </td>
                       </tr>
                    </tbody>
                  </table>
              </div>

            </div>


            <div class="col-xs-12 portrait-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => '导购',
                'value' => $model->guide->username,
            ],
            [
                'label' => '账号',
                'value' => $model->user->username,
            ],
            [
                'label' => '墓位号',
                'value' => $model->tomb->tomb_no
            ],
            'title',
            // 'order_id',
            // 'order_rel_id',
            [
                'label' => '使用人',
                'value' => implode(',', ArrayHelper::getColumn($model->getDeads(), 'dead_name'))
            ],
            [
                'label' => '原图',
                'value' => $model->getOriginalImg('200x200'),
                'format' => 'image'
            ],
            [
                'label' => 'PS图',
                'value' => $model->getProcessedImg('200x200'),
                'format' => 'image'
            ],
            // 'photo_confirm',

            'confirm_by',
            'confirm_at:datetime',
            'use_at:datetime',
            // 'up_at:datetime',
            // 'notice_id',
            'type',
            'note:ntext',
            'statusText',
            'updated_at:datetime',
            'created_at:datetime',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('box') ?>  
  $(function(){
    $(".artimg").colorbox({
        rel: 'artimg',
        maxWidth:'600px',
        maxHeight:'700px'
    });

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
                use : 'ps',
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
<?php $this->registerJs($this->blocks['box'], \yii\web\View::POS_END); ?>  

