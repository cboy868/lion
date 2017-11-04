<?php
app\assets\EchartsAsset::register($this);

$this->title = '数据统计';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area" style="margin-bottom:50px;">
        <p style="color:green;">
            以下为统计示例，正式应用时，只有领导层能看到此统计页面
        </p>
        <h2>墓位销售情况统计</h2>
        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'tombNum'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'tombAmount'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>

        <h2>导购人员年份业务统计</h2>

        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideYearPercent'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideYearCompare'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
        <hr>
        <h2>
            导购人员月份统计
        </h2>
        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideMonthPercent'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideMonthCompare'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
        </div>
        <hr>
        <h2>导购个人业务统计</h2>
        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideSelfMonth'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>

        <h2>导购个人接待占比统计</h2>

        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'clientYearPercent'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div>
        <hr>
        <h2>导购个人接待对比统计</h2>
        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'clientYearCompare'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->


    </div><!-- /.page-content-area -->
</div>
