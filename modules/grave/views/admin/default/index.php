<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\Grave\models\Tomb;
use app\core\widgets\DetailView;
use yii\helpers\ArrayHelper;
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
                <?=  Html::encode($this->title) ?> 
                <small>
                    墓区管理页面
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <?php $id = Yii::$app->request->get('id');?>

            <div class="col-xs-2">
                 <ul class="nav nav-list">
                     <?=  Html::a('<i class="fa fa-plus"></i> 添加新墓区', ['create'], ['class' => 'btn btn-primary btn-sm ', 'style'=>'width:100%']) ?>
                     <li class="<?php if (!$id) { echo 'active'; } ?>" >
                         <a href="<?=Url::toRoute(['index'])?>" class="dropdown-toggle">
                            <i class="menu-icon fa fa-circle"></i>
                            <span class="menu-text">所墓大区</span>
                        </a>
                     </li>
                    <?php foreach ($cates as $key => $value): ?>
                        <li class="<?php if(isset($value['child'])){echo 'p-menu';}?> <?php if ($value['id'] == $id) { echo 'active'; } ?>">
                                <a href="<?=$value['url']?>" class="dropdown-toggle">
                                    <i class="menu-icon fa fa-bars"></i>
                                    <span class="menu-text"><?=$value['name']?></span>
                                    <b class="arrow"></b>
                                </a>
                            <b class="arrow"></b>
                            <?php if (!isset($value['child'])) { continue; } ?>
                            <ul class="submenu" style="display:block;">
                                <?php foreach ($value['child'] as $k => $val): ?>
                                    <?php if (!isset($val['child'])): ?>
                                        <li class="<?php if ($val['id'] == $id) { echo 'active'; } ?>" rel="">
                                            <a href="<?=$val['url']?>">
                                                <i class="menu-icon"></i>
                                                <?=$val['name']?>
                                                <b class="arrow"></b>
                                            </a>
                                            <b class="arrow"></b>
                                        </li>
                                    <?php else: ?>
                                        <li class="p-menu <?php if ($val['id'] == $id) { echo 'active'; } ?>">
                                            <a href="<?=$val['url']?>" class="dropdown-toggle">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                <?=$val['name']?>
                                                <b class="arrow "></b>
                                            </a>
                                            <b class="arrow"></b>
                                            <ul class="submenu" style="display:block;">
                                                <?php foreach ($val['child'] as $k => $last):?>
                                                    <?php if (!isset($last['child'])): ?>
                                                        <li class="<?php if ($last['id'] == $id) { echo 'active'; } ?>" rel="">
                                                            <a href="<?=$last['url']?>">
                                                                <i class="menu-icon"></i>
                                                                <?=$last['name']?>
                                                                <b class="arrow"></b>
                                                            </a>
                                                            <b class="arrow"></b>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="p-menu <?php if ($last['id'] == $id) { echo 'active'; } ?>">
                                                            <a href="<?=$last['url']?>" class="dropdown-toggle">
                                                                <i class="menu-icon fa fa-caret-right"></i>
                                                                <?=$last['name']?>
                                                                <b class="arrow "></b>
                                                            </a>
                                                            <b class="arrow"></b>
                                                            <ul class="submenu" style="display:block;">
                                                                <?php foreach ($last['child'] as $k => $l1):?>
                                                                    <li class="<?php if ($l1['id'] == $id) {echo 'active';}?>">
                                                                        <a href="<?=$l1['url'];?>">
                                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                                            <?=$l1['name']?>
                                                                            <b class="arrow "></b>
                                                                        </a>
                                                                        <b class="arrow"></b>
                                                                    </li>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        </li>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </ul>
                        </li>
                    <?php endforeach;?>
                </ul><!-- /.nav-list -->
                
            </div>


            <div class="col-xs-10 grave-index">
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
                                <td rowspan="6" width="300"><img src="<?=$model->getThumb('300x200')?>"></td>
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
                                    <a href="<?=Url::toRoute(['update', 'id'=>$model->id])?>" class="btn btn-default"><i class="fa fa-edit"></i> 编辑</a>
                                    <?php if ($model->is_leaf): ?>
                                        <a href="<?=Url::toRoute(['recommend', 'id'=>$model->id])?>" class="recommend btn btn-default" style="color:green;">
                                            <?php if ($model->recommend):?>
                                                取消推荐
                                            <?php else:?>
                                                推荐
                                            <?php endif;?>
                                        </a>
                                        <a href="<?=Url::toRoute(['admin/tomb/create', 'grave_id'=>$model->id])?>" class="btn btn-default"><i class="fa fa-plus"></i> 添加墓位</a>
                                        &nbsp;
                                        <a href="<?=Url::toRoute(['delete', 'id'=>$model->id])?>"
                                           class="btn btn-default"
                                           style="color:red;" data-confirm="您确定要删除此项吗？"
                                           data-method="post" data-pjax="0"><i class="fa fa-trash"></i> 删除
                                        </a>

                                        <a href="<?=Url::toRoute(['/grave/admin/tomb/ix', 'grave_id'=>$model->id])?>" class="btn btn-success" target="_blank"> 进入墓位列表</a>
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
                            <p>本园区共有大区 <strong><?=$large_cnt?></strong> 处，子墓区 <strong><?=$small_cnt?></strong> 处,
                                墓位总计 <strong><?=$tomb_cnt?> </strong> 座,销售情况如右图
                            </p>
                            <p>更多详细情况，请点击左侧墓区列表</p>
                        </div>
                        <div class="col-md-5">
                            <?=\app\modules\analysis\widgets\Analysis::widget([
                                'name'=>'graveStatus'
                                ])?>
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

                    </style>
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


<?php $this->beginBlock('img') ?>
$(function(){

    $('.tsearch').change(function(){
        var row = $('.tomb_row').val();
        var col = $('.tomb_col').val();
        var obj = 'item_' + row + '_' + col;

$('li').css({"-webkit-animation":""});
$('.'+obj).css({"-webkit-animation":"twinkling 1s infinite ease-in-out"});
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



