<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;


$this->title = '审批流程管理';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
            <!-- 
                <?=  Html::a($this->title, ['index']) ?> 
            -->
                <small>
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增审批流程', ['create'], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
            <div class="col-xs-12">
                <?php echo \app\core\widgets\Alert::widget()?>
            </div>

            <div class="col-xs-12 approval-process-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'title',
            'intro:ntext',
             [
                 'label' => '可发起的人员',
                 'value' => function($model){
                    $u = [];
                    foreach ($model->cans as $user){
                        $u[] = $user->user;
                    }
                    $u = \yii\helpers\ArrayHelper::getColumn($u, 'username');
                    return implode(',', $u);
                 }
             ],
             'step_total',
             'user.username',
             'created_at:datetime',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>