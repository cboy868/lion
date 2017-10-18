<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\approval\models\Approval */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '我的审批', 'url' => ['index']];
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
            <div class="col-xs-12 approval-view">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>所属流程</th>
                        <td><?=$model->process->title?></td>
                        <th>审批状态</th>
                        <td><?=$model->pro?></td>
                        <th>提交人</th>
                        <td><?=$model->user->username?></td>
                        <th>提交时间</th>
                        <td><?=date('Y-m-d H:i',$model->created_at)?></td>
                    </tr>
                    <?php if ($model->total):?>
                        <tr>
                            <th>总金额</th>
                            <td><?=$model->total?></td>
                            <th>已付金额</th>
                            <td><?=$model->yet_money?></td>
                        </tr>
                    <?php endif;?>
                    <tr style="text-align: center">
                        <td colspan="8"><?=$model->title?></td>
                    </tr>
                    <tr style="text-align: center">
                        <td colspan="8"><?=$model->intro?></td>
                    </tr>
                </table>

                <?php $steps = $model->steps;?>
                <table class="table table-bordered">
                    <tr>
                        <th>第n次审批</th>
                        <th>步骤</th>
                        <th>审批人</th>
                        <th>审批状态</th>
                    </tr>
                    <?php foreach ($steps as $step):?>
                        <tr>
                            <td>第<?=$step->time?>次</td>
                            <td><?=$step->step_name?></td>
                            <td><?=$step->user->username?></td>
                            <td><?=$step->pro?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>