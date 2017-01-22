<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->


        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <?php $pid = $params['pid']; ?>

            <div class="col-xs-2">
                 <ul class="nav nav-list">
                     <?=  Html::a('<i class="fa fa-plus"></i> 添加新墓区', ['create','mod'=>$mod], ['class' => 'btn btn-primary btn-sm modalAddButton', 'style'=>'width:100%']) ?>
                     <li class="<?php if ($pid == 0) { echo 'active'; } ?>" >
                         <a href="<?=Url::toRoute(['index', 'pid'=>0])?>" class="dropdown-toggle">
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
                <?php foreach ($dataProvider->getModels() as $k => $grave): ?>
                    <div class="col-xs-4">
                        <div class="panel panel-success">
                          <div class="panel-heading text-center">
                            <a href="#"><strong><?=$grave->name?></strong></a>
                          </div>
                          <div class="panel-body no-padding">

                            <div class="row">
                                <div class="col-sm-6">
                                    <img src="<?=$grave->getThumb('200x400', '/static/images/default.png')?>" class="img-thumbnail">
                                </div>
                                <div class="col-sm-6">
                                    <ul style="padding-left:0">
                                        <li>总数：<code>213</code></li>
                                        <li>闲置：<code>84个</code></li>
                                        <li>全款：<code>66个</code></li>
                                        <li>部分安葬：<code>11个</code></li>
                                        <li>全部安葬：<code>52个</code></li>
                                    </ul>
                                </div>
                            </div>

                          </div>
                          <div class="panel-footer">
                              <div class="row">
                                  <div class="col-xs-6 text-left">
                                      <a href="#"><i class="fa
                                              fa-edit"></i> 编辑</a>
                                  </div>

                                  <?php if ($grave->is_leaf): ?>
                                      <div class="col-xs-6 text-right">
                                          <a href="#"><i class="fa
                                                  fa-plus"></i> 添加墓位</a>
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


