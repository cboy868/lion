<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

use app\assets\FootableAsset;
use app\modules\shop\models\Category;


$this->title = '商城主页面';
$this->params['breadcrumbs'][] = $this->title;
\app\assets\EchartsAsset::register($this);

?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>

                <small>
                    <?php if (Yii::$app->user->can('shop/bag/index')):?>
                        <div class="pull-left nc">
                            <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/bag/index'])?>">
                                <i class="fa fa-shopping-bag fa-2x"></i>  打包品管理</a>
                        </div>
                    <?php endif;?>
                    <?php if (Yii::$app->user->can('shop/category/index')):?>
                        <div class="pull-left nc">
                            <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/category/index'])?>">
                                <i class="fa fa-sitemap fa-2x"></i>  商品分类管理</a>
                        </div>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-md-12">
                <div id="goods-sale" style="height:400px"></div>
            </div>
            <div class="col-md-7">
                <div id="hot-goods" style="height:400px"></div>
            </div>
            <div class="col-md-5">
                <div id="category-goods" style="height:400px"></div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('foo') ?>
    $(function () {
        var sale_option = {
            title : {
                text: '年度商品销售金额走势',
                //subtext: '纯属虚构'
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['销售金额']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : ['周一','周二','周三','周四','周五','周六','周日']
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                        formatter: '{value} 万'
                    }
                }
            ],
            series : [
                {
                    name:'销售金额',
                    type:'line',
                    data:[11, 11, 15, 13, 12, 13, 10],
                    markPoint : {
                        data : [
                            {type : 'max', name: '最大值'},
                            {type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name: '平均值'}
                        ]
                    }
                }
            ]
        };
        var saleChart = echarts.init(document.getElementById('goods-sale'));
        saleChart.setOption(sale_option);



        var hot_option = {
            title : {
                text: '商品销售排行',
                subtext: '纯属虚构'
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['热销商品']
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    data : ['鲜花一','碑型大白石','十二生肖','瓷像一','墓碑装饰','纸','烛','绢花带刺玫瑰','礼炮一','鲜花四五']
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'热销商品',
                    type:'bar',
                    data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0],
                    markPoint : {
                        data : [
                            {type : 'max', name: '最大值'},
                            {type : 'min', name: '最小值'}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name: '平均值'}
                        ]
                    }
                }

            ]
        };

        var hotChart = echarts.init(document.getElementById('hot-goods'));
        hotChart.setOption(hot_option);





    cate_option = {
        title : {
            text: '商品销售分类占比',
            subtext: '纯属虚构',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            x : 'center',
            y : 'bottom',
            data:['rose1','rose2','rose3','rose4','rose5','rose6','rose7','rose8']
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {
                    show: true,
                    type: ['pie', 'funnel']
                },
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        series : [
            {
                name:'面积模式',
                type:'pie',
                radius : [30, 110],
                center : ['50%', 200],
                roseType : 'area',
                x: '50%',               // for funnel
                max: 40,                // for funnel
                sort : 'ascending',     // for funnel
                data:[
                    {value:10, name:'rose1'},
                    {value:5, name:'rose2'},
                    {value:15, name:'rose3'},
                    {value:25, name:'rose4'},
                    {value:20, name:'rose5'},
                    {value:35, name:'rose6'},
                    {value:30, name:'rose7'},
                    {value:40, name:'rose8'}
                ]
            }
        ]
    };
    var cateChart = echarts.init(document.getElementById('category-goods'));
    cateChart.setOption(cate_option);

    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>

