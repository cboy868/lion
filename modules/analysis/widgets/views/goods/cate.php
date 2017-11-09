<?php
use app\core\helpers\Url;
app\assets\EchartsAsset::register($this);
?>
<div id="goods-cate" style="width: 100%;height:400px;"></div>
<?php $this->beginBlock('foo') ?>
$(function(){
    $.get('<?=Url::toRoute('/analysis/admin/goods/cate')?>').done(function (data) {

        var cate=[],total=[];

        for (i in data.data) {
            cate.push(data.data[i].cname);
            total.push(data.data[i].total);
        }
        cate_option = {
            color:["#1790CF"],
            title : {
                text: '今年各商品分类销量',
            },
            tooltip : {
                trigger: 'axis'
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType: {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'value',
                    boundaryGap : [0, 0.01]
                }
            ],
            yAxis : [
                {
                    type : 'category',
                    data : cate
                }
            ],
            series : [
                {
                    name:'销量',
                    type:'bar',
                    data:total
                }
            ]
        };

        var cateChart = echarts.init(document.getElementById('goods-cate'));
        cateChart.setOption(cate_option);
    })
})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>
