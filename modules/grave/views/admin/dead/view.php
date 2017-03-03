<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Dead */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '使用人管理', 'url' => ['index']];
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
            <div class="col-xs-10 dead-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.username',
            'tomb.tomb_no',
            'memorial_id',
            'dead_name',
            'second_name',
            'dead_title',
            'serial',
            'gender',
            'birth_place',
            'birth',
            'fete',
            'is_alive',
            'is_adult',
            'age',
            'follow_id',
            'desc:ntext',
            'is_ins',
            'bone_type',
            'bone_box',
            'pre_bury',
            'bury',
            'created_at',
            'updated_at',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>