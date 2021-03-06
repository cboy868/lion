<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\Grave\models\Tomb;
use app\core\widgets\DetailView;
use yii\helpers\ArrayHelper;

\app\assets\Treeview::register($this);
$this->title = '墓区管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css">
    ul, ol, li{
        list-style: none;
    }
    .graveimg img{
        width:100px;
        height:100px;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <a href="<?=Url::toRoute(['/grave/admin/default/index'])?>">墓区墓位</a>
                <small>

                    <?php if (Yii::$app->user->can('grave/default/create')):?>
                        <div class="pull-right nc">
                            <?=  Html::a('<i class="fa fa-plus fa-2x"></i> 添加新墓区', ['create'],
                                ['class' => 'btn btn-success btn-sm']) ?>
                        </div>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <?php $id = Yii::$app->request->get('id');?>


                <div class="left-side">
                    <div class="panel panel-sm">
                        <div class="panel-body" style="padding: 10px;">
                            <?=$c_menu?>
                        </div>
                    </div>
                </div>


            <div class="main grave-index">
                <?php if (isset($model) && $model):?>
                <div class="rows">
                    <div class="col-xs-12">
                        <?php if(Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success" style="word-break: break-all;word-wrap: break-word;">
                                <?php echo Yii::$app->session->getFlash('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger" style="word-break: break-all;word-wrap: break-word;">
                                <?php echo Yii::$app->session->getFlash('error'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <table id="w1" class="table table-striped table-bordered detail-view">
                            <tbody>
                            <tr><th width="100">墓区名</th><td><?=$model->name?></td>
                                <td rowspan="6" width="300"><img src="<?=$model->getThumbImg('300x200')?>"></td>
                            </tr>
                            <tr><th>总面积</th><td><?=$model->area_totle;?></td></tr>
                            <tr><th>使用面积</th><td><?=$model->area_use;?></td></tr>
                            <tr><th>墓基价</th><td><?=$model->price;?></td></tr>
                            <tr><th>添加时间</th><td><?=date('Y-m-d H:i',$model->created_at);?></td></tr>
                            <tr><th>子墓区</th>
                                <td>
                                    <?php
                                    $son = $model->getDirectSon(true);
                                    if ($son):
                                        foreach ($son as $v):
                                    ?>
                                        <a href="<?=Url::toRoute(['/grave/admin/default/index', 'id'=>$v['id']])?>"><?=$v['name']?></a> /
                                    <?php endforeach;endif;?>
                                </td>
                            </tr>

                            <tr><th>操作</th><td colspan="2">
                                    <div style="float: right;">
                                        <?php if (Yii::$app->user->can('grave/default/update')):?>
                                    <a href="<?=Url::toRoute(['update', 'id'=>$model->id])?>" class="btn btn-default"><i class="fa fa-edit"></i> 编辑</a>
                                        <?php endif;?>
                                    <?php if ($model->is_leaf): ?>
                                        <?php if (Yii::$app->user->can('grave/default/recommend')):?>
                                        <a href="<?=Url::toRoute(['recommend', 'id'=>$model->id])?>" class="recommend btn btn-default" style="color:green;">
                                            <?php if ($model->recommend):?>
                                                取消推荐
                                            <?php else:?>
                                                推荐
                                            <?php endif;?>
                                        </a>
                                        <?php endif;?>
                                        <?php if (Yii::$app->user->can('grave/tomb/create')):?>
                                        <a href="<?=Url::toRoute(['admin/tomb/create', 'grave_id'=>$model->id])?>" class="btn btn-default"><i class="fa fa-plus"></i> 添加墓位</a>
                                        &nbsp;<?php endif;?>
                                        <?php if (Yii::$app->user->can('grave/default/delete')):?>
                                        <a href="<?=Url::toRoute(['delete', 'id'=>$model->id])?>"
                                           class="btn btn-default"
                                           style="color:red;" data-confirm="您确定要删除此项吗？"
                                           data-method="post" data-pjax="0"><i class="fa fa-trash"></i> 删除
                                        </a>
                                        <?php endif;?>
                                        <?php if (Yii::$app->user->can('grave/tomb/index')):?>
                                        <a href="<?=Url::toRoute(['/grave/admin/tomb/index', 'grave_id'=>$model->id])?>" class="btn btn-success" target="_blank"> 进入墓位列表</a>
                                        <?php endif;?>
                                    <?php endif ?>
                                    </div>
                                </td>
                            </tr>
                            <tr><th>介绍</th><td colspan="2"><?=$model->intro;?></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <?=\app\modules\analysis\widgets\Analysis::widget([
                            'name'=>'graveStatus',
                            'options'=>['grave_id'=>$model->id]])?>
                    </div>
                </div>
                <?php else:?>
                    <div class="rows">
                        <style>
                            .note p{
                                font-size: 20px;
                                color:#666;
                            }
                            .note strong{
                                color:green;
                                font-size:25px;
                            }
                        </style>
                        <div class="col-md-7 note">
                            <h2>园区概览</h2>
                            <hr>
                            <p>本园区共有大区 <strong><?=$large_cnt?></strong> 处，直接墓区 <strong><?=$small_cnt?></strong> 处,
                                墓位总计 <strong><?=$tomb_cnt?> </strong> 座,销售情况如右图
                            </p>
                            <p>更多详细情况，请点击左侧墓区列表</p>
                        </div>
                        <div class="col-md-5">
                            <?=\app\modules\analysis\widgets\Analysis::widget([
                                'name'=>'graveStatus'
                            ])?>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <caption>所有墓区销售情况统计</caption>
                                <tr>
                                    <th>墓区</th>
                                    <th>闲置</th>
                                    <th>预定</th>
                                    <th>订金</th>
                                    <th>全款</th>
                                    <th>部分安葬</th>
                                    <th>全部安葬</th>
                                    <th>独葬</th>
                                    <th>保留</th>
                                </tr>

                                <?php foreach ($cates as $cate):?>
                                    <tr>
                                        <td>
                                            <a href="<?=Url::toRoute(['/grave/admin/default/index', 'id'=>$cate['id']])?>">
                                                <?=$cate['name']?>(总:<?=array_sum($total[$cate['id']])?>)
                                            </a>
                                        </td>
                                        <td><?=$total[$cate['id']][Tomb::STATUS_EMPTY]?></td>
                                        <td><?=$total[$cate['id']][Tomb::STATUS_PRE]?></td>
                                        <td><?=$total[$cate['id']][Tomb::STATUS_DEPOSIT]?></td>
                                        <td><?=$total[$cate['id']][Tomb::STATUS_PAYOK]?></td>
                                        <td><?=$total[$cate['id']][Tomb::STATUS_PART]?></td>
                                        <td><?=$total[$cate['id']][Tomb::STATUS_ALL]?></td>
                                        <td><?=$total[$cate['id']][Tomb::STATUS_SINGLE]?></td>
                                        <td><?=$total[$cate['id']][Tomb::STATUS_RETAIN]?></td>
                                    </tr>
                                    <?php if (isset($cate['child'])):?>
                                        <?php foreach ($cate['child'] as $child):?>
                                            <tr>
                                                <td>&nbsp;--

                                                    <a href="<?=Url::toRoute(['/grave/admin/default/index', 'id'=>$child['id']])?>">
                                                        <?=$child['name']?>(总:<?=array_sum($total[$child['id']])?>)
                                                    </a>
                                                </td>
                                                <td><?=$total[$child['id']][Tomb::STATUS_EMPTY]?></td>
                                                <td><?=$total[$child['id']][Tomb::STATUS_PRE]?></td>
                                                <td><?=$total[$child['id']][Tomb::STATUS_DEPOSIT]?></td>
                                                <td><?=$total[$child['id']][Tomb::STATUS_PAYOK]?></td>
                                                <td><?=$total[$child['id']][Tomb::STATUS_PART]?></td>
                                                <td><?=$total[$child['id']][Tomb::STATUS_ALL]?></td>
                                                <td><?=$total[$child['id']][Tomb::STATUS_SINGLE]?></td>
                                                <td><?=$total[$child['id']][Tomb::STATUS_RETAIN]?></td>
                                            </tr>
                                            <?php if (isset($child['child'])):?>
                                                <?php foreach ($child['child'] as $v):?>
                                                    <tr>
                                                        <td>&nbsp;-- &nbsp; --
                                                            <a href="<?=Url::toRoute(['/grave/admin/default/index', 'id'=>$v['id']])?>">
                                                                <?=$v['name']?>(总:<?=array_sum($total[$v['id']])?>)
                                                            </a>
                                                        </td>
                                                        <td><?=$total[$v['id']][Tomb::STATUS_EMPTY]?></td>
                                                        <td><?=$total[$v['id']][Tomb::STATUS_PRE]?></td>
                                                        <td><?=$total[$v['id']][Tomb::STATUS_DEPOSIT]?></td>
                                                        <td><?=$total[$v['id']][Tomb::STATUS_PAYOK]?></td>
                                                        <td><?=$total[$v['id']][Tomb::STATUS_PART]?></td>
                                                        <td><?=$total[$v['id']][Tomb::STATUS_ALL]?></td>
                                                        <td><?=$total[$v['id']][Tomb::STATUS_SINGLE]?></td>
                                                        <td><?=$total[$v['id']][Tomb::STATUS_RETAIN]?></td>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                    <?php endif;?>

                                <?php endforeach;?>
                            </table>
                        </div>
                    </div>
                <?php endif;?>

                <div class="hr hr-18 dotted hr-double"></div>
                <?php if (isset($tombs) && $tombs):?>
                    <?php
                    Modal::begin([
                        'header' => '业务操作',
                        'id' => 'modalAdd',
                        'size' => Modal::SIZE_LARGE,
                        'footer' => '<button class="btn btn-info" data-dismiss="modal">取消</button>',
                    ]) ;

                    echo '<div id="modalContent"></div>';

                    Modal::end();
                    ?>
                <div class="col-md-12">

                    <h2>本区墓位 <small>(<?=count($tombs)?>座墓) 点击图标可直接办理业务</small></h2>

                    <?php
                    $result = ArrayHelper::index($tombs, 'id', 'row');
                    ?>
                    <div class="search">
                        <label>排
                        <input type="text" class="tomb_row tsearch" placeholder="排">
                        </label>
                        <label>列
                        <input type="text" class="tomb_col tsearch" placeholder="列">
                        </label>
                        <button>查找</button>
                    </div>
                    <table class="table table-hover">
                        <?php foreach ($result as $k=>$models):?>
                            <tr>
                                <td>
                                    <div class="pull-left"><?=$k?>排</div>
                                    <ul>
                                        <?php $col=$minCol;foreach ($models as $model): ?>
                                            <?php
                                            if ($col < $model->col):
                                                for(; $col< $model->col; $col++):
                                                    if($col==0)continue;
                                                    ?>
                                                    <li><div>&nbsp;</div></li>
                                                    <?php
                                                endfor;
                                            endif;
                                            $col++;
                                            ?>
                                            <li class="item_<?=$model->row.'_'.$model->col?>">
                                                <div>
                                                    <a href="<?=Url::toRoute(['/grave/admin/tomb/option', 'id'=>$model->id])?>" class="modalAddButton" data-loading-text="等待..." onclick="return false">
                                                        <img src="/static/images/grave/<?=$model->status?>.jpg" width="36" height="36" title="<?=$model->tomb_no?>">
                                                    </a>
                                                    <span><?=$model->col?>号</span>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
                <?php endif;?>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

<style type="text/css">
    .table ul {
        margin-top: 5px;
        margin-right: 10px;
        margin-bottom: 5px;
        margin-left: 40px;
        list-style-image: none;
        list-style-type: none;
        white-space: nowrap;
        padding: 0px;
    }
    .table ul li {
        margin: 0px;
        padding: 0px;
        display: block;
        width: 40px;
        height:48px;
        float: left;
        padding:2px;
    }
    .table ul li span {
        padding: 0px;
        display: block;
        height: 14px;
        width: 40px;
        margin-top: 0px;
        margin-right: auto;
        margin-bottom: 0px;
        margin-left: auto;
        line-height: 14px;
        text-align: center;
        color: #000000;
        font-size: 12px;
    }
    .table ul li img {
        display: block;
        height: 34px;
        width: 34px;
        margin-top: 0px;
        margin-right: auto;
        margin-bottom: 0px;
        margin-left: auto;
        border: 1px solid #FFF;
    }
    .search label{
        /*width:40px;*/
        margin-left:10px;
        /*text-align: right;*/
    }
    .table ul li.on{
        background: green;
        padding:10px;
        width: 60px;
        height: 68px;
    }
    @-webkit-keyframes twinkling{    /*透明度由0到1*/
        0%{
            opacity:0; /*透明度为0*/
        }
        100%{
            opacity:1; /*透明度为1*/
        }
    }
    .table > tbody > tr > td{
        padding:2px;
    }
    div.search{
        border: solid 1px #186f1a;
        padding: 8px;
        border-radius: 5px;
    }
    .left-side {
        left: 20px;
        position: absolute;
        width: 170px;
    }
    .main {
        padding-left: 180px;
        margin-right: 0;
    }
    a.disabled, a.disabled:focus, a.disabled:hover, a[disabled], a[disabled]:focus, a[disabled]:hover {
        color: #aaa;
        text-decoration: none;
        cursor: default;
    }

</style>
<?php $this->beginBlock('img') ?>
$(function(){

    $('.tree').each(function() {
        var $this = $(this);
        $this.treeview({collapsed: false, unique: false});
    });
    var id = '<?=Yii::$app->request->get('id')?>';
    $('.tree li.li'+id).addClass('active');
    $('.tree li.li'+id).parents('li').addClass('active');
    //$('.tree li.li'+id).parents('li').find('.hitarea').click();

    $('.tsearch').change(function(){
        var row = $('.tomb_row').val();
        var col = $('.tomb_col').val();
        var obj = 'item_' + row + '_' + col;

        $('li').css({"-webkit-animation":""});
        $('.'+obj).css({"-webkit-animation":"twinkling 2s infinite ease-in-out"});
        //$('.'+obj).addClass('on');
    });

    $('.recommend').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var that = this;
        $.get(url,function(xhr){
            if (xhr.status) {
                if (xhr.data==1){
                    $(that).text('取消推荐');
                } else {
                    $(that).text('推荐');
                }
            } else {
                alert(xhr.info);
            }
        },'json');
    });

})
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>


