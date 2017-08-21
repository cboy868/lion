<?php
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->params['current_nav'] = 'memorial';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/mindex.css');
\app\assets\SwiperAsset::register($this);
\app\assets\ModalAsset::register($this);
\app\assets\FontawesomeAsset::register($this);
\app\assets\JqueryuiAsset::register($this);
?>
<style>
    .uinfo{
        font-size:10px;
        text-align: right;
    }
    .dead{
        color:#666;
        font-weight:700;
    }
    .msg-box img{
        max-width:90%;
        max-height: 100px;
    }
    .msg-more a{
        color:#666;
    }
    .flower .media-heading{
        font-size:14px;
    }
    .flower .media{
        height:75px;
        overflow: hidden;
    }
    .pray-msg{
        color:#666;
        font-size:12px;
    }

</style>
<div class="container memorial-container">
    <?php
    Modal::begin([
        'header' => '点烛献花',
        'id' => 'modalAdd',
        'clientOptions' => ['backdrop' => 'static', 'show' => false],
        'size' => 'modal-lg'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
    ?>

    <?php
    Modal::begin([
        'header' => '远程祭祀',
        'id' => 'modalEdit',
        'clientOptions' => ['backdrop' => 'static', 'show' => false],
        'size' => 'modal-lg'
    ]) ;

    echo '<div id="editContent"></div>';

    Modal::end();
    ?>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-8 info pull-right">

                    <div class="avatar">
                        <img width="180" height="180" src="<?=$memorial->getThumbImg('160x160')?>" alt="">
                    </div>
                    <h2 class="h2"><?=$memorial->title?></h2>

                    <?php if ($memorial->deads):?>
                        <?php foreach ($memorial->deads as $v):?>
                            <div class="personal-info-time">
                                <span class="dead"><?=$v->dead_name?></span>  出生：<?=$v->birth?>
                                <span class="death-time">离世：<?=$v->fete?></span>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                    <hr>

                    <div class="intro">
                        <?=$memorial->intro?>
                    </div>
                    <div class="btns">

                        <a href="<?=Url::toRoute(['remote','mid'=>$memorial->id])?>"
                           class="modalEditButton btn btn-default pull-left"
                           data-loading-text="页面加载中, 请稍后..."
                           onclick="return false"
                        >远程祭祀</a>

                        <a href="<?=Url::to(['candle-flower', 'id'=>$memorial->id])?>"
                           class="modalAddButton btn btn-default pull-right"
                           data-loading-text="页面加载中, 请稍后..."
                           onclick="return false"
                        >点烛献花</a>

                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <div class="tracks">
                        <?php foreach ($tracks as $track):?>
                            <a href="javascript:void(0)">
                                <img src="<?=$track->user->getAvatar('46x46')?>" width="40" height="40" title="<?=$track->user->username?>">
                            </a>
                        <?php endforeach;?>
                    </div>

                </div>
                <div class="col-md-4 aside-box pull-left">
                    <div class="remote">
                        <ul class="media-list">
                            <li class="video">
                                <a href="#">
                                    <img src="http://lion.ibagou.com/upload/image/thumb/201708/380x265@1502867489472.jpeg" alt="">
                                </a>
                                <div class="img-intro">远程祭祀的一些描述 </div>
                                <div class="uinfo">--张三 于 <i>2017-06-01</i></div>
                            </li>
                            <li class="video">
                                <a href="#">
                                    <img src="http://lion.ibagou.com/upload/image/thumb/201708/380x265@1502867489472.jpeg" alt="">
                                </a>
                                <div class="img-intro">远程祭祀的一些描述 </div>
                                <div class="uinfo">--张三 于 <i>2017-06-01</i></div>
                            </li>
                            <li class="video">
                                <a href="#">
                                    <img src="http://lion.ibagou.com/upload/image/thumb/201708/380x265@1502867489472.jpeg" alt="">
                                </a>
                                <div class="img-intro">远程祭祀的一些描述 </div>
                                <div class="uinfo">--张三 于 <i>2017-06-01</i></div>
                            </li>
                            <li class="video">
                                <a href="#">
                                    <img src="http://lion.ibagou.com/upload/image/thumb/201708/380x265@1502867489472.jpeg" alt="">
                                </a>
                                <div class="img-intro">远程祭祀的一些描述 </div>
                                <div class="uinfo">--张三 于 <i>2017-06-01</i></div>
                            </li>
                            <li class="video">
                                <a href="#">
                                    <img src="http://lion.ibagou.com/upload/image/thumb/201708/380x265@1502867489472.jpeg" alt="">
                                </a>
                                <div class="img-intro">远程祭祀的一些描述 </div>
                                <div class="uinfo">--张三 于 <i>2017-06-01</i></div>
                            </li>
                            <li class="video">
                                <a href="#">
                                    <img src="http://lion.ibagou.com/upload/image/thumb/201708/380x265@1502867489472.jpeg" alt="">
                                </a>
                                <div class="img-intro">远程祭祀的一些描述 </div>
                                <div class="uinfo">--张三 于 <i>2017-06-01</i></div>
                            </li>

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div class="col-md-3 aside-box">
            <div class="flower">
                <ul class="media-list pray">
                    <?php
                    $cfg = $this->context->module->params['memorial_types'];
                    ?>
                    <?php foreach ($prays as $pray):?>
                    <li class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?=$cfg[$pray->type]['cover']?>" alt="<?=$cfg[$pray->type]['title']?>">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?=$pray->user->username?> 为您
                                <?php if (!in_array($pray->type, ['candle', 'flower'])) echo '送来'?>
                                 <?=$cfg[$pray->type]['title']?></h4>
                            <div class="pray-msg">
                                <?=$pray->msg?>
                            </div>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>


            </div>
        </div>

    </div>
</div>

<div class="container album-container">
    <div class="row">

        <div class="album col-md-12">
            <div class="album-top"></div>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($photos as $photo):?>
                    <div class="swiper-slide" style="height:300px;width:300px;">
                        <img src="<?=$photo->getThumb()?>" alt="">
                    </div>
                    <?php endforeach;?>
                </div>
                <!-- 如果需要导航按钮 -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="album-bottom"></div>
        </div>

    </div>
</div>
<div class="container memorial-container">
    <div class="row text-content"  id="msg-start">
        <div class="col-md-12 text-header">
            <h2>祝福追忆</h2>
            <hr>
        </div>

        <div class="col-md-6 msg-list">
            <?php foreach ($msgs as $v):?>
            <div class="msg-box">
                <div class="msg">
                    <?=$v->content?>
                </div>
                <div class="u-info pull-right">
                    <a class="avatar pull-right">
                        <img src="<?=$v->fromUser->getAvatar('36x36')?>" alt="">
                    </a>

                    <div class="u-text pull-right">
                        <p><span class="fa fa-user"></span> <?=$v->fromUser->username?></p>
                        <p><span class="fa fa-clock-o"></span> <?=date('Y-m-d', $v->created_at);?></p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php endforeach;?>


            <hr>
            <div class="msg-more" style="text-align: right;margin-bottom:10px;">
                <a href="<?=Url::toRoute(['msg','id'=>$memorial->id])?>" target="_blank">更多祝福</a>
            </div>

            <?php if (!Yii::$app->user->isGuest):?>
            <div class="msg-form">
                <?php $form = ActiveForm::begin(); ?>

                <?=$form->field($comment,'res_name')->hiddenInput(['value'=>'memorial'])
                    ->label(false)?>

                <?=$form->field($comment,'res_id')->hiddenInput(['value'=>Yii::$app->request->get('id')])
                    ->label(false)?>

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
                    <?=Html::submitButton(' 发送祝福 ', ['class' => 'btn btn-danger btn-sm msg-send','style'=>'width:80px;margin-right:20px;']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <?php endif;?>



        </div>
        <div class="col-md-6 miss-list">
            <?php foreach ($miss as $v):?>
            <div class="msg-box">

                <div class="msg">
                    <h4><?=$v->title?></h4>
                    <?=\app\core\helpers\Html::cutstr_html($v->body, 200);?>
                </div>

                <div class="u-info">
                    <span class="pull-left tool-open">
                        <a href="<?=Url::toRoute(['/memorial/home/hall/miss-view','id'=>$memorial->id, 'bid'=>$v->id])?>" target="_blank">详情</a>
                    </span>

                    <a class="avatar pull-right">
                        <img src="<?=$v->user->getAvatar('36x36')?>" alt="">
                    </a>

                    <div class="u-text pull-right">
                        <p><span class="fa fa-user"></span> <?=$v->user->username?></p>
                        <p><span class="fa fa-clock-o"></span> <?=date('Y-m-d', $v->created_at)?></p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <?php endforeach;?>
            <hr>
            <div class="msg-more">
                <a href="<?=Url::toRoute(['miss','id'=>$memorial->id])?>" target="_blank">更多追忆</a>
                <a href="<?=Url::toRoute(['/memorial/member/default/miss', 'id'=>$memorial->id])?>" style="float:right;" target="_blank">发表纪念文章</a>
            </div>

        </div>
    </div>
    <div class="clear"></div>
</div>

<?php $this->beginBlock('cate') ?>

    (function(){
        function move(obj, speed){
            var first = obj.children().eq(0);
            first.slideUp(speed, function() {
                obj.append(this);
                $(this).show();
            });

        }
        function scroll(obj, json){
            var speed = json.speed || 1000,
                interval = json.interval || 5000,
                toStop = json.toStop || false,
                timer = null;

            if(toStop){
                obj.hover(function(){
                    clearInterval(timer);
                },function(){
                    autoPlay();
                });
            }

            function autoPlay(){
                timer = setInterval(function(){
                    if (obj.is(':visible')) {
                        move(obj, speed);
                    }
                }, interval);
            }
            autoPlay();

        }
        (!jQuery.autoScroll)&&(jQuery.autoScroll = scroll);
    })();
$(function(){


    $('ul.pray').each(function () {
        $.autoScroll($(this), {
            speed : 1000,
            interval : 1000,
            toStop : true //鼠标移入停止滚动 默认为 false
        });
    });

    $('.msg-send').click(function(e){
        e.preventDefault();

        var content = editor_comment_content.getContent();
        if (content == ''){
            alert('请填写祝福内容');
            return;
        }

        var data = $(this).closest('form').serialize();

        $.post("<?=Url::toRoute(['create-msg'])?>",data,function(xhr){
            if (xhr.status) {
                location.href="<?=Url::toRoute(['memorial','id'=>$memorial->id,'#'=>'msg-start'])?>";
                location.reload();
            } else{
                alert(xhr.info);
            }
        },'json');

    });

})

<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>

