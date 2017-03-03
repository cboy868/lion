<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\core\helpers\ArrayHelper;
use app\modules\grave\models\Portrait;
use yii\bootstrap\Modal;


use app\assets\FootableAsset;
FootableAsset::register($this);

use app\assets\PluploaduiAssets;
PluploaduiAssets::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\PortraitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '瓷像管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 portrait-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            [   'headerOptions' => ["data-type"=>"html"],
                'label' => '初始照片',
                'value' => function($model){
                    $img = '<img src="%s" />';
                    return sprintf($img, $model->getOriginalImg('50x50'));
                },
                'format' => 'raw'
            ],
            [   'headerOptions' => ["data-type"=>"html", 'width'=>'100px'],
                'label' => 'PS照片',
                'value' => function($model){

                    $html = <<<HTML
<a href="javascript:;" class=" filelist-{$model->id} filePicker thumbnail" id="filePicker-{$model->id}" rid="{$model->id}">
 <img src="{$model->getProcessedImg('50x50')}" class="img-rounded "> 
</a>
HTML;
                    return $html;
                },
                'format' => 'raw'
            ],
            'tomb.tomb_no',
            'title',
            
            // [
            //     'label' => '商品',
            //     'value' => function($model){
            //         return $model->sku->getName();
            //     }
            // ],
            [
                'label' => '使用人',
                'value' => function($model) {
                    $dead = $model->getDeads();
                    return implode(ArrayHelper::getColumn($dead, 'dead_name'),',');
                }
            ],

            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '导购',
                'value' => function($model){
                    return $model->guide->username;
                },
                'format' => 'ntext'
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '账号',
                'value' => function($model){
                    return $model->user->username;
                },
                'format' => 'ntext'
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => 'PS图',
                'value' => function($model){
                    return $model->photo_processed;
                },
                'format' => 'ntext'
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '确认图',
                'value' => function($model){
                    return $model->photo_confirm;
                },
                'format' => 'ntext'
            ],
            [
                'headerOptions' => ["data-breakpoints"=>"all"],
                'label' => '备注',
                'value' => function($model){
                    return $model->note;
                },
                'format' => 'ntext'
            ],

            [
                'headerOptions' => ["data-type"=>"html"],
                'label' => '瓷像状态',
                'value' => function($model){
                    return '<span class="status-text">' . $model->statusText . '</span>';
                },
                'format' => 'raw',
                'options' => ['class'=>'abc']
            ],

            // 'order_id',
            // 'order_rel_id',
            // 'dead_ids',
            // 'confirm_by',
            // 'confirm_at',
            'use_at:date',
            // 'up_at',
            // 'notice_id',
            // 'type',
            'statusText',
            // 'updated_at',
            // 'created_at',

            [
                'header' => '操作',
                'headerOptions' => ["data-type"=>"html",'width'=>'150'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {view} {complete}',
                'buttons' => [
                    'complete' => function($url, $model, $key) {
                        return $model->status == Portrait::STATUS_MAKE ? Html::a('完成', $url, ['title' => '完成', 'class'=>'cmp btn btn-default btn-sm'] ) : '';
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => '编辑', 'class'=>'modalEditButton'] );
                    }

                ],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('table') ?>  
  $(function(){
    $('.table').footable();
    upinit();
    $('.cmp').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var that = this;
        $.post(url, {}, function(xhr){
            if (xhr.status) {
                $(that).closest('tr').find('.status-text').text('完成');
                $(that).remove();
            }
        },'json');
    });
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
<?php $this->registerJs($this->blocks['table'], \yii\web\View::POS_END); ?>  