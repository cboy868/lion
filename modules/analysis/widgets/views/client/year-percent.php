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

    <div id="client-year-person-persent" class="col-md-6" style="height:400px;"></div>
    <div id="client-year-recept-persent" class="col-md-6" style="height:400px;"></div>
</div>

<?php $this->beginBlock('per') ?>
$(function(){
    var personChart = echarts.init(document.getElementById('client-year-person-persent'), 'vintage');
    var receptChart = echarts.init(document.getElementById('client-year-recept-persent'), 'vintage');
    $.get('<?=Url::toRoute('/analysis/admin/client/year')?>').done(function (data) {
        var data = data.data;
        var person_result = [],recept_result=[];
        var preson_total=0,recept_total=0;
        for (var i in data){
            person_result.push({
                name:data[i].guide_name,
                value:parseFloat(data[i].person_total)
            });
            recept_result.push({
                name:data[i].guide_name,
                value:parseFloat(data[i].recept_total)
            });
            preson_total += parseInt(data[i].person_total);
            recept_total += parseInt(data[i].recept_total);
        }
        personChart.setOption({
            title:{
                'text':'年接待客户量占比,共 ' + preson_total +'人',
                'left':'right'
            },
            roseType : 'radius',
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            series : [
                {
                    name: '客户量',
                    type: 'pie',
                    radius: '55%',
                    data:person_result
                }
            ]
        })

        receptChart.setOption({
            title:{
                'text':'年接待量占比,共 ' + recept_total +'次',
                'left':'right'
            },
            roseType : 'radius',
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            series : [
                {
                    name: '客户量',
                    type: 'pie',
                    radius: '55%',
                    data:recept_result
                }
            ]
        })

    })

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['per'], \yii\web\View::POS_END); ?>
