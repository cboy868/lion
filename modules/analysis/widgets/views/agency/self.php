<?php
/**
 * Created by PhpStorm.
 * User: wansq
 * Date: 2017/5/15
 * Time: 14:43
 */
use app\core\helpers\Url;
app\assets\EchartsAsset::register($this);
$guides = \app\modules\user\models\User::getGuides();
$agencys = \app\modules\agency\models\Agency::sel(true);
?>

<div>
    <h4 style="text-align: right">
        导购选择
        <?=\yii\helpers\Html::dropDownList('agency',null,$agencys,['class'=>'selAgency'])?>
    </h4>
</div>
    <div id="self-month" style="height:400px;"></div>

<?php $this->beginBlock('per') ?>
$(function(){
    var agency = $('.selAgency').val();
    getSelf(agency);

    $('.selAgency').change(function (e) {
        e.preventDefault();
        var user = $(this).val();
        getSelf(user);
    });


function getSelf(agency){
    var myChart = echarts.init(document.getElementById('self-month'), 'vintage');
    $.get('<?=Url::toRoute(['/analysis/admin/agency/self'])?>?agency_id='+agency).done(function (data) {
        var data = data.data;
        var name = [],value=[];
        for (var i in data){
            name.push(data[i].month + '月');
            value.push(parseFloat(data[i].total));
        }
        option = {
            title:{
                'text':'办事处销售金额统计',
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
}

})



<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>
