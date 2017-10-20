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
        年度选择
        <?=\yii\helpers\Html::dropDownList('month',intval(date('Y')),years(6),['class'=>'selPercentYear'])?>
    </h4>
</div>
<div class="row">
    <div id="year-persent" style="height:400px;" class="col-md-12"></div>
</div>

<?php $this->beginBlock('per') ?>
$(function(){

    var year = $('.selPercentYear').val();
    getYearPercent(year);

    $('.selPercentYear').change(function (e) {
        e.preventDefault();
        var year = $(this).val();
        getYearPercent(year);
    });



function getYearPercent(year) {
    var myChart = echarts.init(document.getElementById('year-persent'), 'vintage');
    $.get('<?=Url::toRoute('/analysis/admin/guide/year')?>?year='+year).done(function (data) {
        var data = data.data;
        var result = [];
        for (var i in data){
            result.push({
                name:data[i].guide_name,
                value:parseFloat(data[i].total)
            });
        }
        myChart.setOption({
            title:{
                'text':'年度占比',
                'left':'right'
            },
            roseType : 'radius',
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            series : [
                {
                    name: '年销售占比',
                    type: 'pie',
                    radius: '55%',
                    data:result
                }
            ]
        })

    })
}




})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>
