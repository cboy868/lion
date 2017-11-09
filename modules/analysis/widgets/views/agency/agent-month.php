<?php
use app\core\helpers\Url;
app\assets\EchartsAsset::register($this);

?>
<div>
    <h4 style="text-align: right">
        月份选择
        <?=\yii\helpers\Html::dropDownList(
                'month',
                null,
            [0=>'全年'] + months(),
                ['class'=>'selMonthCompare'])?>
    </h4>
</div>
    <div id="agent-month-compare" style="height:400px;"></div>

<?php $this->beginBlock('per') ?>
$(function(){

    var month = $('.selMonthCompare').val();
    getMonthCompare(month);

    $('.selMonthCompare').change(function (e) {
        e.preventDefault();
        var month = $(this).val();
        getMonthCompare(month);
    });

    function getMonthCompare(month) {
        var myChart = echarts.init(document.getElementById('agent-month-compare'), 'vintage');
        $.get('<?=Url::toRoute('/analysis/admin/agency/agent-month')?>?month='+month).done(function (data) {
            var data = data.data;
            var name = [],value=[];
            for (var i in data){
                name.push(data[i].agent_name);
                value.push(parseFloat(data[i].total));
            }

            option = {
                title: {
                    text: '业务员墓位销售额对比',
                    left: 'right'
                },
                color: ['#3398aB'],
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                grid: {
                    left: '5%',
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
    }

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>
