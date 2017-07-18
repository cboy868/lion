<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\Grave\models\Tomb;
use app\core\widgets\DetailView;
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
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('img') ?>
$(function(){
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



