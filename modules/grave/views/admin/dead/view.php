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
            'serial',
            'user.username',
            [
                'label' => '性别',
                'value' => function($model){
                    return [1=>'男',2=>'妇'][$model->gender];
                }
            ],

            'tomb.tomb_no',
            [
                'label' => '纪念馆',
                'value' => function($model){
                    return Html::a($model->memorial->title,
                        ['/memorial/home/default/view', 'id'=>$model->memorial_id],
                        ['target'=>'_blank']);
                },
                'format'=>'raw'
            ],
            'dead_name',
            'second_name',
            'dead_title',
            'birth_place',
            'birth',
            'fete',
            [
                'label' => '是否键在',
                'value' => function($model){
                    return [1=>'是',0=>'否'][$model->is_alive];
                }
            ],
            [
                'label' => '是否成年',
                'value' => function($model){
                    return $model->is_adult === null ? '未知' : [1=>'是',0=>'否'][$model->is_adult];
                }
            ],
            'age',
            'desc:ntext',
            [
                'label' => '是否立碑',
                'value' => function($model){
                    return $model->is_ins === null ? '未知' : [1=>'是',0=>'否'][$model->is_ins];
                }
            ],
            [
                'label' => '安葬性质',
                'value' => function($model){
                    return $model->boneType;
                }
            ],
            [
                'label' => '安葬盒类型',
                'value' => function($model){
                    return $model->boneBox;
                }
            ],
            'pre_bury',
            'bury',
            'created_at:datetime',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>