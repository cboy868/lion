<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel modules\foods\models\MixCateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '食材分类';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create'], ['class' => 'btn btn-primary btn-sm new-cate modalAddButton',"data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"]) ?>
                </small>
                <small class="pull-right">
                    <a href="<?=Url::toRoute(['/admin/shop/mix'])?>" class="btn bg-info">食材管理</a>
                </small>
            </h1>
        </div><!-- /.page-header -->


        <?php 
            Modal::begin([
                'header' => '添增',
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

            <div class="col-xs-12 mix-cate-index">
                <table class="table table-striped table-hover table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th><a href="/mg.php/foods/mix-cate/index?sort=name" data-sort="name">分类名称</a></th>
                            <th class="action-column" width="100">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($models as $k => $model): ?>
                            <tr data-key="<?=$model->id?>" >
                                <td><?=$model->name?></td>
                                <td>
                                    <!-- <a href="<?=Url::toRoute(['/foods/mix-cate/view', 'id'=>$model->id])?>" title="查看" aria-label="查看" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>  -->
                                    <a href="<?=Url::toRoute(['update', 'id'=>$model->id])?>" title="更新" aria-label="更新" data-pjax="0" class="modalEditButton","data-loading-text"=>"页面加载中, 请稍后...", "onclick"=>"return false"><span class="glyphicon glyphicon-pencil"></span></a> 
                                    <a href="<?=Url::toRoute(['delete', 'id'=>$model->id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                            
                        </tbody>
                    </table>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>







