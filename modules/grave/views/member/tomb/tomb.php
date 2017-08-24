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

            <?=$this->render('left-menu', ['cur'=>'tomb', 'model'=>$model])?>

            <div class="col-xs-10 memorial-index">
                <table class="table table-striped">
                    <tr>
                        <th width="100">墓位号</th>
                        <td><?=$model->tomb_no?></td>
                    </tr>
                    <tr>
                        <th>墓 区</th>
                        <td><?=$model->grave->name?></td>
                    </tr>
                    <tr>
                        <th>购买日期</th>
                        <td><?=$model->sale_time?></td>
                    </tr>
                    <tr>
                        <th>状 态</th>
                        <td><?=$model->statusText?></td>
                    </tr>

                    <tr>
                        <th>导 购</th>
                        <td><?=$model->guide->username?></td>
                    </tr>

                    <tr>
                        <th>办理人</th>
                        <td><?=$model->customer->name?>(<?=$model->customer->mobile?>)</td>
                    </tr>


                </table>

                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
