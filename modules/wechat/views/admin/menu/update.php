<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model manage\models\wechat\Menu */

$this->title = ' ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '菜 单', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编 辑 [' . $this->title .']';
?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-7 wechat-create">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-md-5">
                <!-- general form elements disabled -->
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">请注意</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <p>这里是一些注释</p>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

