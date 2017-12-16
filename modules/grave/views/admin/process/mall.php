<?php
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\modules\grave\models\Ins;
use app\assets\ExtAsset;
use app\assets\PluploaduiAssets;
use app\core\models\Attachment;
use kartik\select2\Select2;

\app\assets\ExtAsset::register($this);
\app\assets\JqueryuiAsset::register($this);
\app\assets\MustacheAsset::register($this);
$this->registerJsFile("@web/static/site/shop/admin/shop.min.js");
?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-sm-6">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a data-toggle="tab" href="#goods-list-box">全部</a></li>
                    <li class=""><a data-toggle="tab" href="#bag-list-box">礼包</a></li>
                </ul>

                <div class="tab-content" style="height:800px;overflow:auto">
                    <div role="tabpanel" id="goods-list-box" class="tab-pane in active">
                        <table class="table table-goods">
                            <tr>
                                <th style="width:37px;">图片</th>
                                <th>商品名称</th>
                                <th>规格选择</th>
                                <th>价格</th>
                                <th>选择</th>
                            </tr>
                            <?php foreach($goods as $key=>$val):?>
                                <?php foreach($val as $g):?>
                                    <?php $sku_cnt = count($g->sku);?>
                                    <tr class="goods-tr g<?=$g->id?>"
                                        data-pinyin="<?=$g->pinyin?>"
                                        data-serial="<?=$g->serial?>"
                                        data-title="<?=$g->name?>"
                                        data-id="<?=$g->id?>"
                                        data-price="<?=$g->price?>"
                                        data-img="<?=$g->getThumb('110x110')?>"
                                    >
                                        <td>
                                            <img class="img-rounded" width="35" height="35"
                                                 src="<?=$g->getThumb()?>" />
                                        </td>
                                        <td>
                                            <a target="_blank" title="{$goods.title}" href="#"><?=$g->name?> </a>



                                            <?php if($g->unit):?>
                                                [<?=$g->unit?>]
                                            <?php endif;?>
                                        </td>
                                        <td>
                                            <?php if ($sku_cnt > 1): ?>
                                                <p>
                                                    <select name="sku_id" class="form-control sku sku_id" style="max-width:120px;">
                                                        <?php foreach ($g->sku as $k => $sku): ?>
                                                            <option value="<?=$sku->id?>" data-price="<?=$sku->price?>">
                                                                <?=$sku->name?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </p>
                                            <?php else: ?>
                                                <input name="sku_id" type="hidden" value="<?=$g->sku[0]->id?>" class="sku_id"
                                                       sku-name="<?=$g->sku[0]->name?>" data-price="<?=$g->price?>"/>
                                            <?php endif ?>
                                        </td>
                                        <td><?=$g->price?>元</td>
                                        <td width=100>
                                            <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-danger btn-minus" type="button">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </span>
                                                <input data-type="goods"
                                                       data-id="<?=$g->id?>"
                                                       data-title="<?=$g->name?>"
                                                       data-price="<?=$g->price?>"
                                                       class="form-control gnum" name="value" type="text"
                                                       style="padding:4px 3px;width:50px"
                                                       value="0" />
                                                <span class="input-group-btn">
                                                <button class="btn btn-success btn-plus" type="button">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                            </div><!-- /input-group -->
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endforeach;?>

                        </table>
                    </div>
                    <div id="bag-list-box" class="tab-pane in" >

                        <table class="table table-goods">
                            <tr>
                                <th style="width:37px;">图片</th>
                                <th>商品名称</th>
                                <th>数量</th>
                                <th>价格</th>
                                <th>选择</th>
                            </tr>
                            <?php foreach($bags as $g):?>
                                <tr class="goods-tr"
                                    data-title="<?=$g->title?>"
                                    data-id="<?=$g->id?>"
                                    data-price="<?=$g->price?>"
                                    data-img="<?=$g->getThumb('110x110')?>"
                                >
                                    <td>
                                        <img class="img-rounded" width="35" height="35"
                                             src="<?=$g->getThumb()?>" />
                                    </td>
                                    <td>
                                        <a href="#" target="_blank"><?=$g->title?> [套]</a>
                                    </td>
                                    <td></td>
                                    <td><?=$g->price?>元</td>
                                    <td width=100>
                                        <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger btn-minus" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </span>
                                            <input data-type="bag"
                                                   data-id="<?=$g->id?>"
                                                   data-title="<?=$g->title?>"
                                                   data-price="<?=$g->price?>"
                                                   class="form-control gnum" name="value" type="text"
                                                   style="padding:4px 3px;width:50px"
                                                   value="0" />
                                            <span class="input-group-btn">
                                            <button class="btn btn-success btn-plus" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </table>

                    </div>
                </div>
                <div class="pull-right" style="position:absolute;top:0px;right:15px;">
                    <input id="py_search" size="35" type="text" name="py" placeholder="拼音、编号、商品名模糊查询" />
                </div>
            </div>

            <div class="col-sm-6" id="use-info">
                <div class="row">
                    <div class="col-xs-12" id="order-list">
                        <div class="" id="goods-selected-box" style="border:1px solid #ccc;">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>商品</th>
                                    <th>数量</th>
                                    <th>价格</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="selected-item-box">
                                <tr>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-12" id="user-info">

                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="smaller">
                                    商品信息
                                </h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <form method="post" action="<?=\yii\helpers\Url::toRoute('/grave/admin/mall/order')?>" class="form-horizontal" role="form">
                                        <input type="hidden" name="op_id" value="<?=$guide_id?>">

                                        <div class="form-group">
                                            <label class="col-xs-2 label-control">使用时间</label>
                                            <div class="col-xs-6">
                                                <input type="text"
                                                       dt=true
                                                       class="form-control input-sm use_time"
                                                       name="use_time" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-2 label-control">备注</label>
                                            <div class="col-xs-8">
                                                <textarea name="des" rows="4" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-2 label-control">订单总价</label>
                                            <div class="col-xs-4">
                                                <input type="text" id="total-price"
                                                       class="form-control input-sm" name="total_price" value="" readonly />
                                            </div>
                                        </div>

                                        <input type="hidden" class="goods_info" name="goods_info" value="" />
                                        <input type="hidden" class="bag_info" name="bag_info" value="" />
                                        <input type="hidden" class="tomb_id" name="tomb_id" value="<?=$tomb_id?>" />
                                        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

                                        <div class="form-group">
                                            <label class="col-xs-2 label-control"></label>
                                            <div class="col-xs-4">
                                                <button class="btn btn-primary btn-sm" id="submitOrder" type="submit">提交订单</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <?=$this->render('_order', ['order'=>$order]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.page-content-area -->
</div>
<input type="hidden" value="<?=Url::toRoute(['/grave/admin/tomb/info'])?>" class="uri">
<style type="text/css" media="screen">
    table.table-goods td{
        vertical-align: middle!important;
    }
    .form-inline .form-group{
        /*margin-bottom: 10px;*/
    }
    .selectize-control{
        display: inline-block;
    }

    .selectize-input {
        border: 1px solid #d0d0d0;
        padding: 3px 8px;
        width: 10em;
        overflow: visible;
        border-radius:0;
    }
</style>
<script id="template" type="x-tmpl-mustache">
<tr class="gtr{{sku_id}} btr{{id}}" style="border-bottom:1px solid #eee;">
    <td><strong>{{ title }} {{sku_name}}</strong></li>
    <td><code>{{ num }}个</code></td>
    <td><span class="text-primary">¥{{ price }}/{{ totalPrice }}</span></td>
    <td><a class="del-goods btn btn-xs btn-danger" data-id="{{ sku_id }}" href="#">删除</a></td>
</tr>
</script>











