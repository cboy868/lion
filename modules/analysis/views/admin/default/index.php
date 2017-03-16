<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

app\assets\EchartsAsset::register($this);

?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        <h1>数据统计，可在这里加个统计的说明, 一些常用图例</h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-6 client-index">
	            <div id="main" style="width: 100%;height:400px;"></div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-xs-6 client-index">
				<div id="main2" style="width: 100%;height:400px;"></div>

            </div>
            <div class="col-xs-6 client-index">
	            <div id="main3" style="width: 100%;height:400px;"></div>

            </div>
            <div class="col-xs-6 client-index">
	            <div id="main4" style="width: 100%;height:400px;"></div>

            </div>

            <div class="col-xs-6 client-index">
	            <div id="main5" style="width: 100%;height:400px;"></div>

            </div>

            <div class="col-xs-6 client-index">
	            <canvas id="main6" style="width: 100%;height:400px;"></canvas>
            </div>






        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('foo') ?>  
  $(function(){

  		var myChart = echarts.init(document.getElementById('main'), 'vintage');
  		var colors = ['#5793f3', '#d14a61', '#675bba'];
        // 指定图表的配置项和数据
        option = {
		    color: colors,

		    tooltip: {
		        trigger: 'axis'
		    },
		    grid: {
		        right: '20%'
		    },
		    toolbox: {
		        feature: {
		            dataView: {show: true, readOnly: false},
		            restore: {show: true},
		            saveAsImage: {show: true}
		        }
		    },
		    legend: {
		        data:['蒸发量','降水量','平均温度']
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
		            name: '蒸发量',
		            min: 0,
		            max: 250,
		            position: 'right',
		            axisLine: {
		                lineStyle: {
		                    color: colors[0]
		                }
		            },
		            axisLabel: {
		                formatter: '{value} ml'
		            }
		        },
		        {
		            type: 'value',
		            name: '降水量',
		            min: 0,
		            max: 250,
		            position: 'right',
		            offset: 80,
		            axisLine: {
		                lineStyle: {
		                    color: colors[1]
		                }
		            },
		            axisLabel: {
		                formatter: '{value} ml'
		            }
		        },
		        {
		            type: 'value',
		            name: '温度',
		            min: 0,
		            max: 25,
		            position: 'left',
		            axisLine: {
		                lineStyle: {
		                    color: colors[2]
		                }
		            },
		            axisLabel: {
		                formatter: '{value} °C'
		            }
		        }
		    ],
		    series: [
		        {
		            name:'蒸发量',
		            type:'bar',
		            data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
		        },
		        {
		            name:'降水量',
		            type:'bar',
		            yAxisIndex: 1,
		            data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
		        },
		        {
		            name:'平均温度',
		            type:'line',
		            yAxisIndex: 2,
		            data:[2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
		        }
		    ]
		};

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);

        



        var m2 = echarts.init(document.getElementById('main2'), 'vintage');
        m2.setOption({
        	roseType: 'angle',
		    series : [
		        {
		            name: '访问来源',
		            type: 'pie',
		            radius: '55%',
		            data:[
		                {value:400, name:'搜索引擎'},
		                {value:335, name:'直接访问'},
		                {value:310, name:'邮件营销'},
		                {value:274, name:'联盟广告'},
		                {value:235, name:'视频广告'}
		            ]
		        }
		    ],
		    itemStyle: {
			    normal: {
			        // 阴影的大小
			        shadowBlur: 200,
			        // 阴影水平方向上的偏移
			        shadowOffsetX: 0,
			        // 阴影垂直方向上的偏移
			        shadowOffsetY: 0,
			        // 阴影颜色
			        shadowColor: 'rgba(0, 0, 0, 0.5)'
			    },
			    emphasis: {
			        shadowBlur: 200,
			        shadowColor: 'rgba(0, 0, 0, 0.5)'
			    }
			}
		})


		var m3 = echarts.init(document.getElementById('main3'));

		$.get('<?=Url::toRoute('test-json')?>').done(function (data) {
		    m3.setOption({
		        title: {
		            text: '异步数据加载示例'
		        },
		        tooltip: {},
		        legend: {
		            data:['销量']
		        },
		        xAxis: {
		            data: data.data.cate
		        },
		        yAxis: {},
		        series: [{
		            name: '销量',
		            type: 'bar',
		            data: data.data.data
		        }]
		    });
		});


		var m4 = echarts.init(document.getElementById('main4'));	
		option = {
		    xAxis: {
		        type: 'value'
		    },
		    yAxis: {
		        type: 'value'
		    },
		    dataZoom: [

		        {
		            type: 'slider',
		            xAxisIndex: 0,
		            start: 10,
		            end: 60
		        },
		        {
		            type: 'inside',
		            xAxisIndex: 0,
		            start: 10,
		            end: 60
		        },
		        {
		            type: 'slider',
		            yAxisIndex: 0,
		            start: 30,
		            end: 80
		        },
		        {
		            type: 'inside',
		            yAxisIndex: 0,
		            start: 30,
		            end: 80
		        }
		    ],
		    series: [
		        {
		            type: 'scatter', // 这是个『散点图』
		            itemStyle: {
		                normal: {
		                    opacity: 0.8
		                }
		            },
		            symbolSize: function (val) {
		                return val[2] * 40;
		            },
		            data: [["14.616","7.241","0.896"],["3.958","5.701","0.955"],["2.768","8.971","0.669"],["9.051","9.710","0.171"],["14.046","4.182","0.536"],["12.295","1.429","0.962"],["4.417","8.167","0.113"],["0.492","4.771","0.785"],["7.632","2.605","0.645"],["14.242","5.042","0.368"]]
		        }
		    ]
		}

		m4.setOption(option);



		// 基于准备好的dom，初始化ECharts实例
		var m5 = echarts.init(document.getElementById('main5'));

		// 指定图表的配置项和数据
		var option = {
		    xAxis: {
		        data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
		    },
		    yAxis: {},
		    series: [{
		        name: '销量',
		        type: 'bar',
		        data: [5, 20, 36, 10, 10, 20]
		    }]
		};
		// 使用刚指定的配置项和数据显示图表。
		m5.setOption(option);
		// 处理点击事件并且跳转到相应的百度搜索页面
		m5.on('click', function (params) {
		    window.open('https://www.baidu.com/s?wd=' + encodeURIComponent(params.name));
		});


		// 基于准备好的dom，初始化ECharts实例
		var m6 = echarts.init(document.getElementById('main6'));

		// 指定图表的配置项和数据
		var option = {
		    xAxis: {
		        data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
		    },
		    yAxis: {},
		    series: [{
		        name: '销量',
		        type: 'bar',
		        data: [5, 20, 36, 10, 10, 20]
		    }]
		};
		// 使用刚指定的配置项和数据显示图表。
		m6.setOption(option);
		// 处理点击事件并且跳转到相应的百度搜索页面
		m6.on('click', function (params) {
		    window.open('https://www.baidu.com/s?wd=' + encodeURIComponent(params.name));
		});



  })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  
