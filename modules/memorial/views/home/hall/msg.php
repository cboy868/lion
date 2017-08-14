<?php
$this->params['current_nav'] = 'msg';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/remark.css');

\app\assets\FontawesomeAsset::register($this);
?>
<div class="container memorial-container">
    <div class="row">
        <!---------------左边开始----------------->
        <div class="col-md-3 hidden-sm no-padding-right mb20">

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>Yii::$app->request->get('id')])?>

            <div class="blank"></div>

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>Yii::$app->request->get('id')])?>

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
                                            <p class="post-date">
                                                <?=date('Y-m-d H:i', $reply['created_at'])?>
                                                <a class="replyto" href="javascript:;">
                                                    <span class="fa fa-reply"></span> 我要回复
                                                </a>
                                            </p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                        <?php endforeach;?>
                                <?php endif;?>
                                <form onsubmit="return false">
                                    <div class="ttxx-msg reply-author">
                                        <div class="placeholder">我也说一句...</div>
                                        <div class="reply-editor"></div>
                                    </div>
                                </form>

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

