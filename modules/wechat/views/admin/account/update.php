<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\wechat\models\Wechat */

$this->title = ' ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '公众号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改';
?>
<link rel="stylesheet" href="/css/wechat.css">
<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">
        <?= $this->render('../default/left');?>
        <div class="right-content">
            <div class="page-header">
                <h1>
                    <?= Html::encode($this->title) ?>
                    <small>
                        修改详细信息
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12 wechat-update">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
    </div>
</div>