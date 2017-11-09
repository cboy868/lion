<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

use app\assets\FootableAsset;
use app\modules\shop\models\Category;


$this->title = '商城主页面';
$this->params['breadcrumbs'][] = $this->title;
\app\assets\EchartsAsset::register($this);

?>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>

                <small>


                    <?php if (Yii::$app->user->can('shop/bag/index')):?>
                        <div class="pull-left nc">
                            <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/bag/index'])?>">
                                <i class="fa fa-shopping-bag fa-2x"></i>  打包品管理</a>
                        </div>
                    <?php endif;?>

                    <?php if (Yii::$app->user->can('shop/goods/index')):?>
                        <div class="pull-left nc">
                            <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['/shop/admin/goods/index'])?>">
                                <i class="fa fa-list fa-2x"></i>  商品管理</a>
                        </div>
                    <?php endif;?>

                    <?php if (Yii::$app->user->can('shop/type/index')):?>
                        <div class="pull-right nc">
                            <a class="btn btn-default btn-sm" href="<?=Url::toRoute(['/shop/admin/type/index'])?>">
                                <i class="fa fa-ellipsis-v fa-2x"></i>  商品类型管理</a>
                        </div>
                    <?php endif;?>
                    <?php if (Yii::$app->user->can('shop/category/index')):?>
                        <div class="pull-right nc">
                            <a class="btn btn-default btn-sm" href="<?=Url::toRoute(['/shop/admin/category/index'])?>">
                                <i class="fa fa-sitemap fa-2x"></i>  商品分类管理</a>
                        </div>
                    <?php endif;?>


                    <?php if (Yii::$app->user->can('shop/inventory-purchase/index')):?>
                        <div class="pull-right nc">
                            <a class="btn btn-default btn-sm" href="<?=Url::toRoute(['/shop/admin/inventory-purchase/index'])?>">
                                <i class="fa fa-shopping-basket fa-2x"></i>  商品进货管理</a>
                        </div>
                    <?php endif;?>

                    <?php if (Yii::$app->user->can('shop/inventory-storage/index')):?>
                        <div class="pull-right nc">
                            <a class="btn btn-default btn-sm" href="<?=Url::toRoute(['/shop/admin/inventory-storage/index'])?>">
                                <i class="fa fa-inbox fa-2x"></i>  仓库管理</a>
                        </div>
                    <?php endif;?>

                    <?php if (Yii::$app->user->can('shop/inventory-supplier/index')):?>
                        <div class="pull-right nc">
                            <a class="btn btn-default btn-sm" href="<?=Url::toRoute(['/shop/admin/inventory-supplier/index'])?>">
                                <i class="fa fa-user fa-2x"></i>  供货商管理</a>
                        </div>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">

            <div class="col-xs-12 client-index">

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-xs-12 client-index">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'goodsSale'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->

            <div class="col-md-6">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'goodsHotPrice'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>
            <div class="col-md-6">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'goodsHotNum'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>

            <div class="col-md-12">
                <?=\app\modules\analysis\widgets\Analysis::widget(['name'=>'goodsCate'])?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div>

        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>

