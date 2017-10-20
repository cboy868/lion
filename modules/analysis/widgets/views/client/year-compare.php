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
<div class="row">
    <div id="client-year-compare" style="height:400px;" class="col-md-12"></div>
</div>

<?php $this->beginBlock('per') ?>
$(function(){
    var myChart = echarts.init(document.getElementById('client-year-compare'), 'vintage');
    $.get('<?=Url::toRoute('/analysis/admin/client/year')?>').done(function (data) {
        var data = data.data;
        var name = [],person_value=[],recep_value=[];
        for (var i in data){
            name.push(data[i].guide_name);
            person_value.push(parseFloat(data[i].person_total));
            recep_value.push(parseFloat(data[i].recept_total));
        }

        var option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    crossStyle: {
                        color: '#999'
                    }
                }
            },
            toolbox: {
                feature: {
                    dataView: {show: true, readOnly: false},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            legend: {
                data:['客户数','接待总量']
            },
            xAxis: [
                {
                    type: 'category',
                    data: name,
                    axisPointer: {
                        type: 'shadow'
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    name: '客户数',
                    axisLabel: {
                        formatter: '{value} 人'
                    }
                },
                {
                    type: 'value',
                    name: '接待总数',
                    axisLabel: {
                        formatter: '{value} 人次'
                    }
                }
            ],
            series: [
                {
                    name:'客户数',
                    type:'bar',
                    data:person_value
                },
                {
                    name:'接待总量',
                    type:'bar',
                    data:recep_value
                }
            ]
        };

        myChart.setOption(option);

    })

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>
