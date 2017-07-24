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
<div id="year-compare" style="height:400px;"></div>

<?php $this->beginBlock('per') ?>
$(function(){
    var myChart = echarts.init(document.getElementById('year-compare'), 'vintage');
    $.get('<?=Url::toRoute('/analysis/admin/guide/year')?>').done(function (data) {
        var data = data.data;
        var name = [],value=[];
        for (var i in data){
            name.push(data[i].guide_name);
            value.push(parseFloat(data[i].total));
        }

        option = {
            title:{
                'text':'年度对比',
                'left':'right'
            },
            color: ['#3398aB'],
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    data : name,
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'销售金额',
                    type:'bar',
                    barWidth: '60%',
                    data:value
                }
            ]
        };







        myChart.setOption(option);

    })

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>
