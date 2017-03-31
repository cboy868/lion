<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Bag */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '打包品列表', 'url' => ['index']];
?>
<style type="text/css">
    table th{
        width:80px;
    }
</style>
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
            <div class="col-xs-10 bag-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => '分类',
                'value' => isset($model->category->name) ? $model->category->name :'跨分类'
            ],
            'title',
            'op.username',
            'original_price',
            'price',
            [
                'label' => '缩略图',
                'value' => "<img src='".$model->getThumbImg('100x100')."'>",
                'format'=> 'raw'
            ],
            'intro:raw',
            'typeText',
            'created_at:datetime',
        ],
    ]) ?>


        <table class="table table-bordered">
            <caption align="top">关联商品</caption>  
            <tr>
                <th>商品名</th>
                <th>数量</th>
                <th>单价</th>
            </tr>
            <?php if ($model->rels): ?>
                <?php foreach ($model->rels as $k => $v): ?>
                    <tr>
                        <td><?=$v->sku->getName()?></td>
                        <td><?=$v->num?></td>
                        <td><?=$v->unit_price?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </table>

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>