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
<div id="main-num" style="width: 100%;height:400px;"></div>
<?php $this->beginBlock('foo') ?>
    $(function(){
        $.get('<?=Url::toRoute('/analysis/admin/tomb/sale-num')?>').done(function (data) {
            var numChart = echarts.init(document.getElementById('main-num'), 'vintage');

            var colors = ['#5793f3', '#d14a61', '#675bba'];
            // 指定图表的配置项和数据

            var numcate =[], numdata = [];
            for (var i in data.data.num) {
                numdata.push(data.data.num[i]);
                numcate.push(data.data.numcate[i]);
            }

            var numseries = [];
            for (i in data.data.num) {
                numseries.push({
                    name:data.data.numcate[i],
                    type:'bar',
                    data:data.data.num[i]
                });
            }
            // 指定图表的配置项和数据
            numoption = {
                color: colors,

                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    right: '10%'
                },
                toolbox: {
                    feature: {
                        dataView: {show: true, readOnly: false},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {
                    data:numcate
                },
                xAxis: [
                    {
                        type: 'category',
                        axisTick: {
                            alignWithLabel: true
                        },
                        data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name: '销售量(个)',
                        min: 0,
                        position: 'left',
                        axisLine: {
                            lineStyle: {
                                color: colors[0]
                            }
                        },
                        axisLabel: {
                            formatter: '{value} '
                        }
                    }
                ],
                series: numseries
            };

            numChart.setOption(numoption);
        });

    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>
