<?php
use app\core\helpers\Url;
app\assets\EchartsAsset::register($this);
?>
    <div id="main-goods-sale" style="width: 100%;height:400px;"></div>
<?php $this->beginBlock('foo') ?>
$(function(){
    $.get('<?=Url::toRoute('/analysis/admin/goods/sale')?>').done(function (data) {

        var month=[],total=[];

        for (i in data.data) {
            month.push(i+'月');
            total.push(data.data[i].total);
        }

        var sale_option = {
            color:['#5793f3'],
            title : {
                text: '年度商品销售金额走势',
                //subtext: '纯属虚构'
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['销售金额']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : month
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                        formatter: '{value} 万'
                    }
                }
            ],
            series : [
                {
                    name:'销售金额',
                    type:'line',
                    data:total,
                    markPoint : {
                        data : [
                            {type : 'max', name: '最大值'},
                            {type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name: '平均值'}
                        ]
                    }
                }
            ]
        };
        var saleChart = echarts.init(document.getElementById('main-goods-sale'),'vintage');
        saleChart.setOption(sale_option);
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>
