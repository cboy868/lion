<?php
$this->params['current_nav'] = 'achive';
?>

<div class="container memorial-container">
    <!--这里加内容-->
        <div class="row">
            <!-- 左边开始 -->
            <div class="col-md-3 hidden-sm no-padding-right mb20">

                <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>$model->memorial_id])?>
                <div class="blank"></div>
                <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>$model->memorial_id])?>
                <div class="blank"></div>
                <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'miss','mid'=>$model->memorial_id])?>
                <div class="blank"></div>
                <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'archive','mid'=>$model->memorial_id])?>
                <div class="blank"></div>
                <?=\app\modules\memorial\widgets\Mem::widget([
                        'method'=>'track',
                    'res_name'=>\app\modules\user\models\Track::RES_ARCHIVE,
                    'mid'=>$model->id])?>

            </div>
            <!-- -------------左边结束--------------- -->
            <!-- -------------右边开始--------------- -->
            <div class="col-md-9 mb20">

                <ul class="breadcrumb">
                    当前位置:
                    <li><a href="<?=\yii\helpers\Url::toRoute(['index', 'id'=>$model->memorial_id])?>">首页</a></li>
                    <li><a href="<?=\yii\helpers\Url::toRoute(['archive', 'id'=>$model->memorial_id])?>">追忆</a></li>
                    <li class="active"><?=$model->title?></li>
                </ul>
                <div class="box">
                    <h2 style="text-align: center"><?=$model->title?></h2>
                    <div class="blank"></div>
                    <div style="    margin-bottom: 5px;">
                        <span>作者: <?=$model->user->username?></span>
                        <span>发布时间: <?=date('Y-m-d H:i', $model->created_at)?></span>
                    </div>
                    <div class="line"></div>
                    <div class="blank"></div>
                        <!-- -------------内容开始--------------- -->
                    <div class="news-list" style="line-height: 1.5em;color: #666;">
                        <?=$model->body?>
                    </div>

                    <div class="clear"></div>
                </div>
            </div>
            <!-- -----------右边结束--------------- -->
        </div>

</div>