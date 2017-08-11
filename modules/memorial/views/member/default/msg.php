<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\ActiveForm;
use app\core\models\Attachment;
use yii\bootstrap\Modal;
use yii\widgets\LinkPager;

\app\assets\ExtAsset::register($this);
\app\assets\PluploadAssets::register($this);


$this->title = '祝福语管理';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\app\core\widgets\Ueditor\UAsset::register($this);
\app\assets\VueAsset::register($this);
?>

<style type="text/css">
    body{
        color:#788188;
    }
    a {
        color: #545a5f;
        text-decoration: none;
    }
    a {
        background: transparent;
    }
    .post-item {
        border-radius: 3px;
        background-color: #fff;
        -webkit-box-shadow: 0px 1px 2px rgba(0,0,0,0.15);
        box-shadow: 0px 1px 2px rgba(0,0,0,0.15);
        margin-bottom: 15px;
    }
    .wrapper-lg {
        padding: 30px;
    }
    .post-item .post-title {
        margin-top: 0;
    }
    .line-lg {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .line {
        height: 2px;
        margin: 10px 0;
        font-size: 0;
        overflow: hidden;
    }
    .text-muted {
        color: #939aa0;
    }
    .pagination {
        margin: 10px 0;
    }
    .panel-footer{
        padding:0 20px;
    }

</style>

<div class="page-content" id="memorial-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <?php
        Modal::begin([
            'header' => '发布祝福',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
             'size' => 'modal-lg'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>
        <div class="row">

            <?=$this->render('left-menu', ['cur'=>'msg', 'id'=>$model->id])?>

            <div class="col-xs-10 memorial-index">
                <?= \app\core\widgets\Alert::widget();?>
                <div class="page-header">

                    <div class="row">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($comment,'content')->widget('app\core\widgets\Ueditor\Ueditor',[
                            'option' =>['res_name'=>'comment', 'use'=>'ue'],
                            'value'=>$comment->content,
                            'name'=>'comment_content',
                            'id' => 'comment_content',
                            'jsOptions' => [
                                'initialFrameHeight'=>100,
                                'toolbars' => [
                                    [
                                        'source', 'undo', 'redo', '|',
                                        'fontsize',
                                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                                        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                                        'forecolor', 'backcolor', '|',
                                        'lineheight', 'simpleupload', '|',
                                        'indent', '|'
                                    ],
                                ]
                            ]
                        ])->label(false);
                        ?>

                        <div class="form-group">
                            <div class="pull-right">
                                <?=  Html::submitButton(' <i class="fa fa-plus"></i> 发布祝福 ',
                                    [
                                        'class' => 'button bg-sub btn btn-danger btn-comment',
                                        'style'=>'width:100px;',
                                        '@click.prevent'=>"comment"
                                    ]) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <div class="hr hr-18 dotted hr-double"></div>
                    </div><!-- /.row -->
                </div>


                <div class="blog-post">

                    <!-- item{ -->
                    <div class="post-item cms" v-for="cm in comments">
                        <div class="caption wrapper-lg">

                            <div class="post-sum" v-html="cm.content"></div>
                            <div class="line line-lg"></div>
                            <div class="text-muted">
                                <i class="fa fa-user icon-muted"></i> by <a class="m-r-sm" href="#" v-html="cm.username"></a>
                                <i class="fa fa-clock-o icon-muted"></i> <span class="m-r-sm" v-html="cm.date"></span>


                                <i class="fa fa-pencil icon-muted"></i>
                                <a href="javascript:void(0)" class="m-r-sm">修改</a>
                                <i class="fa fa-trash-o icon-muted"></i>
                                <a :href="'<?=Url::toRoute(['del-msg'])?>?id='+cm.id"  class="m-r-sm del-msg"> 删除 </a>
                            </div>

                            <div class="line line-lg"></div>
                            <!-- .comment-list -->
                            <section class="comment-list block cms" >
                                <!-- comment form -->
                                <article v-for="son in cm.child" style="margin-left:10px;border-bottom:1px solid #eee;">
                                    <div v-html="son.content"></div>
                                    <div style="text-align: right;">
                                        <a href="#" v-html="son.username"></a>
                                        <span class="text-muted m-l-sm"><i class="fa fa-clock-o"></i><i v-html="son.date"></i></span>
                                    </div>
                                </article>
                            </section>
                            <!-- / .comment-list -->
                        </div>
                    </div>
                    <!-- }item -->
                </div>


                <footer class="panel-footer">
                    <div class="row">

                        <?php
                        echo LinkPager::widget([
                            'pagination' => $comments['pagination'],
                            'nextPageLabel' => '>',
                            'prevPageLabel' => '<',
                            'lastPageLabel' => '尾页',
                            'firstPageLabel' => '首页',
                            'options' => [
                                'class' => 'pull-right pagination'
                            ]
                        ]);
                        ?>

                    </div>
                </footer>



                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('cate') ?>
$(function(){

    var app = new Vue({
        el:'#memorial-content',
        data:{
            commentUrl:"<?=\yii\helpers\Url::toRoute(['create-msg', 'id'=>$model->id])?>",
            delUrl:"<?=\yii\helpers\Url::toRoute(['del-msg'])?>",
            csrf : "<?=Yii::$app->request->getCsrfToken()?>",
            comments:<?=json_encode($comments['list'])?>
        },
        methods:{
            comment(){
                var content = editor_comment_content.getContent();

                if (!content) {return;}
                this.$http.post(this.commentUrl, {content:content,_csrf:this.csrf},{emulateJSON:true}).then(function(response){


                    if (response.data.status) {
                        this.$set(this, 'comments', response.body.data.list.concat(this.comments));
                    } else {
                        alert(response.data.info);
                    }
                }, function(response){

                });
                editor_comment_content.setContent('');
            }
        }
    });


    $('.del-msg').click(function (e) {
        e.preventDefault();
        if(!confirm('确定要删除此祝福吗?')){return false;}

        var url = $(this).attr('href');
        var that = this;
        $.get(url,function (xhr) {
            if (xhr.status) {
                $(that).closest('.cms').remove();
            }
        },'json');
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>




