<?php
app\assets\EchartsAsset::register($this);

$this->title = '墓位销售统计';
$this->params['breadcrumbs'][] = ['label' => '统计', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>墓位可调用的各种统计</h1>
        </div><!-- /.page-header -->

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
        <div class="row">
            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget([
                        'name'=>'graveStatus',
                    'options'=>['grave_id'=>Yii::$app->request->get('id')]])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-xs-12 client-index">
                <h3>统计分析</h3>
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php for($i=1; $i<=date('m'); $i++): ?>
                            <li role="presentation" class="<?php if ($i==date('m')): ?> active <?php endif ?>"><a href="#t<?=$i?>" aria-controls="home" role="tab" data-toggle="tab"><?=$i?>月</a></li>
                        <?php endfor; ?>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php for($i=1; $i<=date('m'); $i++): ?>
                            <div role="tabpanel" class="tab-pane  <?php if($i==date('m')):?> active<?php endif;?>" id="t<?=$i?>">
                                <textarea class="form-control" rows="15" name="t[<?=$i?>]" <?php if ($i<date('m')): ?> disabled<?php endif ?>></textarea>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
