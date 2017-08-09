<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\ActiveForm;
use app\core\models\Attachment;
use yii\bootstrap\Modal;

\app\assets\ExtAsset::register($this);
\app\assets\PluploadAssets::register($this);


$this->title = '照片明细';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <?php
        Modal::begin([
            'header' => '新增逝者',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
             'size' => 'modal-lg'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>
        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'album'])?>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>
                <div class="page-header">
                    <h1>
                            <a href="<?=Url::to(['create-album', 'id'=>$model->id])?>" class='btn btn-danger btn-sm modalAddButton'
                               data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-plus"></i>创建相册</a>
                    </h1>

                </div>
                <style>
                    .img-full {
                        width: 100%;
                    }
                    .r-2x {
                        border-radius: 4px;
                    }
                    .r {
                        border-radius: 2px 2px 2px 2px;
                    }
                    .wrapper-sm {
                        padding: 10px;
                    }
                    .pos-rlt {
                        position: relative;
                    }
                    .item .bottom {
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 0;
                    }
                    .badge {
                        margin-bottom: 5px;
                        margin-right: 5px;
                    }
                    a{
                        color:#333;
                    }
                    .deal{
                        margin-left:5px;
                    }
                    .bg-white{
                        color:#666;
                        background-color: #fff;
                    }
                    .bg-set{
                        color:#666;
                        background-color: #62A8D1;
                    }
                </style>

                <div class="row masonry">
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="item panel panel-default wrapper-sm">
                            <div class="pos-rlt">
                                <div class="bottom">
                                    <a class="pull-right badge bg-set"><small>设为封面</small></a>
                                </div>
                                <a href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320">
                                    <img class="r r-2x img-full" alt="" src="http://www.5201000.com/UploadFiles/Image/2017/8/8/Heaven/ImgInfo/ImageImgPath/20170808204128.jpg">
                                </a>
                            </div>
                            <div class="padder-h text-center">
                                <input type="text" placeholder="参军照" value="参军照" style="width:100%;">
                                <textarea placeholder="照片描述" style="width:100%;height:80px;">描述</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="item panel panel-default wrapper-sm">
                            <div class="pos-rlt">
                                <div class="bottom">
                                    <a class="pull-right badge bg-set"><small>设为封面</small></a>
                                </div>
                                <a href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320">
                                    <img class="r r-2x img-full" alt="" src="http://www.5201000.com/UploadFiles/Image/2017/8/8/Heaven/ImgInfo/ImageImgPath/20170808204128.jpg">
                                </a>
                            </div>
                            <div class="padder-h text-center">
                                <input type="text" placeholder="参军照" value="参军照" style="width:100%;">
                                <textarea placeholder="照片描述" style="width:100%;height:80px;">描述</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="item panel panel-default wrapper-sm">
                            <div class="pos-rlt">
                                <div class="bottom">
                                    <a class="pull-right badge bg-set"><small>设为封面</small></a>
                                </div>
                                <a href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320">
                                    <img class="r r-2x img-full" alt="" src="http://www.5201000.com/UploadFiles/Image/2017/8/8/Heaven/ImgInfo/ImageImgPath/20170808204128.jpg">
                                </a>
                            </div>
                            <div class="padder-h text-center">
                                <input type="text" placeholder="参军照" value="参军照" style="width:100%;">
                                <textarea placeholder="照片描述" style="width:100%;height:80px;">描述</textarea>
                            </div>
                        </div>
                    </div>


                </div>



                <footer class="panel-footer">
                    <div class="row">

                        111

                    </div>
                </footer>



                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('cate') ?>
$(function(){
    $('.selize-rel').each(function(index, item){
        var $this = $(item);
        if ( !$this.data('select-init') ) {
            $this.selectize({
                create: true
            });
        }
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>




