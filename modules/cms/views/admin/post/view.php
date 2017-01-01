<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $modInfo->name, 'url' => ['index','mod'=>\Yii::$app->getRequest()->get('mod')]];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看
                    <?= Html::a('Edit', ['update', 'id' => $model->id, 'mod'=>Yii::$app->getRequest()->get('mod')], ['class' => 'btn btn-primary btn-xs']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id, 'mod'=>Yii::$app->getRequest()->get('mod')], [
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
            <div class="col-xs-10 post-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author',
            'created_by',
            'category_id',
            'title',
            'subtitle',
            'summary:ntext',
            'thumb',
            'ip',
            'view_all',
            'com_all',
            'recommend',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>