<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\ArrayHelper;
use app\core\helpers\Url;
use app\assets\SelectAsset;
use app\assets\PluploaduiAssets;
use app\core\models\Attachment;

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
<!-- Tab panes -->
      <div class="goods-form">

            <?= $form->field($model, 'category_id')->hiddenInput(['value'=>Yii::$app->getRequest()->get('category_id')])->label(false)?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'style'=>"width:50%;"]) ?>

            <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'style'=>"width:50%;"]) ?>
            <div class="form-group field-goods-intro">
                <div><h3>菜品介绍</h3></div>
                <div class="rows">
                    <div class="col-md-3" style="padding-right:0;padding-left:0">
                        <!--用来存放item-->
                        <div id="filePicker-intro" class="thumbnail filelist-intro" style="margin-bottom:0">
                                <img class="mainImg" src="<?=Attachment::getById($model->thumb,'202x243', '/static/images/up.png')?>" style="height: 243px; width: 100%; display: block;">
                                <input name="Goods[thumb]" type="hidden" value="<?=$model->thumb?>" />
                        </div>
                    </div>

                    <div class="col-md-9" style="padding-left:0">
                        <?= $form->field($model, 'intro')->textArea(['maxlength' => true, 'style'=>"height:250px;"])->label(false) ?>
                        <div class="help-block"></div>
                    </div>
                </div>
                
            </div>

            <div class="form-group field-goods-intro">
                <label class="control-label" for="goods-name">属性</label>
                <div class="rows">
                    <div class="col-md-12" style="padding-right:0;padding-left:0">
                        <?php if ($attrs): ?>
                            <?php foreach ($attrs as $k => $attr): ?>
                                <select id="lunch" name="AvRel[<?=$attr->id?>]" class="selectpicker" data-live-search="true" title="<?=$attr->name?>">
                                    <?php foreach ($attr->vals as $val): ?>
                                        <option value="<?=$val->id?>" 
                                        <?php if (isset($attr_sels[$attr['id']]) && in_array($val->id, $attr_sels[$attr['id']])){echo "selected=selected";} ?>>
                                        <?=$val->val?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>


            <div class="form-group field-goods-intro">
                <label class="control-label" for="goods-name">规格</label>
                <?php if ($specs): ?>
                    <?php foreach ($specs as $k => $spec): ?>
                        <div class="form-group spec-control field-avrel-<?=$spec->id?>-av_id">
                            <label class="control-label spec-label col-sm-1" for="avrel-<?=$spec->id?>-av_id"><?=$spec->name?></label>
                            <div class="col-sm-11">
                                
                                <strong style="color:green">  </strong>
                                <?php foreach ($spec->vals as $ke => $va): ?>
                                        <label id="avrel-<?=$spec->id?>-av_id">
                                        <input type="checkbox" data-text="<?=$va->val?>" 
                                        data-attr="<?=$spec['id']?>" name="AvRel[<?=$spec->id?>][]" 
                                        value="<?=$va->id?>" 
                                        <?php if (isset($attr_sels[$spec['id']]) && in_array($va->id, $attr_sels[$spec['id']])){echo "checked";} ?>
                                        class="sel-spec"> <?=$va->val?>
                                        </label>
                                <?php endforeach ?>
                                    
                                <div class="help-block">
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>


            <?php if ($tables['data']): ?>
            <div class="form-group">
                <label class="control-label" for="avrel-intro">相应规格价格增量填写</label>
                <div >
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <?php foreach ($tables['labels'] as $v): ?>
                                    <td><?=$specs[$v]->name?></td>
                                <?php endforeach ?>
                                <td>价格</td>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($tables['data'] as $k => $spec): ?>
                        <?php 
                            $sku_key = '';
                            foreach ($spec as $v) {
                                $sku_key .= $v['attr_id'] . ':' . $v['id'] .';';
                            }
                            $k = trim($sku_key,';');
                        ?>
                            <tr sku-key="<?=$sku_key?>" sku-tmp="<?=$sku_key?>" class="hide">
                                <?php foreach ($spec as $v): ?>
                                    <td key="<?=$v['attr_id']?>:<?=$v['id']?>"><?=$v['val']?></td>
                                <?php endforeach ?>
                                <td><input name="price[<?=$k?>]" sku-key="<?=$sku_key?>" value="<?=isset($skus[$k])?$skus[$k]:0?>"/></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <?php endif ?>
            
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>
            
            <?php ActiveForm::end(); ?>


