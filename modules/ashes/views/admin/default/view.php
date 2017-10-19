<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\modules\ashes\models\Box;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '柜子', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->box_no . '号柜操作记录';

$this->params['current_menu'] = 'ashes/default/index';

\app\assets\JqueryuiAsset::register($this);
?>

<div class="page-content">
    <!-- /section:settings.box -->

    <?php
    Modal::begin([
        'header' => '取盒操作',
        'id' => 'modalAdd',
        'clientOptions' => ['backdrop' => 'static', 'show' => false]
        // 'size' => 'modal'
    ]) ;

    echo '<div id="modalContent"></div>';

    Modal::end();
    ?>

    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($model->box_no) ?>号柜
                <small>
                    <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>

                    <?php if ($model->status == Box::STATUS_EMPTY):?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger  btn-xs',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <a href="<?=url(['/ashes/admin/log/create', 'box_id'=>$model->id])?>" class="btn btn-info btn-xs btn-op">
                            存入
                        </a>
                    <?php endif;?>

                    <?php if ($model->status == Box::STATUS_FULL):?>
                        <a href="<?=Url::toRoute(['/ashes/admin/log/take', 'box_id'=>$model->id])?>"
                           class='btn btn-info btn-sm modalAddButton btn-op'
                           title="取盒"
                           onclick="return false">取盒</a>
                    <?php endif;?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-6 box-view">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'area.title',
                        'box_no',
                        'row',
                        'col',
                    ],
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->


            <div class="col-md-12">
                <h2>存取记录</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th width="100">墓位号</th>
                            <th width="80">寄存人</th>
                            <th width="150">联系人</th>
                            <th width="130">使用人</th>
                            <th width="100">安葬日期</th>
                            <th width="100">登记人</th>
                            <th width="300">存取时间</th>

                            <th>登记日期</th>

                        </tr>
                    </table>

                    <?php foreach ($model->logs as $v):?>
                    <table class="table table-bordered">
                        <tr>
                            <td width="100"><?=$v->tombNo?></td>
                            <td width="80"><?=$v->save_user?></td>
                            <td width="150"><?=$v->contact?>(<?=$v->mobile?>)</td>
                            <td width="130"><?=$v->deads?></td>
                            <td width="100"><?=$v->bury_date?></td>
                            <td width="100"><?=$v->op->username?></td>
                            <td width="300"><?=$v->save_time?> 至 <?=$v->out_time?></td>
                            <td><?=date('Y-m-d H:i:s', $v->created_at);?></td>
                        </tr>
                        <tr>
                            <td colspan="8"><?=$v->note?></td>
                        </tr>
                    </table>
                    <?php endforeach;?>



            </div>
        </div><!-- /.row -->

    </div><!-- /.page-content-area -->
</div>