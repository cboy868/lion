<?php 
use app\core\helpers\Url;

use app\assets\PluploaduiAssets;
PluploaduiAssets::register($this);
?>
<div class="col-xs-12">
    <div class="item table-responsive" id="tomb" loc="loc0">
    	<div class="table-header">
            <i class="icon-credit-card"></i> 
           <span class="title_info"> 墓位信息</span>
        </div>
        <table class="table table-bordered table-condensed table-striped">
            <tbody>
                <tr>
                    <td rowspan="17" width="320">

                    <a href="javascript:;" id="filePicker-thumb" class="thumbnail filelist-thumb filePicker" rid="<?=$tomb->id?>">
                              <img class="img-rounded" src="<?=$tomb->getImg('320x400')?>" >
                        </a>

                    </td>
                </tr>
                <tr>
                    <th width="120">墓号</th>
                    <td>
                        <?=$tomb->tomb_no?>
                    </td>
                    <td rowspan="11" width="280">
                        <div>
                            <img src="/admin/index/bindPng?user_id=61140">
                            <br>
                            <span style="margin-left:20px;font-size:20px">购买人微信扫码，绑定微信</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>墓位价格</th>
                    <td>￥<?=$tomb->price?></td>
                </tr>
                <tr>
                    <th>销售状态</th>
                    <td><?=$tomb->getStatusText()?></td>
                </tr>
                <tr>
                    <th>客户账号</th>
                    <td><?=$tomb->user?$tomb->user->username:''?> 
                    <!-- <a href="/admin/tomb/access/user_id/61140">以客户身份登录</a> -->
                    </td>
                </tr>
                <tr>
                    <th>导购员</th>
                    <td><?=$tomb->guide ? $tomb->guide->username : ''?></td>
                </tr>
                <tr>
                    <th>业直</th>
                    <td><?=$tomb->agent ? $tomb->agent->username : '无'?></td>
                    
                </tr>
                <tr>
                    <th>购买时间</th>
                    <td><?=$tomb->sale_time?></td>
                </tr>

                <tr>
                    <th>墓位备注</th>
                    <td><?=$tomb->note?></td>
                </tr>
                <tr>
                    <th>墓证年限</th>
                    <td>
                     <?=$tomb->card->start?> 至 <?=$tomb->card->end?>   
                     <?php if ($tomb->card->rels): ?><br/>
                     (
                        <?php foreach ($tomb->card->rels as $rel): ?>
                            <?=$rel->start?> 至 <?=$rel->end?> / 
                        <?php endforeach ?>
                     )                            
                     <?php endif ?>                                                              
                     <!-- <a ylw-remote-form="true" href="/admin/tomb/editcard?tomb_id=119"> 编辑</a> -->
                                          </td>
                </tr>
            </tbody>
        </table>
    </div>
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