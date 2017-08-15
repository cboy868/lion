<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->params['current_nav'] = 'msg';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/remark.css');

\app\assets\FontawesomeAsset::register($this);
?>
<style>
    .publish-content{
        width:100%;
        padding-bottom:0;
    }
    .list-unstyled{
        margin-bottom:0;
    }
</style>
<div class="container memorial-container">
    <div class="row">
        <!---------------左边开始----------------->
        <div class="col-md-3 hidden-sm no-padding-right mb20">
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>Yii::$app->request->get('id')])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>Yii::$app->request->get('id')])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'miss','mid'=>Yii::$app->request->get('id')])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'archive','mid'=>Yii::$app->request->get('id')])?>
            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'track','mid'=>Yii::$app->request->get('id')])?>
        </div>
        <!---------------左边结束----------------->

        <!---------------右边开始----------------->
        <div class="col-md-9 mb20">

            <div class="box">
                <div class="row page-nav">
                    <h2 style="text-align: center">祝福留言</h2>
                </div>
                <div class="blank"></div>

                <div class="box" style="background: #fff;padding:0">
                    <?php $form = ActiveForm::begin(); ?>

                    <?=$form->field($comment,'res_name')->hiddenInput(['value'=>'memorial'])->label(false)?>

                    <?=$form->field($comment,'res_id')->hiddenInput(['value'=>Yii::$app->request->get('id')])->label(false)?>

                    <?= $form->field($comment,'content')->widget('app\core\widgets\Ueditor\Ueditor',[
                        'option' =>['res_name'=>'blog', 'use'=>'ue'],
                        'value'=>$comment->content,
                        'jsOptions' => [
                            'initialFrameHeight'=>100,
                            'toolbars' => [
                                [
                                    'undo', 'redo', 'simpleupload','emotion'
                                ],
                            ]
                        ]
                    ])->label(false);
                    ?>

                    <div class="form-group" style="text-align: right">
                        <?=Html::submitButton(' 发送祝福 ', ['class' => 'btn btn-danger btn-sm zhufu','style'=>'width:80px;margin-right:20px;']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class="blank"></div>

                <div id="replayContet">
                    <div class="blank"></div>
                    <div id="times-list">

                        <?php foreach ($comments['list'] as $comment):?>

                        <div class="post-box">
                            <div class="publish-author">
                                <div class="p-author">
                                    <a href="#">
                                        <img class="img-responsive img-rounded center-block" src="<?=$comment['avatar']?>">
                                        <p><?=$comment['username']?></p>
                                    </a>
                                </div>
                            </div>
                            <div class="publish-content">
                                <div class="p-cont">
                                    <?=$comment['content']?>
                                </div>
                                <div class="p-tool">
                                    <ul class="list-unstyled">
                                        <li><div><span class="fa fa-user"></span> <?=$comment['username']?></div></li>
                                        <li><div><span class="fa fa-clock-o"></span> <?=date('Y-m-d H:i', $comment['created_at'])?></div></li>

                                        <div class="clear"></div>
                                    </ul>
                                </div>
                                <!-- 回复 -->

                                <?php if (isset($comment['child'])):?>
                                    <?php foreach ($comment['child'] as $reply):?>
                                <div class="p-reply">
                                    <div class="r-author">
                                        <a href="javascript:void(0)">
                                            <img src="<?=$reply['avatar']?>">
                                        </a>
                                    </div>
                                    <div class="r-user">
                                        <div class="a-cont">
                                            <?php if (isset($reply['tousername'])):?>
                                                <a href="#" target="_blank"><?=$reply['username']?></a> 回复
                                                <a href="#" target="_blank"><?=$reply['tousername']?></a>
                                                <?php else:?>
                                                <a href="#" target="_blank"><?=$reply['username']?>：</a>
                                            <?php endif;?>

                                            <?=$reply['content']?>
                                            <div class="post-date">
                                                <?=date('Y-m-d H:i', $reply['created_at'])?>
                                                <a class="replyto" href="javascript:;"
                                                   data-uid="<?=$reply['from']?>"
                                                   data-pid="<?=$comment['id']?>"
                                                   data-rid="<?=$comment['res_id']?>"
                                                   data-toname="<?=$reply['username']?>">
                                                    <span class="fa fa-reply"></span> 回复
                                                </a>
                                                <div class="tarea" ></div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                        <?php endforeach;?>
                                <?php endif;?>
                                <div class="ttxx-msg reply-author">
                                    <div style="background: #efefef;padding: 2px 0;border-radius: 4px;">
                                        <textarea style="width: 100%;height:3em;" rows="3"
                                                  placeholder="给<?=$comment['username']?>留言 "
                                                  data-to="<?=$comment['from']?>"
                                                  data-rid="<?=$comment['res_id']?>"
                                                  data-pid="<?=$comment['id']?>"
                                        ></textarea>
                                        <button class="btn btn-danger pull-right btn-xs send-msg">发送</button>
                                        <div style="clear: both;"></div>
                                    </div>
                                </div>

                                <!-- 回复结束 -->
                            </div>
                            <div class="clear"></div>
                        </div>

                        <?php endforeach;?>

                    </div>
                    <footer class="panel-footer">
                        <div class="row">

                            <?php
                            echo \yii\widgets\LinkPager::widget([
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

                </div>
            </div>
        </div>
        <!---------------右边结束----------------->
    </div>

</div>
<?php $this->beginBlock('tree') ?>
$(function(){
    $('.replyto').click(function(e){
        e.preventDefault();

        var uid = $(this).data('uid');
        var pid = $(this).data('pid');
        var res_id = $(this).data('rid');
        var toname = $(this).data('toname');
        var html = '<div style="background: #efefef;padding: 10px 5px;border-radius: 4px;margin-bottom:5px;">'
    +'<textarea style="width: 100%;height:3em;" data-pid="'+pid
            +'" data-to="'+uid
            +'" data-rid="'+res_id
            +'" rows="3" placeholder="回复'+toname+'"></textarea>'
    +'<button class="btn btn-danger pull-right btn-xs send-msg">发送</button>'
+'<div style="clear: both;"></div>'
    +'</div>';

        var obj = $(this).closest('.post-date').find('.tarea');
        $('.tarea').html('');
        obj.html(html);
    });

    $('body').on('click', '.send-msg', function(e){
        e.preventDefault();
        var obj = $(this).siblings('textarea');

        var content = obj.val();
        var pid = obj.data('pid');
        var to  = obj.data('to');
        var res_id = obj.data('rid');
        var csrf = "<?=Yii::$app->request->getCsrfToken()?>";

        var data = {content:content,pid:pid,to:to,res_name:'memorial',res_id:res_id,_csrf:csrf};


        $.post('<?=Url::toRoute(['reply-msg'])?>', data, function(xhr){

            if (xhr.status) {
            location.reload();
            } else {
                alert(xhr.info);
            }

        },'json');

    });

    $('.zhufu').click(function(e){
        e.preventDefault();

        var data = $(this).closest('form').serialize();

        $.post("<?=Url::toRoute(['create-msg'])?>",data,function(xhr){
            if (xhr.status) {
                location.reload();
            } else{
                alert(xhr.info);
            }
        },'json');

    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>


