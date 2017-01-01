<?php

use yii\helpers\Html;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Set */

$this->title = $model->sname;
$this->params['breadcrumbs'][] = ['label' => '网站设置', 'url' => ['list']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看

                    <?= Html::a('Edit', ['update', 'id' => $model->sname], ['class' => 'btn btn-primary btn-xs']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->sname], [
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
            <div class="col-xs-10 set-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sname',
            'svalue:ntext',
            'svalues:ntext',
            'sintro',
            'stype',
            'smodule',
            'sort'
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>