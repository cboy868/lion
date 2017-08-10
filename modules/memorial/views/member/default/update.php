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

            <?=$this->render('left-menu', ['cur'=>'base'])?>

            <div class="col-xs-10 memorial-index">

                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
