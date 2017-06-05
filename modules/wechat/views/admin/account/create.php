<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\modules\wechat\models\Wechat */

$this->title = '添加新公众号';
$this->params['breadcrumbs'][] = ['label' => '公众号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="/css/wechat.css">
<div class="panel panel-content">
    <div class="panel-body clearfix main-panel-body">

        <?= $this->render('../default/left');?>
        <div class="right-content">
            <div class="page-header">
                <h1>
                    <?= Html::encode($this->title) ?>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-10 wechat-create">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            </div><!-- /.row -->


        </div>
    </div>
</div>

