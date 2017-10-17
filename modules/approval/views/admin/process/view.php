<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\ApprovalProcess */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '审批流程管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
            <div class="col-xs-10 approval-process-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
//            'step_total',
            'user.username',
            'created_at:datetime',
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
            [
                'label' => '审批步骤及人员',
                'value' => function($model){
                    $txt = '';
                    $steps = $model->steps;
                    foreach ($steps as $v) {
                        $u = $v->approvalUsers;
                        $usernames = \yii\helpers\ArrayHelper::getColumn($u, 'username');
                        $unameStr = implode(',', $usernames);
                        $txt .= $v['step'] .'、'.$v['step_name'].': ' . $unameStr . '<br>';
                    }
                    return $txt;
                },
                'format' => 'raw'
            ],
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>