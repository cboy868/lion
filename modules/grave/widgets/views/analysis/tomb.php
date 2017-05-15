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

<div class="widget-box transparent ui-sortable-handle" style="opacity: 1;">
    <div class="widget-header">
        <h4 class="widget-title lighter"><i class="fa fa-bar-chart"></i> 墓位销售量及销售金额</h4>
    </div>
    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">
            <h3>销售金额</h3>
            <div class="row">
                <div class="col-xs-12 client-index">
                    <div id="main" style="width: 100%;height:400px;"></div>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            </div>
            <hr>
            <h3>销售量</h3>
            <div class="row">
                <div class="col-xs-12 client-index">
                    <div id="main-num" style="width: 100%;height:400px;"></div>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
    </div>
</div>
<?php $this->beginBlock('foo') ?>  
  $(function(){
        $.get('<?=Url::toRoute('/analysis/admin/default/tomb-sale')?>').done(function (data) {
            var amountChart = echarts.init(document.getElementById('main'), 'vintage');
            var numChart = echarts.init(document.getElementById('main-num'), 'vintage');

            var colors = ['#5793f3', '#d14a61', '#675bba'];
            // 指定图表的配置项和数据

            var amountdata =[], amountcate = [];
            for (var i in data.data.amount) {
                amountdata.push(data.data.amount[i]);
                amountcate.push(data.data.amountcate[i]);
            }

            var numcate =[], numdata = [];
            for (var i in data.data.num) {
                numdata.push(data.data.num[i]);
                numcate.push(data.data.numcate[i]);
            }

            var amountseries =[], numseries = [];
            for (i in data.data.num) {
                amountseries.push({
                    name:data.data.amountcate[i],
                    type:'bar',
                    data:data.data.amount[i]
                });
                numseries.push({
                    name:data.data.numcate[i],
                    type:'bar',
                    data:data.data.num[i]
                });
            }

            amountoption = {
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

            amountChart.setOption(amountoption);
            numChart.setOption(numoption);
        });

  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  
