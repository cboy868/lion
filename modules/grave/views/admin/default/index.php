<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\Grave\models\Tomb;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\GraveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '墓区管理';
$this->params['breadcrumbs'][] = $this->title;


?>
<style type="text/css">
    ul, ol, li{
        list-style: none;
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm modalAddButton']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php 
            Modal::begin([
                'header' => '添增',
                'id' => 'modalAdd',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>


        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <?php $pid = $params['pid']; ?>

            <div class="col-xs-2">
                 <ul class="nav nav-list">
                     <?=  Html::a('<i class="fa fa-plus"></i> 添加新墓区', ['create'], ['class' => 'btn btn-primary btn-sm modalAddButton', 'style'=>'width:100%']) ?>
                     <li class="<?php if ($pid == 0) { echo 'active'; } ?>" >
                         <a href="<?=Url::toRoute(['index'])?>" class="dropdown-toggle">
                            <i class="menu-icon fa fa-circle"></i>
                            <span class="menu-text">所有大区</span>
                        </a>
                     </li>
                    <?php foreach ($cates as $key => $value): ?>
                        <li class="<?php if(isset($value['child'])){echo 'p-menu';}?> <?php if ($value['id'] == $pid) { echo 'active'; } ?>">
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
                                        <li class="<?php if ($val['id'] == $pid) { echo 'active'; } ?>" rel="">
                                            <a href="<?=$val['url']?>">
                                                <i class="menu-icon"></i>
                                                <?=$val['name']?>
                                                <b class="arrow"></b>
                                            </a>
                                            <b class="arrow"></b>
                                        </li>
                                    <?php else: ?>
                                        <li class="p-menu">
                                            <a href="#" class="dropdown-toggle">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                <?=$val['name']?>
                                                <b class="arrow "></b>
                                            </a>
                                            <b class="arrow"></b>
                                            <ul class="submenu" style="display:block;">
                                                <?php foreach ($val['child'] as $k => $last):?>
                                                    <li class="<?php if ($last['id'] == $pid) {echo 'active';}?>">
                                                        <a href="<?=$last['url'];?>">
                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                           <?=$last['name']?>
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
                    <?php endforeach;?>
                </ul><!-- /.nav-list -->
                
            </div>


            <div class="col-xs-10 grave-index">
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
                <?php foreach ($dataProvider->getModels() as $k => $grave): ?>
                    <div class="col-xs-4">
                        <div class="panel panel-info">
                          <div class="panel-heading text-center">
                          <?php if ($grave->is_leaf): ?>
                            <a href="<?=Url::toRoute(['admin/tomb/index', 'grave_id'=>$grave->id])?>"><strong><?=$grave->name?></strong></a>
                          <?php else: ?>
                            <a href="<?=Url::toRoute(['index', 'pid'=>$grave->id])?>"><strong><?=$grave->name?></strong></a>
                          <?php endif ?>
                          </div>
                          <div class="panel-body no-padding" style="min-height:110px">

                            <div class="row">
                                <div class="col-sm-6">

                              <?php if ($grave->is_leaf): ?>
                                <a href="<?=Url::toRoute(['admin/tomb/index', 'grave_id'=>$grave->id])?>">
                                    <img src="<?=$grave->getThumb('200x400', '/static/images/default.png')?>" class="img-thumbnail">
                                </a>
                              <?php else: ?>
                                <a href="<?=Url::toRoute(['index', 'pid'=>$grave->id])?>">
                                    <img src="<?=$grave->getThumb('200x400', '/static/images/default.png')?>" class="img-thumbnail">
                                </a>
                              <?php endif ?>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <ul style="padding-left:0">
                                        <?php $cnt =  $grave->staCount();
                                        $sta = Tomb::getSta();
                                        ?>
                                        <li>总数：<code><?=array_sum($cnt)?>个</code></li>
                                        <?php foreach ($cnt as $k => $v): ?>
                                            <li><?=$sta[$k]?>：<code><?=$v?>个</code></li>
                                        <?php endforeach ?>
                                        
                                    </ul>
                                </div>
                            </div>

                          </div>
                          <div class="panel-footer">
                              <div class="row">
                                  <div class="col-xs-4 text-left">
                                      <a href="<?=Url::toRoute(['update', 'id'=>$grave->id])?>" class="modalEditButton"><i class="fa fa-edit"></i> 编辑</a>
                                  </div>

                                  <?php if ($grave->is_leaf): ?>
                                      <div class="col-xs-8 text-right">

                                          <a href="<?=Url::toRoute(['admin/tomb/create', 'grave_id'=>$grave->id])?>"><i class="fa fa-plus"></i> 添加墓位</a>
                                          &nbsp;
                                         <a href="<?=Url::toRoute(['delete', 'id'=>$grave->id])?>" 
                                         style="color:red;" data-confirm="您确定要删除此项吗？" 
                                         data-method="post" data-pjax="0"><i class="fa fa-trash"></i>
                                         </a>

                                      </div>
                                  <?php endif ?>
                              </div>
                          </div>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>


                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


