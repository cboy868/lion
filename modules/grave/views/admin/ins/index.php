<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\InsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '碑文列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 ins-index">
  
    <div class="widget-box transparent ui-sortable-handle" id="widget-box-13">
        <div class="widget-header">
            <div class="widget-toolbar no-border">
                <ul class="nav nav-tabs">
                    <li class="<?php if ($searchModel->is_confirm == null): ?>active<?php endif ?>">
                        <a href="<?=Url::toRoute(['index'])?>" aria-expanded="true">全部</a>
                    </li>
                    <li class="<?php if ($searchModel->is_confirm === '0'): ?>active<?php endif ?>">
                        <a href="<?=Url::toRoute(['index','InsSearch[is_confirm]'=>0])?>" aria-expanded="true">待确认</a>
                    </li>
                    <li class="<?php if ($searchModel->is_confirm == 1): ?>active<?php endif ?>">
                        <a href="<?=Url::toRoute(['index','InsSearch[is_confirm]'=>1])?>" aria-expanded="true">已确认</a>
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
            'tomb.tomb_no',
            'guide.username',
            'op.username',
            'user.username',
            // 'position',
            [
                'label' => '碑型',
                'value' => function($model){
                    return $model->shape == 'v' ? '竖' : '横';
                }
            ],
            // 'content:ntext',
            // 'img',
            // 'is_tc',
            // 'font',
            // 'font_num',
            // 'new_font_num',
            [
                'label' => '已确认',
                'value' => function($model){
                    return $model->is_confirm ? '是' : '<font color="red">否</font>';
                },
                'format' => 'raw'
            ],
            // 'confirm_date',
            // 'confirm_by',
            // 'pre_finish',
            // 'finish_at',
            // 'note:ntext',
            // 'version',
            'paintTxt',
            // 'is_stand',
            // 'paint_price',
            // 'letter_price',
            // 'tc_price',
            // 'status',
            'updated_at:datetime',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>