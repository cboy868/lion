<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\GridView;
use app\core\helpers\ArrayHelper;

\app\assets\ExtAsset::register($this);
\app\assets\ColorBoxAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\grave\models\TombSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '修碑文';
$this->params['breadcrumbs'][] = ['label' => '墓位管理', 'url' => ['/grave/admin/tomb/index']];
$this->params['breadcrumbs'][] = $this->title . '【'.$model->tomb_no.'】';


?>
<div class="page-content">
  <div class="page-header">
    <h1><?=$model->tomb_no?> <small>
    <a href="<?=Url::toRoute(['/grave/admin/tomb/view', 'id'=>$model->id])?>" target="_blank">一墓一档</a>
    </small></h1>
  </div>
  <div class="row">
    <div class="col-sm-6" id="goods-list">
			<?php if ($model->ins): ?>
			<div class="widget-box">
                <div class="widget-header">
                    <h4 class="smaller">
                        总字数
          				<input readonly="true" type="text" value="<?=$model->ins->big_num + $model->ins->small_num?>">
                    </h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <table class="table">
                          <thead>
                          <tr>
                            <th>正面</th>
                            <th>背面</th>
                          </tr>
                          </thead>
                          <tbody>
                          	<tr>
                               <td>
                                   <a href="<?=$model->ins->getImg('front')?>" class="artimg">
                                       <img src="<?=$model->ins->getImg('front')?>" width="80%" class="image">
                                    </a>
                               </td> 
                               <td>
                                    <a href="<?=$model->ins->getImg('back')?>" class="artimg">
                                       <img src="<?=$model->ins->getImg('back')?>" width="80%" class="image">
                                    </a>
                               </td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>  
            <?php endif ?>          
    </div>
    <div class="col-sm-6" id="use-info">
        <div class="row">
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
                             <label class="col-xs-2 label-control">请选择颜料</label>
                             <div class="col-xs-6">
                                <select class="form-control paint" name="paint">
                                    <?php foreach ($paint as $k => $v): ?>
                                        <option value="<?=$k?>" price="<?=$fee[$k]?>"><?=$v?></option>
                                    <?php endforeach ?>
                                </select>
                             </div>
                        </div>
                        
                         <div class="form-group">
                             <label class="col-xs-2 label-control">字数</label>
                             <div class="col-xs-6">
                                 <input type="text" class="form-control input-sm font-num" name="num">
                             </div>
                             <label>
                                <?php if (isset($model->ins)): ?>
                                    <input type="checkbox" name="allfont" class="allfont" data-num="<?=$model->ins->big_num+$model->ins->small_num?>" value=1> 修整碑
                                <?php endif ?>
                             </label>
                        </div>
                                                                        
                         <div class="form-group">
                             <label class="col-xs-2 label-control">总价</label>
                             <div class="col-xs-6">
                                 <input type="text" class="form-control input-sm totalprice" name="price" value="" disabled="">
                             </div>
                        </div>
                        
                        <div class="form-group">
                             <label class="col-xs-2 label-control">要修的字</label>
                             <div class="col-xs-8">
                                 <textarea name="des" rows="4" class="form-control"></textarea>
                             </div>
                        </div>

                   <!--      <div class="form-group">
                             <label class="col-xs-2 label-control">完成时间</label>
                             <div class="col-xs-8">
                                 <input type="" name="use_time", dt="true">
                             </div>
                        </div> -->
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

    $(".image").click(function(e) {
         e.preventDefault();
         var title = $(this).attr('title');
         $(".artimg").colorbox({
             rel: 'artimg',
             maxWidth:'600px',
             maxHeight:'700px',
             next:'',
             previous:'',
             close:'',
             current:""
         });
     });
    $('.allfont').change(function(){
        var num = $(this).data('num');

        if ($(this).is(':checked')) {
            $('.font-num').val(num);
        } else {
            $('.font-num').val(0);
        }
    });


    $('.font-num, .paint, .allfont').change(function(){
        var uprice = $('.paint').find("option:selected").attr('price');
        var num = $('.font-num').val();

        if (!uprice || !num) {
            return;
        }


        var total = parseFloat(uprice) * parseInt(num);
        $('.totalprice').val(total);
    });
 })

<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['foo'], \yii\web\View::POS_END); ?>  