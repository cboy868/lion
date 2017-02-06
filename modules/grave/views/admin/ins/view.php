<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Ins */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ins', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看
                    <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger  btn-xs',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-10 ins-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'guide_id',
            'user_id',
            'tomb_id',
            'op_id',
            'position',
            'shape',
            'content:ntext',
            'img',
            'is_tc',
            'font',
            'font_num',
            'new_font_num',
            'is_confirm',
            'confirm_date',
            'confirm_by',
            'pre_finish',
            'finish_at',
            'note:ntext',
            'version',
            'paint',
            'is_stand',
            'paint_price',
            'letter_price',
            'tc_price',
            'status',
            'updated_at',
            'created_at',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>