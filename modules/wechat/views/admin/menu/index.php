<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use app\modules\wechat\models\MenuMain;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\wechat\models\MenuMainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '微信菜单管理';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?=Html::encode($this->title)?>

                <div class="pull-right nc">
                    <a class="btn btn-danger btn-sm" href="<?=Url::toRoute(['create', 'type'=>MenuMain::TYPE_PERSONAL])?>">
                        <i class="fa fa-list-ol fa-2x"></i>  添加个性菜单</a>
                </div>
                <div class="pull-right nc">
                    <a class="btn btn-info btn-sm" href="<?=Url::toRoute(['create', 'type'=>MenuMain::TYPE_NORMAL])?>">
                        <i class="fa fa-list-ol fa-2x"></i>  添加普通菜单</a>
                </div>

            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 menu-main-index">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="border:none;">
                        <div class="no-border">
                            <ul class="nav nav-tabs">
                                <li class="<?php if($type == MenuMain::TYPE_NORMAL):?>active<?php endif;?>">
                                    <a href="<?=Url::toRoute(['/wechat/admin/menu/index', 'type'=>MenuMain::TYPE_NORMAL])?>" aria-expanded="true">普通菜单</a>
                                </li>
                                <li class="<?php if($type == MenuMain::TYPE_PERSONAL):?>active<?php endif;?>">
                                    <a href="<?=Url::toRoute(['/wechat/admin/menu/index', 'type'=>MenuMain::TYPE_PERSONAL])?>" aria-expanded="true">个性菜单</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        'name',
                        'type',
                        'is_active',
//                        'gender',
                        // 'tag',
                        // 'client_platform_type',
                        // 'language',
                        // 'country',
                        // 'province',
                        // 'city',
                         'created_at:datetime',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>