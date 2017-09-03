<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;


$this->params['current_menu'] = 'grave/ins/index';


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '碑文列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '【'.$model->tomb->tomb_no . '】碑文详情';
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="row">
            <div class="col-xs-10 ins-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'guide.username',
            'user.username',
            'tomb.tomb_no',
            'op.username',
            [
                'label' => '碑型',
                'value' =>  $model->shape == 'v' ? '竖' : '横'
            ],
            [
                'label' => '碑文图片',
                'value' => sprintf('<img src="%s" style="width:200px"/><img src="%s" style="width:200px" />', $model->getImg('front'), $model->getImg('back')),
                'format' => 'raw'
            ],
            [
                'label' => '是否繁体',
                'value' => $model->is_tc ? '繁体' : '简体'
            ],
            [
                'label' => '字体',
                'value' => $model->getFontStyle()
            ],
            [
                'label' => '是否确认',
                'value' => $model->is_confirm == 1 ? '已确认' : '未确认'
            ],
            'confirm_date',
            'confirm.username',
            'pre_finish',
            'finish_at',
            'note:ntext',
            'paintTxt',
            'created_at:datetime',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>