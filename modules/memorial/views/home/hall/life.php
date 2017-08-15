<?php
$this->params['current_nav'] = 'life';
?>
<div class="container memorial-container">
    <div class="row">
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
        <div class="col-md-9 mb20">
            <div class="box">
                <h2 style="text-align: center">生平简介</h2>
                <div class="about">
                    <?php foreach ($deads as $dead):?>
                    <h3><?=$dead->dead_name?> <small>(<?=$dead->birth?> ~ <?=$dead->fete?>)</small></h3>
                    <div style="color:#666">
                        <?=$dead->desc?>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>