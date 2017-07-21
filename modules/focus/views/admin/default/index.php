<?php
use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;
use app\modules\cms\models\Category;
use app\core\helpers\StringHelper;


use yii\widgets\LinkPager;

$this->title = '焦点图管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .thumbnail>a.img{
        height: 120px;
        display: inline-block;
        overflow: hidden;
    }

    .thumbnail{
        border: 3px solid #ccc;
    }
</style>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <?php 
            Modal::begin([
                'header' => '新增',
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
            
            <div class="col-xs-10 album-index">

            <div class="row">

            <?php foreach ($dataProvider->getModels() as $k => $model): ?>
                <div class="col-sm-4 col-md-3">
                    <div class="thumbnail">
                        <a href="<?=Url::toRoute(['list', 'id'=>$model->id])?>" class="img">
                            <img src="<?=$model->thumb?$model->thumb : defaultImg();?>" alt="<?=$model->title?>">
                        </a>
                        <div class="caption">
                            <h4><a href="<?=Url::toRoute(['list', 'id'=>$model->id])?>"><?=StringHelper::truncate($model->title,20)?></a></h4>

                <?php if (Yii::$app->user->can('focus/default/delete-cate')):?>
                            <p><a href="<?=Url::toRoute(['delete-cate', 'id'=>$model->id])?>" title="删除" aria-label="删除" data-confirm="将删除本分类下的所有焦点图，您确定要删除此项吗,？" data-method="post" data-pjax="0" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a>
                <?php endif;?>
                                <?php if (Yii::$app->user->can('focus/default/update-cate')):?>
                            <a href="<?=Url::toRoute(['update-cate', 'id'=>$model->id])?>" class="btn btn-success modalEditButton" role="button" data-loading-text="页面加载中, 请稍后..." onclick="return false"><i class="fa fa-pencil"></i></a></p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
                <?php if (Yii::$app->user->can('focus/default/create-cate')):?>
              <div class="col-sm-1 col-md-1">
                <div class="thumbnail" style="cursor: pointer;">
                <a href="<?=Url::toRoute(['create-cate'])?>" class="modalAddButton" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                  <img src="/static/images/plus.png">
                </a>
                </div>
              </div>
                <?php endif;?>
            </div>

            <?php 
                echo LinkPager::widget([
                    'pagination' => $dataProvider->getPagination(),
                ]);
             ?>

            <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
