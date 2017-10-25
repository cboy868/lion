<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\ashes\models\Box;
use yii\bootstrap\Modal;
$this->title = '骨灰堂';
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

                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/ashes/admin/area/index'])?>">
                        <i class="fa fa-th-large fa-2x"></i>  架区管理</a>
                </div>
            </h1>
        </div><!-- /.page-header -->
        <?=\app\core\widgets\Alert::widget();?>

        <?php
        Modal::begin([
            'header' => '取盒操作',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
            // 'size' => 'modal'
//            'options' => [
//                    'tabindex' => 1
//            ]
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>


        <div class="row">
            <?php $pid = 1; ?>

            <div class="col-xs-2">
                <ul class="nav nav-list">
                    <li class="<?php if ($pid == 0) { echo 'active'; } ?>" >
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-circle"></i>
                            <span class="menu-text">架区选择</span>
                        </a>
                    </li>
                    <?php foreach ($cates as $key => $value): ?>
                        <li class="<?php if(isset($value['child'])){echo 'p-menu';}?> <?php if ($value['id'] == $pid) { echo 'active'; } ?>">
                            <a href="<?=$value['url']?>" class="dropdown-toggle">
                                <i class="menu-icon fa fa-bars"></i>
                                <span class="menu-text"><?=$value['title']?></span>
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
                                                <?=$val['title']?>
                                                <b class="arrow"></b>
                                            </a>
                                            <b class="arrow"></b>
                                        </li>
                                    <?php else: ?>
                                        <li class="p-menu">
                                            <a href="#" class="dropdown-toggle">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                <?=$val['title']?>
                                                <b class="arrow "></b>
                                            </a>
                                            <b class="arrow"></b>
                                            <ul class="submenu" style="display:block;">
                                                <?php foreach ($val['child'] as $k => $last):?>
                                                    <li class="<?php if ($last['id'] == $pid) {echo 'active';}?>">
                                                        <a href="<?=$last['url'];?>">
                                                            <i class="menu-icon fa fa-caret-right"></i>
                                                            <?=$last['title']?>
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
                .table ul li.box {
                    margin: 0px;
                    display: block;
                    /*width: 40px;*/
                    float: left;
                    background: #eee;
                    border: 1px solid #ccc;
                    margin-right:5px;
                    position: relative;
                    overflow: hidden;
                    font-size: 10px;
                    border-radius: 5px;
                    padding: 3px;
                    margin-top: 10px;
                }
                .table ul li{
                    width:120px;
                    height:100px;
                }
                .table ul li.empty{
                    width:45px;
                }

                .table ul li.box .btns{
                    width:100%;
                    position: absolute;
                    bottom:1px;
                }

                .table ul li.box a.btn-op {
                    float: right;
                    margin-right:5px;
                }
                .table ul li.box a.view {
                    float: left;
                    margin-left:5px;
                    text-align: center;
                    margin-top:3px;
                }
                .table ul li.box p{
                    margin-bottom:2px;
                }
            </style>

            <?php
            $models = $dataProvider->getModels();

            $res = ArrayHelper::index($models, 'id', 'area_id');
            ?>
            <div class="col-xs-10 grave-index">
                <div class="rows">
                    <div class="col-xs-12">
                        <?=\app\core\widgets\Alert::widget();?>
                    </div>

                    <div class="col-xs-12">
                        <?php foreach ($res as $k=>$v):?>
                            <?php $result = ArrayHelper::index($v, 'id', 'row');?>
                            <h2><?=$boxes[$k]['title']?></h2>
                        <table class="table table-hover">
                            <tbody>
                            <?php foreach ($result as $k=>$models):?>
                            <tr>
                                <td>
                                    <div class="pull-left">
                                        <strong> <?=$k?>排 </strong>
                                    </div>
                                    <ul>
                                    <?php foreach ($models as $model): ?>
                                        <li class="box <?php if(!$model->log_id)echo"empty"?>">

                                            <h5><?=$model->box_no?>号</h5>

                                            <?php if ($model->log_id):?>
                                            <p>联系人:<?=$model->log->contact?></p>
                                            <p><?=$model->log->mobile?></p>
                                            <?php endif?>

                                            <div class="btns">

                                                <a href="<?=url(['view', 'box_id'=>$model->id])?>" class="view">
                                                    详细
                                                </a>

                                                <?php if ($model->status == Box::STATUS_EMPTY):?>
                                                    <a href="<?=url(['/ashes/admin/log/create', 'box_id'=>$model->id])?>"
                                                       class="btn btn-info btn-xs btn-op">
                                                        存入
                                                    </a>
                                                <?php endif;?>

                                                <?php if ($model->status == Box::STATUS_FULL):?>
                                                    <a href="<?=Url::toRoute(['/ashes/admin/log/take', 'box_id'=>$model->id])?>"
                                                       class='btn btn-info btn-xs modalAddButton btn-op'
                                                       title="取盒"
                                                       data-loading-text="页面加载中, 请稍后..." onclick="return false">取盒</a>
                                                <?php endif;?>
                                            </div>

                                        </li>
                                    <?php endforeach;?>
                                    </ul>
                                </td>
                            </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        <?php endforeach;?>
                    </div>

                </div>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>


