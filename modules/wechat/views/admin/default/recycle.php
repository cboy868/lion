<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model modules\wechat\models\Wechat */
$this->title="公众号列表";
$this->params['breadcrumbs'][] = '公众号管理';
?>
<style type="text/css">
    div.page-header span.active{
            border-bottom: 2px solid #2679b5;
            padding-bottom: 15px;
    }

    div.page-header a:hover{
        padding-bottom: 15px;
        border-bottom: 2px solid #2679b5;
        text-decoration: none;
    }
    div.page-header a{
        color:#2679b5
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <span>
                <a href="<?=Url::toRoute(['index'])?>"><?= Html::encode($this->title) ?></a>
                </span>
                <span class="active">
                    公众号回收站
                </span>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-8 wechat-update">
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
