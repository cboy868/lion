<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

app\assets\EchartsAsset::register($this);

$this->title = '数据统计';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>数据统计</h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-4 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'agencyYear'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-xs-8 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'agencyMonth'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-xs-4 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'agentYear'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-xs-8 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'agentMonth'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div>


    </div><!-- /.page-content-area -->
</div>
