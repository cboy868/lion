<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->title = '接待记录';
$this->params['breadcrumbs'][] = ['label' => '食堂', 'url' => ['/mess/admin/default/index']];
$this->params['breadcrumbs'][] = $this->title;
\app\assets\JqueryuiAsset::register($this);
?>
<style>
    .table > tbody > tr > td.middle-center{
        text-align:center;
        vertical-align:middle;
    }
    .intable > thead > tr > th{
        border-bottom:0;
    }
</style>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= $this->title?>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 添增接待用餐', ['create'],
                        [
                            'class' => 'btn btn-info btn-sm modalAddButton pull-right',
                            'data-loading-text'=>"页面加载中, 请稍后...",
                            'onclick'=>"return false"
                        ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '添加记录',
            'id' => 'modalAdd',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
            // 'size' => 'modal'
        ]) ;

        echo '<div id="modalContent"></div>';

        Modal::end();
        ?>

        <?php
        Modal::begin([
            'header' => '编辑',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false]
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

            <div class="col-xs-12 mess-reception-index">


                <table class="table table-striped table-hover table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>用户名</th>
                        <th>客户名</th>
                        <th>接待人数</th>
                        <th>
                            <table style="margin:-1px 0px 0px 0px;" class="table table-condensed intable">
                                <thead>
                                <tr>
                                    <th>用餐时间</th>
                                    <th>菜品</th>
                                    <th width="50">数量</th>
                                    <th width="50">单价</th>
                                    <th width="50">合计</th>
                                </tr>
                                </thead>
                            </table>
                        </th>
                        <th width="140" data-type="html">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $models = $dataProvider->getModels();
                    foreach ($models as $model):
                        $menus = $model->menus;
                    ?>
                    <tr data-key="1">
                        <td><?=$model->user->username;?></td>
                        <td><?=$model->reception_customer;?></td>
                        <td><?=$model->reception_number?></td>

                        <td>
                            <table style="margin:-1px 0px 0px 0px;" class="table table-condensed table-hover table-striped">
                                <tbody>
                                <?php foreach ($menus as $menu):?>
                                    <tr>
                                        <td><?=$menu->day_time?><?=$types[$menu->type]?></td>
                                        <td class="blue2"><?=$menu->menu->name?></td>
                                        <td width="50" class="blue text-center"><?=$menu->num?>份</td>
                                        <td width="50" class="green text-right">
                                            <?=$menu->real_price?>元
                                        </td>
                                        <td width="50" class="red text-right">
                                            <?=$menu->num*$menu->real_price?>元
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </td>

                        <td>
                            <a class="modalEditButton"
                               href="<?=Url::toRoute(['update','id'=>$model->id])?>"
                               title="编辑"
                               data-loading-text="页面加载中, 请稍后..." onclick="return false">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a href="<?=Url::toRoute(['delete','id'=>$model->id])?>"
                               title="删除"
                               aria-label="删除"
                               data-pjax="0"
                               data-confirm="您确定要删除此项吗？"
                               data-method="post">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                            <a href="<?=Url::toRoute(['view','id'=>$model->id])?>"
                               title="用餐安排"
                               aria-label="用餐安排"
                               data-pjax="0"
                               class="red"
                            >
                                [用餐安排]
                            </a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <div class="hr hr-18 dotted hr-double"></div>
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
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>