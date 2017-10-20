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

?>

<div>
    <h4 style="text-align: right">
        导购选择
        <?=\yii\helpers\Html::dropDownList('guide',null,$guides,['class'=>'selGuide'])?>
    </h4>
</div>
    <div id="self-month" style="height:400px;" class="col-md-12"></div>

<?php $this->beginBlock('per') ?>
$(function(){
    var user = $('.selGuide').val();
    getSelf(user);

    $('.selGuide').change(function (e) {
        e.preventDefault();
        var user = $(this).val();
        getSelf(user);
    });


function getSelf(user){
    var myChart = echarts.init(document.getElementById('self-month'), 'vintage');
    $.get('<?=Url::toRoute(['/analysis/admin/guide/self-month'])?>?guide_id='+user).done(function (data) {
        var data = data.data;
        var name = [],value=[];
        for (var i in data){
            name.push(data[i].month + '月');
            value.push(parseFloat(data[i].total));
        }
        option = {
            title:{
                'text':'个人销售金额统计',
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
