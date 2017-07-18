<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/15
 * Time: 14:43
 */
use app\core\helpers\Url;
app\assets\EchartsAsset::register($this);
?>
<div id="grave-status" style="height:300px;width:100%"></div>

<?php $this->beginBlock('per') ?>
$(function(){
    var myChart = echarts.init(document.getElementById('grave-status'), 'vintage');
    $.get('<?=Url::toRoute(['/analysis/admin/tomb/grave-status', 'grave_id'=>$grave_id])?>').done(function (data) {
        myChart.setOption({
            title: {
                text: '墓位销售情况',
<!--                subtext: 'Example in MetricsGraphics.js',-->
                left: 'right',
                bottom:'bottom'
            },
            roseType : 'radius',
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            series : [
                {
                    name: '年销售占比',
                    type: 'pie',
                    radius: '70%',
                    data:data.data
                }
            ]
        })

    })

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>
