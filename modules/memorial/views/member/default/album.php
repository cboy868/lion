<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\ActiveForm;
use app\core\models\Attachment;
use yii\bootstrap\Modal;

\app\assets\ExtAsset::register($this);
\app\assets\PluploadAssets::register($this);


$this->title = '追忆文章';
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
                </style>

                <div class="row masonry">
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="item panel panel-default wrapper-sm">
                            <div class="pos-rlt">
                                <div class="bottom">
                                    <span class="pull-right badge bg-white"><small>123</small></span>
                                </div>
                                <a href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320">
                                    <img class="r r-2x img-full" alt="" src="http://www.5201000.com/UploadFiles/Image/2017/8/8/Heaven/ImgInfo/ImageImgPath/20170808204128.jpg">
                                </a>
                            </div>
                            <div class="padder-h text-center">
                                <h4 class="h4 m-b-sm">参军照 </h4>

                                <a href="javascript:void(0)" onclick="LoadAjaxModal('修改', '/MemberCenter/Album/Edit?id=41320')">
                                    <span class="fa fa-wrench"></span> 修改
                                </a>
                                <a class="m-l" href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320"><span class="fa fa-plus"></span> 添加相片</a>
                                <a class="m-l" href="#" data-id="formImgGroup41320" data-toggle="confirmation" data-original-title="" title=""><span class="fa fa-trash-o"></span> 删除</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="item panel panel-default wrapper-sm">
                            <div class="pos-rlt">
                                <div class="bottom">
                                    <span class="pull-right badge bg-white m-r-xs m-b-xs"><small>123</small></span>
                                </div>
                                <a href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320">
                                    <img class="r r-2x img-full" alt="" src="http://www.5201000.com/UploadFiles/Image/2017/8/8/Heaven/ImgInfo/ImageImgPath/20170808204128.jpg">
                                </a>
                            </div>
                            <div class="padder-h text-center">
                                <h4 class="h4 m-b-sm">参军照 </h4>

                                <a href="javascript:void(0)" onclick="LoadAjaxModal('修改', '/MemberCenter/Album/Edit?id=41320')">
                                    <span class="fa fa-wrench"></span> 修改
                                </a>
                                <a class="m-l" href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320"><span class="fa fa-plus"></span> 添加相片</a>
                                <a class="m-l" href="#" data-id="formImgGroup41320" data-toggle="confirmation" data-original-title="" title=""><span class="fa fa-trash-o"></span> 删除</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                        <div class="item panel panel-default wrapper-sm">
                            <div class="pos-rlt">
                                <div class="bottom">
                                    <span class="pull-right badge bg-white m-r-xs m-b-xs"><small>123</small></span>
                                </div>
                                <a href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320">
                                    <img class="r r-2x img-full" alt="" src="http://www.5201000.com/UploadFiles/Image/2017/8/8/Heaven/ImgInfo/ImageImgPath/20170808204128.jpg">
                                </a>
                            </div>
                            <div class="padder-h text-center">
                                <h4 class="h4 m-b-sm">参军照 </h4>

                                <a href="javascript:void(0)" onclick="LoadAjaxModal('修改', '/MemberCenter/Album/Edit?id=41320')">
                                    <span class="fa fa-wrench"></span> 修改
                                </a>
                                <a class="deal" href="/MemberCenter/Album/PhotoList?ParentUrl=Memorial&amp;id=e2042e8b-3f39-4d20-b559-75a414e34f89&amp;Gid=41320"><span class="fa fa-plus"></span> 添加相片</a>
                                <a class="deal" href="#" data-id="formImgGroup41320" data-toggle="confirmation" data-original-title="" title=""><span class="fa fa-trash-o"></span> 删除</a>
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




