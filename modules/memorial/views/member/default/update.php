<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;


$this->title = '修改纪念馆基本信息';
$this->params['breadcrumbs'][] = ['label' => '纪念馆管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .nc{margin-right: 10px;}
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <?= \app\core\widgets\Alert::widget()?>
    <div class="page-content-area">
        <div class="row">
            <style>
                .dead{
                    float:left;
                    width:170px;
                }
                .dead a,table a{
                    color:#333;
                }
            </style>

            <div class="col-xs-2">
                <div class="list-group no-radius no-border no-bg ">
                    <a href="#" class="list-group-item active">基本信息</a>
                    <a href="<?=Url::toRoute(['/memorial/member/default/deads', 'id'=>$model->id])?>" class="list-group-item">逝者资料</a>
                    <a href="#" class="list-group-item ">档案资料</a>
                    <!--                    <a href="#" class="list-group-item">模板设置</a>-->
                    <a href="#" class="list-group-item">追忆文章</a>
                    <a href="#" class="list-group-item">回忆相册</a>
                    <a href="#" class="list-group-item">祝福管理</a>
                </div>
            </div>

            <div class="col-xs-10 memorial-index">

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
