<?php
app\assets\EchartsAsset::register($this);

$this->title = '数据统计';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area" style="margin-bottom:50px;">
        <h2>墓位销售情况统计</h2>
        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'tombNum'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div>
        <hr>





    </div><!-- /.page-content-area -->
</div>
