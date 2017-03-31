<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\core\models\TagRel;
use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;

/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Goods */

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
                    <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger  btn-xs',
                        'data' => [
                            'confirm' => '确定要删除吗，删除不可恢复?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-10 goods-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category.name',
            'serial',
            'name',
            [
                'label' => '关键词',
                'value' => implode(',', ArrayHelper::getColumn(TagRel::getTagsByRes('goods', $model->id), 'tag_name')),
            ],
            [
                'label' => '缩略图',
                'value' => "<img src='".Attachment::getById($model->thumb, '100x100')."'>",
                'format'=> 'raw'
            ],
            'thumb',
            'intro:raw',
            'skill:ntext',
            'unit',
            'original_price',
            'price',
            'recommend',
            'created_at:date',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>


                
            </div><!-- /.col -->

            <div class="col-xs-12">
                <table id="w1" class="table table-striped table-bordered detail-view">
                    <tbody>
                    <tr><th>属性</th><td>值</td></tr>
                    <?php foreach ($avs['attr'] as $v): ?>
                        <tr><th><?=$v['attr_name']?></th>
                        <?php if (!$v['attr_val']): ?>
                            <td><?=$v['value']?></td>
                        <?php else: ?>
                            <td><?=$v['attr_val']?></td>
                        <?php endif ?>
                        
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>

                <table id="w2" class="table table-striped table-bordered detail-view">
                    <tbody>
                    <tr><th>规格</th><td>数量</td><td>原价</td><td>现价</td> </tr>
                    <?php foreach ($sku as $v): ?>
                        <tr>
                            <th><?=$v->name?></th>
                            <td><?=$v->num?></td>
                            <td><?=$v->original_price?>
                            <td><?=$v->price?>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.row -->

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">商品图片</h3>
          </div>
          <div class="panel-body">
            
            <?php foreach ($imgs as $img): ?>
                <div class="col-xs-2 col-md-3">
                    <a href="#" class="thumbnail">
                      <img src="<?=$img['url']?>" alt="<?=$img['title']?>">
                    </a>
                  </div>
            <?php endforeach ?>

          </div>
        </div>
          
    </div><!-- /.page-content-area -->
</div>