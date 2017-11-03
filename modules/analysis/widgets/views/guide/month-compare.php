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
<div>
    <h4 style="text-align: right">
        月份选择
        <?=\yii\helpers\Html::dropDownList('month',intval(date('m')),months(),['class'=>'selMonthCompare'])?>
    </h4>
</div>
    <div id="month-compare" style="height:400px;" class="col-md-12"></div>

<?php $this->beginBlock('per') ?>
$(function(){

    getMonthCompare(<?=date('m')?>);

    $('.selMonthCompare').change(function (e) {
        e.preventDefault();
        var month = $(this).val();
        getMonthCompare(month);
    });

    function getMonthCompare(month) {
        var myChart = echarts.init(document.getElementById('month-compare'), 'vintage');
        $.get('<?=Url::toRoute('/analysis/home/guide/month')?>?month='+month).done(function (data) {
            var data = data.data;
            var name = [],value=[];
            for (var i in data){
                name.push(data[i].guide_name);
                value.push(parseFloat(data[i].total));
            }

            option = {
                title: {
                    text: '月销售额对比',
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
