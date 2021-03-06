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
        <?=\yii\helpers\Html::dropDownList('month',intval(date('m')),months(),['class'=>'selMonthPercent'])?>
    </h4>
</div>
    <div id="month-persent" style="height:400px;" class="col-md-12"></div>

<?php $this->beginBlock('per') ?>
$(function(){

    getMonthPersent(<?=date('m')?>);

    $('.selMonthPercent').change(function (e) {
        e.preventDefault();
        var month = $(this).val();
        getMonthPersent(month);
    });


    
    function getMonthPersent(month) {
        var myChart = echarts.init(document.getElementById('month-persent'), 'vintage');
        $.get('<?=Url::toRoute('/analysis/home/guide/month')?>?month='+month).done(function (data) {
            var data = data.data;
            var result = [];
            for (var i in data){
                result.push({
                    name:data[i].guide_name,
                    value:parseFloat(data[i].total)
                });
            }
            myChart.setOption({
                title: {
                    text: '月销售额占比',
                    left:'right'
                },
                roseType : 'radius',
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
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