<?php $this->beginBlock('spec') ?>  
      $(function(){

        spec();

        $('.sel-spec').change(function(){
            var ar = [];

            $('tbody tr').addClass('hide');
            $('tr').each(function(){
                $(this).attr('sku-tmp', $(this).attr('sku-key'));
            });

            spec();
        });

        function spec()
        {
            $('input.sel-spec:checked').each(function(){
                var attr = $(this).data('attr');
                var prop = $(this).val();
                var tmp = attr + ':' + prop;

                $('td[key="'+tmp+'"]').closest('tr').each(function(){
                    var sku_tmp = $(this).attr('sku-tmp');
                    var sku_tmp = sku_tmp.replace(tmp +';', '');
                    $(this).attr('sku-tmp', sku_tmp);


                    if (sku_tmp == ';;' || sku_tmp=='') {
                        $(this).removeClass('hide');
                    } else {
                        $(this).addClass('hide');
                    }
                });

            });
            $('tr input:hidden').val('');
        }

      })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['spec'], \yii\web\View::POS_END); ?>  

<?php $this->beginBlock('deal') ?>  
$(function(){
    up('intro', 202, 243);
})



function up(index, preWidth, preHeight, imgNum){

    var uploader=[];
    var btn=[];
    btn[index] = 'filePicker-' + index;

    uploader[index] = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : btn[index], // you can pass an id...
        //container: document.getElementById('container'), // ... or DOM Element itself
        url : '<?=Url::toRoute(["pl-upload"])?>',
        flash_swf_url : '/static/libs/plupload-2.1.9/js/Moxie.swf',
        silverlight_xap_url : '/static/libs/plupload-2.1.9/js//Moxie.xap',
        file_data_name:'file',
        multi_selection: imgNum ? imgNum : false,
        filters : {
            max_file_size : '10mb',
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png"},
                {title : "Zip files", extensions : "zip"}
            ],
            prevent_duplicates: true//不允许选择重复文件
        },
        multipart_params:{
            res_name : 'meal'
        },
        resize: {
            width: preWidth,
            height: preHeight,
            crop: true
        },

        init: {
            PostInit: function() {
                //$('#'+btn[index]).click(function(){
                //    uploader[index].start();
                //    return false;
                //});
            },

            FilesAdded: function(up, files) {

                if (files.length > imgNum) {
                    alert('最多只能上传'+imgNum+'张图片哦');
                    uploader[index].splice(imgNum, files.length-imgNum);
                } 

                plupload.each(files, function(file, i) {

                   if (i > 3) {
                        //uploader[index].removeFile(file);
                   }

                    previewImage(file, function (imgsrc) {
                        $('.filelist-'+index).find('img').eq(i).attr('src', imgsrc);
                    })
                });

                uploader[index].start();
            },

            UploadProgress: function(up, file) {
                document.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
            },

            FileUploaded: function(up, file, info) {
                res = $.parseJSON(info.response);

                if (imgNum) {
                    var files = uploader[index].files;
                    i = 0;
                    for ( f in files) {
                        if (files[f] == file) {
                            i = f;
                        }
                    }
                    $('.filelist-'+index).find('input').eq(i).val(res.mid);
                } else {
                    $('#'+btn[index] + '>input').val(res.mid);
                }
            },


            Error: function(up, err) {
                //document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
            }
        }
    });

    uploader[index].init();


    function previewImage(file, callback) {//file为plupload事件监听函数参数中的file对象,callback为预览图片准备完成的回调函数
        if (!file || !/image\//.test(file.type)) return; //确保文件是图片
        if (file.type == 'image/gif') {//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
            var fr = new mOxie.FileReader();
            fr.onload = function () {
                callback(fr.result);
                fr.destroy();
                fr = null;
            }
            fr.readAsDataURL(file.getSource());
        } else {
            var preloader = new mOxie.Image();
            preloader.onload = function () {
                //preloader.downsize(550, 400);//先压缩一下要预览的图片,宽300，高300
                var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                callback && callback(imgsrc); //callback传入的参数为预览图片的url
                preloader.destroy();
                preloader = null;
            };
            preloader.load(file.getSource());
        }
    }

    function log() {
        var str = "";
 
        plupload.each(arguments, function(arg) {
            var row = "";
 
            if (typeof(arg) != "string") {
                plupload.each(arg, function(value, key) {
                    // Convert items in File objects to human readable form
                    if (arg instanceof plupload.File) {
                        // Convert status to human readable
                        switch (value) {
                            case plupload.QUEUED:
                                value = 'QUEUED';
                                break;
 
                            case plupload.UPLOADING:
                                value = 'UPLOADING';
                                break;
 
                            case plupload.FAILED:
                                value = 'FAILED';
                                break;
 
                            case plupload.DONE:
                                value = 'DONE';
                                break;
                        }
                    }
 
                    if (typeof(value) != "function") {
                        row += (row ? ', ' : '') + key + '=' + value;
                    }
                });
 
                str += row + " ";
            } else {
                str += arg + " ";
            }
        });
 
        var log = document.getElementById('console');
        log.innerHTML += str + "\n";
    }
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['deal'], \yii\web\View::POS_END); ?> 