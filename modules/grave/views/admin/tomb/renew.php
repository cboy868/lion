<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use app\core\helpers\ArrayHelper;
use yii\bootstrap\Modal;

\app\assets\ExtAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\TombSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '续维护费';
$this->params['breadcrumbs'][] = ['label' => '墓位管理', 'url' => ['/grave/admin/tomb/index']];
$this->params['breadcrumbs'][] = $this->title . '【'.$model->tomb_no.'】';


?>
<div class="page-content">
  <div class="page-header">
    <h1><?=$model->tomb_no?> <small>
    <a href="<?=Url::toRoute(['/grave/admin/tomb/view', 'id'=>$model->id])?>" target="_blank">一墓一档</a>
    </small></h1>
  </div>
        <?php 
            Modal::begin([
                'header' => '新增',
                'id' => 'modalAdd',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="modalContent"></div>';

            Modal::end();
        ?>

        <?php 
            Modal::begin([
                'header' => '编辑',
                'id' => 'modalEdit',
                // 'size' => 'modal'
            ]) ;

            echo '<div id="editContent"></div>';

            Modal::end();
        ?>
  <div class="row">
    <div class="col-sm-6" id="goods-list">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a data-toggle="tab" href="#id-all">全部</a></li>
            </ul>

            <div class="tab-content" style="height:120px;overflow:auto">
                <div id="id-all" class="tab-pane in active">
                    <table class="table table-goods">
                       <tbody><tr>
                         <th>商品名称</th>
                         <th>时长</th>
                         <th>价格</th>
                         <th>选择</th>
                       </tr>
                         <tr class="goods-tr">
                              <td><?=$ginfo->name?></td>
                              <td>20年</td>
                              <td><?=$ginfo->price?>元</td>
                              <td width="150">

                              	<div class="text-right gbtn">
			                        <div class="input-group">
			                            <span class="input-group-btn">
			                            <button class="btn btn-info btn-min" type="button"><span class="fa fa-minus"></span></button>
			                          </span>
			                          <input type="text" class="form-control gnum" value="0">
			                          <span class="input-group-btn">
			                            <button class="btn btn-danger btn-add" type="button"><span class="fa fa-plus"></span></button>
			                          </span>
			                        </div><!-- /input-group -->
			                    </div>

                              </td>
                            </tr>
                    </tbody></table>
                </div>
            </div>
			
			<?php if ($model->card): ?>
			<div class="widget-box">
                <div class="widget-header">
                    <h4 class="smaller">
                        已付款年限
          				<input readonly="true" type="text" class="right" value="<?=$model->card->start?> - <?=$model->card->end?>" style="width:200px;">
          				<input type="hidden" class="cend" data-end="<?=$model->card->end?>" data-price="<?=$ginfo->price?>">
          				<?php if ($model->card): ?>
	                    <?=  Html::a('<i class="fa fa-edit"></i> 编辑', ['/grave/admin/card/update','id'=>$model->id], ['class'=>'btn btn-primary btn-xs modalEditButton',"onclick"=>"return false"]) ?>
	                    <?php endif ?>
	                    <?=  Html::a('<i class="fa fa-plus"></i> 新增', ['/grave/admin/card/create','id'=>$model->id], ['class'=>'btn btn-primary btn-xs modalAddButton',"onclick"=>"return false"]) ?>
                    </h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <table class="table">
                          <thead>
                          <tr>
                            <th>年限</th>
                            <th>价格</th>
                            <th width="150">添加时间</th>
                            <th></th>
                          </tr>
                          </thead>
                          <tbody id="order-detail">
                          	<?php foreach ($model->card->rels as $k => $v): ?>
                          		<tr data-id="" data-type="" id="goods-detail-tpl">
                                    <td class=""><?=$v->start?> - <?=$v->end?></td>
                                    <td class=""><?=$v->price?></td>
                                    <td><?=date('Y-m-d H:i', $v->created_at)?></td>
                                    <td>
                                    <a href="<?=Url::toRoute(['/grave/admin/card-rel/delete', 'id'=>$v->id])?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>  
                          	<?php endforeach ?>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>  
            <?php endif ?>          
        </div>
    </div>
    <div class="col-sm-6" id="use-info">
        <div class="row">
            <div class="col-xs-12" id="order-list">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="smaller">
                                订单详情
                            </h4>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <table class="table">
                                  <thead>
                                  <tr>
                                    <th>时长</th>
                                    <th>数量</th>
                                    <th>总价</th>
                                    <th></th>
                                  </tr>
                                  </thead>
                                  <tbody id="order-detail">
                                    <tr data-id="" data-type="" id="dorder" style="display:none;">
                                        <td class="g-time"></td>
                                        <td class="g-num"></td>
                                        <td class="g-price">0</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-xs-12" id="user-info">

                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="smaller">
                            用户信息
                        </h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                    <form method="post" class="form-horizontal" role="form">
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
                        <div class="form-group">
                             <label class="col-xs-2 label-control">墓位号</label>
                             <div class="col-xs-6">
                             	<?=$model->tomb_no?>
                             </div>
                        </div>
                        <div class="form-group">
                             <label class="col-xs-2 label-control">客户</label>
                             <div class="col-xs-6">
                             		<?=$model->customer->name?>
                             </div>
                        </div>
                        <div class="form-group">
                             <label class="col-xs-2 label-control">手机号码</label>
                             <div class="col-xs-6">
                             <?=$model->customer->mobile?>
                             </div>
                        </div>
                        
                         <div class="form-group">
                             <label class="col-xs-2 label-control">年限</label>
                             <div class="col-xs-6">
                                 <input type="text" class="form-control input-sm" name="year_num" value="" readonly="true">
                             </div>
                        </div>
                                                                        
                         <div class="form-group">
                             <label class="col-xs-2 label-control">价格</label>
                             <div class="col-xs-6">
                                 <input type="text" class="form-control input-sm" name="price" value="" disabled="">
                             </div>
                        </div>
                        <input type="hidden" name="num" class="num">
                        
                        <div class="form-group">
                             <label class="col-xs-2 label-control">备注</label>
                             <div class="col-xs-8">
                                 <textarea name="des" rows="4" class="form-control"></textarea>
                             </div>
                        </div>
                        <input type="hidden" name="tomb_id" value="<?=$model->id?>">
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
        </div>
    </div>
  </div>
</div>
</div>




<?php $this->beginBlock('foo') ?>  
 $(function(){
 	var item = $('.gbtn')
 	upOrder();
 	$('.btn-add').click(function(e){
 		e.preventDefault();
 		var num = item.find('.gnum').val();
 		item.find('.gnum').val(parseInt(num)+1);

 		upOrder();
 	});

 	$('.btn-min').click(function(e){
 		e.preventDefault();
 		var num = item.find('.gnum').val();
 		if (num >= 1) {
 			item.find('.gnum').val(parseInt(num)-1);
 		} else {
 			item.find('.gnum').val(0);
 		}

 		upOrder();
 	});

 	function upOrder()
 	{
 		var num = item.find('.gnum').val();
 		if (num > 0) {
 			$('#dorder').show();
 		} else {
 			$('#dorder').hide();
 			return;
 		}
 		var years = 20 * parseInt(num);
 		var uprice = $('.cend').data('price');
 		var total = parseFloat(uprice) * num;
 		var start = $('.cend').data('end');

 		$('.g-time').text(years);
 		$('.g-num').text(num);
 		$('.g-price').text(total);
 		$('.num').val(num);

 		if (!start) {
 			alert('墓证年限出错，请修改');
 			return;
 		}
 		var year = start.substring(0,4);
 		var year_md = start.substring(4,10);
 		$("input[name='year_num']").val(start+' - '+(parseInt(year)+num*20)+year_md);
 		$('input[name=price]').val(total);


 	}

 })

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  