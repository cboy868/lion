<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use app\modules\grave\models\Free;
$this->params['current_menu'] = 'grave/free/index';

$this->title = '免费葬逝者管理';
$this->params['breadcrumbs'][] = ['label' => '免费葬管理', 'url' => ['/grave/admin/free/index']];
$this->params['breadcrumbs'][] = $this->title;

$cur_free_id = Yii::$app->request->get('free_id');
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
                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['create',
                        'free_id'=>Yii::$app->request->get('free_id')], ['class' => 'btn btn-primary btn-sm new-menu']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="search-box search-outline">
                        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>

            <div class="col-xs-12 free-dead-index">
                <div class="widget-box transparent ui-sortable-handle">
                    <div class="widget-header" style="z-index: 0">
                        <div class="no-border">
                            <ul class="nav nav-tabs">
                                <?php
                                $frees = Free::find()->where(['status'=>[Free::STATUS_NORMAL,Free::STATUS_FINISH]])
                                    ->orderBy('id desc')
                                    ->limit(5)
                                    ->all();
                                ?>
                                <li class="<?php if(0 == $cur_free_id) echo'active';?>">
                                    <a href="<?=Url::toRoute(['index', 'free_id'=>0])?>">待排期</a>
                                </li>
                                <?php foreach ($frees as $free): ?>
                                <li class="<?php if($free->id == $cur_free_id)echo'active';?>">
                                    <a href="<?=Url::toRoute(['index', 'free_id'=>$free->id])?>"><?=$free->title?></a>
                                </li>
                                <?php endforeach;?>

                            </ul>
                        </div>
                    </div>
                </div>

                <?php
                $frees = Free::sel();
                $frees = [0=>'待选期']+$frees;
                ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-striped table-hover table-bordered table-condensed'],
        // 'filterModel' => $searchModel,
        'columns' => [
            'id',
            'contact_user',
            'contact_mobile',
            'dead',
            'relation',
             'free.title',
//             [
//                 'label' => '是否已确认',
//                 'value' => function($model) {
//                    return $model->is_confirm ? '是':'否';
//                 }
//             ],
            [
                'label' => '期次',
                'value' => function($model) use ($frees){
                    if (isset($model->free) && $model->free->status == Free::STATUS_FINISH) {
                        return $model->free->title;
                    }
                    return Html::dropDownList('free_id', $model->free_id, $frees,['class'=>'sel-free','data-id'=>$model->id]);
                },
                'format' =>'raw'
            ],
            'confirm_at',
            [
                'label' => '操作人',
                'value' => function($model){
                    if ($model->op_user) {
                        return $model->op->username;
                    }
                }
            ],
             'created_at:date',
             'note:ntext',
            // 'status',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?php $this->beginBlock('free') ?>
    $(function () {
        $('.sel-free').change(function (e) {
            e.preventDefault();
            var free_id = $(this).val();
            var id = $(this).data('id');
            var csrf = "<?=Yii::$app->request->getCsrfToken()?>";
            var that = this;

            $.post("<?=Url::toRoute(['free'])?>",{id:id,free_id:free_id,_csrf:csrf},function(xhr){
                if (xhr.status) {
                    console.dir('修改成功');
                    $(that).closest('tr').remove();
                } else {
                    alert(xhr.info);
                    location.reload();
                }
            },'json');
        });
    })
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['free'], \yii\web\View::POS_END); ?>

