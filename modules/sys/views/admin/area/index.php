<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
\app\assets\Tabletree::register($this);

$this->title = '地区库管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <?php //echo Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                    <?=  Html::a('<i class="fa fa-plus"></i> 生成js地区库',
                        ['generate-js'], ['class' => 'btn btn-info btn-sm pull-right loading','data-loading-text'=>"地址库生成中, 请稍后..."]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="col-xs-12">
            <?php if(Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success" style="word-break: break-all;word-wrap: break-word;">
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
            <?php endif; ?>
        </div>


        <div class="row">
            <div class="col-xs-12 area-index">
                <?php $models = $dataProvider->getModels()?>
                <table class="table table-hover" id="treetable">
                    <thead>
                    <tr>
                        <th>地名</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($models as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td> <?=$v['name']?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <?php
                echo \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider->getPagination(),
                    'nextPageLabel' => '>',
                    'prevPageLabel' => '<',
                    'lastPageLabel' => '尾页',
                    'firstPageLabel' => '首页',
                    'options' => [
                        'class' => 'pull-right pagination'
                    ]
                ]);
                ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<?php $this->beginBlock('tree') ?>
$(function(){
    $('.loading').click(function(){
        $(this).button('loading');
    });

    $("body").on('click', '#treetable tr', function(){
        var tid = $(this).data('tt-id');
        var childSize = $("#treetable").find("[data-tt-parent-id='" + tid + "']").length;
        if (childSize > 0) {
            return;
        }

        var tr = $(this).clone(true);
        var span = tr.find('td span.indenter');


        var that = this;

        $.get('<?=Url::toRoute(["child"])?>',{id:tid}, function(xhr){

            if (!xhr.status){return;}
            var data = xhr.data;
            var html = '';

            for (i in data) {

                span.css('padding-left', data[i].level * 20);

                tr.attr('data-tt-id', data[i].id)
                    .attr('data-tt-parent-id', data[i].pid)
                    .find('td')
                    .html(span.prop("outerHTML") + data[i].name);

                html += tr.prop("outerHTML");
            }
            $(that).after(html);
        },'json');
    });

    $("#treetable tr").click(function(){
//        var html = '<tr data-tt-id=100 data-tt-parent-id=1 class="leaf expanded">'+
//        '<td><span class="indenter" style="padding-left: 29px;"></span>子</td>' +
//        '</tr>';
//
//        $(this).after(html);

    });

    $("#treetable").treetable({
        expandable: true,// 展示
        initialState :"expanded",//默认打开所有节点
        stringCollapse:'关闭',
        stringExpand:'展开',
        clickableNodeNames:true,

        onNodeExpand: function() {// 分支展开后的回调函数
console.dir(111);
            var node = this;        //判断当前节点是否已经拥有子节点
            var childSize = $("#treetable").find("[data-tt-parent-id='" + node.id + "']").length;
            if (childSize > 0) {
                return;
            }
            var data = "pageId=" + node.id;         // Render loader/spinner while loading 加载时渲染
            $.ajax({
                loading : false,
                sync: false,// Must be false, otherwise loadBranch happens after showChildren?
                url : context + "/document/loadChild.json",
                data: data,
                success:function(result) {
                    if(0 == result.code ){
                        if(!com.isNull(result.body)){
                            if(0 == eval(result.body['chilPages']).length){//不存在子节点
                                var $tr = $("#treetable").find("[data-tt-id='" + node.id + "']");
                                $tr.attr("data-tt-branch","false");// data-tt-branch 标记当前节点是否是分支节点，在树被初始化的时候生效
                                $tr.find("span.indenter").html("");// 移除展开图标
                                return;
                            }
                            var rows = this.getnereateHtml(result.body['chilPages']);
                            $("#treetable").treetable("loadBranch", node, rows);// 插入子节点
                            $("#treetable").treetable("expandNode", node.id);// 展开子节点
                        }
                    }else{
                        alert(result.tip);
                    }
                }
            });
        }
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['tree'], \yii\web\View::POS_END); ?>

