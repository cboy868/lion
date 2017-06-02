<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

app\assets\EchartsAsset::register($this);

$this->title = '墓位销售统计';
$this->params['breadcrumbs'][] = ['label' => '统计', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        <h1>墓位整体销售统计</h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12 client-index">
	            <div id="main" style="width: 100%;height:400px;"></div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12 client-index">
	            <div id="main-num" style="width: 100%;height:400px;"></div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>
        <div class="row">
	        <div class="col-xs-12 client-index">
	        	<h3>统计分析</h3>

	        	<div>
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				  	<?php for($i=1; $i<=date('m'); $i++): ?>
				  		<li role="presentation" class="<?php if ($i==date('m')): ?> active <?php endif ?>"><a href="#t<?=$i?>" aria-controls="home" role="tab" data-toggle="tab"><?=$i?>月</a></li>
				  	<?php endfor; ?>
				    
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				  	<?php for($i=1; $i<=date('m'); $i++): ?>
				    <div role="tabpanel" class="tab-pane  <?php if($i==date('m')):?> active<?php endif;?>" id="t<?=$i?>">
				    	<textarea class="form-control" rows="15" name="t[<?=$i?>]" <?php if ($i<date('m')): ?> disabled<?php endif ?>></textarea>
				    </div>
				    <?php endfor; ?>
				  </div>
				</div>
	        </div>
        </div>
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('foo') ?>  
  $(function(){
        $.get('<?=Url::toRoute('tomb-sale')?>').done(function (data) {
        	var amountChart = echarts.init(document.getElementById('main'), 'vintage');
        	var numChart = echarts.init(document.getElementById('main-num'), 'vintage');

	  		var colors = ['#5793f3', '#d14a61', '#675bba'];
	        // 指定图表的配置项和数据

	        var amountdata =[], amountcate = [];
	        for (var i in data.data.amount) {
	        	amountdata.push(data.data.amount[i]);
	        	amountcate.push(data.data.amountcate[i]);
	        }

	        var numcate =[], numdata = [];
	        for (var i in data.data.num) {
	        	numdata.push(data.data.num[i]);
	        	numcate.push(data.data.numcate[i]);
	        }

	        var amountseries =[], numseries = [];
	        for (i in data.data.num) {
	        	amountseries.push({
		            name:data.data.amountcate[i],
		            type:'bar',
		            data:data.data.amount[i]
		        });
			    numseries.push({
		            name:data.data.numcate[i],
		            type:'bar',
		            data:data.data.num[i]
		        });
	        }

	        amountoption = {
			    color: colors,
			    tooltip: {
			        trigger: 'axis'
			    },
			    grid: {
			        right: '10%'
			    },
			    toolbox: {
			        feature: {
			            dataView: {show: true, readOnly: false},
			            restore: {show: true},
			            saveAsImage: {show: true}
			        }
			    },
			    legend: {
			        data:amountcate
			    },
			    xAxis: [
			        {
			            type: 'category',
			            axisTick: {
			                alignWithLabel: true
			            },
			            data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
			        }
			    ],
			    yAxis: [
			        {
			            type: 'value',
			            name: '销售额(万)',
			            min: 0,
			            position: 'left',
			            axisLine: {
			                lineStyle: {
			                    color: colors[0]
			                }
			            },
			            axisLabel: {
			                formatter: '{value} ￥'
			            }
			        }
			    ],
			    series: amountseries
			};

	        // 指定图表的配置项和数据
	        numoption = {
			    color: colors,

			    tooltip: {
			        trigger: 'axis'
			    },
			    grid: {
			        right: '10%'
			    },
			    toolbox: {
			        feature: {
			            dataView: {show: true, readOnly: false},
			            restore: {show: true},
			            saveAsImage: {show: true}
			        }
			    },
			    legend: {
			        data:numcate
			    },
			    xAxis: [
			        {
			            type: 'category',
			            axisTick: {
			                alignWithLabel: true
			            },
			            data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
			        }
			    ],
			    yAxis: [
			        {
			            type: 'value',
			            name: '销售量(个)',
			            min: 0,
			            position: 'left',
			            axisLine: {
			                lineStyle: {
			                    color: colors[0]
			                }
			            },
			            axisLabel: {
			                formatter: '{value} '
			            }
			        }
			    ],
			    series: numseries
			};

			amountChart.setOption(amountoption);
			numChart.setOption(numoption);
		});

  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  
