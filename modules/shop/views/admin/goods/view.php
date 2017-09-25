<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;
use app\core\models\TagRel;
use app\core\helpers\ArrayHelper;
use app\core\models\Attachment;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\modules\shop\models\Category;
$this->params['current_menu'] = 'shop/goods/index';

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

                    <a href="<?=Url::toRoute(['create', 'category_id'=>$model->category_id])?>" class="btn btn-info btn-sm">
                        <i class="fa fa-plus"></i> 继续添加本类商品
                    </a>

                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus"></i> 继续添加商品
                    </button>

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">选择分类</h4>
                                </div>


                                <form id="w0" action="<?=Url::toRoute(['create'])?>" method="get">

                                    <?php
                                    $category = Category::find()->asArray()->all();
                                    $options = [];
                                    foreach ($category as $k => $v) {
                                        if (!$v['is_leaf']) {
                                            $options[$v['id']]['disabled'] = true;
                                        }
                                    }
                                    ?>

                                    <div class="modal-body">
                                        <?=Html::dropDownList('category_id', null, Category::selTree(), ['class'=>'form-control', 'options' => $options])?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">close</button>
                                        <button type="submit" class="btn btn-primary redcreate">OK</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


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
            'pinyin',
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