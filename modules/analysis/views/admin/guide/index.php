<?php
app\assets\EchartsAsset::register($this);
?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>数据统计</h1>
        </div><!-- /.page-header -->
        <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideYearPercent'])?>
        <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideYearCompare'])?>
        <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideSelfMonth'])?>
        <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideMonthPercent'])?>
        <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'guideMonthCompare'])?>
    </div>
</div>



