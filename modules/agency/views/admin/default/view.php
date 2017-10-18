<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use yii\bootstrap\Modal;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '办事处管理', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>

                <small>
                    详细信息查看
                    <?= Html::a('Edit', ['update', 'id' => $model->id],
                        ['class' => 'btn btn-primary btn-xs modalEditButton',
                            'data-loading-text'=>"页面加载中, 请稍后...",
                            'onclick'=>"return false"]) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger  btn-xs',
                        'data' => [
                            'confirm' => '确定要删除此办事处?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <?php
        Modal::begin([
            'header' => '编辑',
            'id' => 'modalEdit',
            'clientOptions' => ['backdrop' => 'static', 'show' => false],
            'size' => 'modal-lg'
        ]) ;

        echo '<div id="editContent"></div>';

        Modal::end();
        ?>

        <div class="row">
            <div class="col-xs-10 agency-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'label'=>'负责人',
                'value' => function($model){
                    $str = '';
                    if ($model->mobile) {
                        $str = '('.$model->mobile.')';
                    }
                    return $model->lUser->username . $str;
                }
            ],
            [
                'label'=>'接待人员',
                'value' => function($model){
                    return $model->gUser->username;
                }
            ],
            [
                'label' => '是否真实存在',
                'value' => function($model){
                    return $model->is_real ? '是' : '否';
                }
            ],
            'cate',
            'phone',
            'kefu_qq',
            'addr:ntext',
            'intro:ntext',
            'created_at:datetime',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>