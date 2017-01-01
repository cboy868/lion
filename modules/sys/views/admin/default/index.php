<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '网站设置';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=  $this->title ?>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 set-index">
                <?= $this->render('_set', [
                    'settings' => $settings,
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>