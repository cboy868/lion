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
    <div id="main-amount" style="width: 100%;height:400px;" class="col-md-12"></div>
<?php $this->beginBlock('foo') ?>
    $(function(){
        $.get('<?=Url::toRoute('/analysis/admin/tomb/sale-amount')?>').done(function (data) {
            var amountChart = echarts.init(document.getElementById('main-amount'), 'vintage');

            var colors = ['#5793f3', '#d14a61', '#675bba'];
            // 指定图表的配置项和数据

            var amountdata =[], amountcate = [];
            for (var i in data.data.amount) {
                amountdata.push(data.data.amount[i]);
                amountcate.push(data.data.amountcate[i]);
            }

            var amountseries =[];
            for (i in data.data.amount) {
                amountseries.push({
                    name:data.data.amountcate[i],
                    type:'bar',
                    data:data.data.amount[i]
                });
            }

            amountoption = {
                color: colors,
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '5%',
                    right: '10%',
                    bottom: '10%',
                    containLabel: true
                },
                toolbox: {
                    feature: {
                        dataView: {show: true, readOnly: false},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                legend: {
                    data:amountcate
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
                        name: '销售额(万)',
                        min: 0,
                        position: 'left',
                        axisLine: {
                            lineStyle: {
                                color: colors[0]
                            }
                        },
                        axisLabel: {
                            formatter: '{value} ￥'
                        }
                    }
                ],
                series: amountseries
            };

            amountChart.setOption(amountoption);
        });

    })
    <?php $this->endBlock() ?>
    <?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>
