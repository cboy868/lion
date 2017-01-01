<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model shop\models\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '商品列表', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
                <small>
                    详细信息查看

                    <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
                    <?= Html::a('删除', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger  btn-xs',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>

                    <?= Html::a('<i class="fa fa-plus"></i>继续添加', ['create', 'category_id' => $model->category_id], ['class' => 'btn btn-primary btn-xs']) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-10 goods-view">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'label' => '分类',
                            'value' => $model->category->name
                        ],
                        'name',
                        [
                            'label' => '封面',
                            'value' => $model->attach ? $model->attach->getImg('36x36') : null,
                            'format' => 'image'

                        ],
                        'intro:raw',
                        'unit',
                        'price',
                        'num',
                        'created_at:date',
                        'updated_at:date',
                    ],
                ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->


        <div class="row">
            <div class="col-xs-10 goods-view">
                <table class="table table-striped table-bordered detail-view">
                    <?php foreach ($av as $k => $v): ?>
                        <tr>
                            <th width="20%"><?=$v['name']?></td>
                            <td><?=$v['val']?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <div class="col-xs-10 goods-view">
                <table class="table table-striped table-bordered detail-view">
                    <tr>
                        <th width="20%">其它图片</td>
                        <td>
                        <?php foreach ($imgs as $k => $v): ?>
                            <img src="<?=$v['url']?>">
                        <?php endforeach ?>
                        </td>
                    </tr>
                </table>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>