<?php
use app\core\helpers\Url;
app\assets\EchartsAsset::register($this);
?>
    <div id="goods-hot-num" style="width: 100%;height:400px;"></div>
<?php $this->beginBlock('foo') ?>
$(function(){
    $.get('<?=Url::toRoute('/analysis/admin/goods/hot-num')?>').done(function (data) {

        var goods=[],total=[];

        for (i in data.data) {
            goods.push(data.data[i].name);
            total.push(data.data[i].num);
        }

        var hot_option = {
            color:["#B6A2DE"],
            title : {
                text: '今年商品销售数量排行',
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['热销商品']
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
                    data : goods
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'商品销售数量',
                    type:'bar',
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

        var hotChart = echarts.init(document.getElementById('goods-hot-num'));
        hotChart.setOption(hot_option);


    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>
