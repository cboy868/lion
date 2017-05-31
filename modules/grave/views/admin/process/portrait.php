<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\core\helpers\Url;
use app\core\models\Attachment;

use app\assets\ExtAsset;
ExtAsset::register($this);

use app\assets\PluploadAssets;
PluploadAssets::register($this);
?>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->
        
         <?=\app\core\widgets\Alert::widget();?>
        
        <?php 
            $form = ActiveForm::begin();
            $form->fieldConfig['labelOptions']['class']='control-label col-sm-2';
            $form->fieldConfig['template'] = '{label}<div class="col-sm-10">{input}{hint}{error}</div>'; 
        ?>
        <div class="row">
            
                <div class="col-xs-12 address-index">
                        <div class="row">
                        <?php if ($models): ?>
                        <?php foreach ($models as $index => $model): ?>
                            <?php 
                                $sku = $model->getSkuInfo();
                                $model->dead_ids = explode(',', $model->dead_ids);
                             ?>
                            <div class="col-md-6 portrait-box">
                                <div class="panel panel-info">
                                    <div class="dHandler panel-heading" style="padding: 5px 10px;">瓷像信息
                                        <small>

                                        </small>

                                        <?php if ($model->status< \app\modules\grave\models\Portrait::STATUS_MAKE): ?>
                                        <div class="pull-right">
                                            <a href="<?=Url::toRoute(['/grave/admin/portrait/del'])?>" class=" btn btn-default btn-xs pdel" target="_blank" data-id="<?=$model->id?>">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                        <?php endif;?>

                                    </div>
                                  <div class="panel-body">
                                    
                                    <div class="row" style="height:100px">
                                        <div class="col-md-8">
                                            <div style="float:left;margin-right:10px;">
                                                <img class="img-rounded" style="float:left;max-height: 100px;max-width: 100px;" src="<?=$sku->goods->getThumb('100x100')?>">
                                            </div>

                                            <p>
                                              瓷像名: <?=$sku->goods->name.$sku->name;?>
                                              属性: 
                                              <?php foreach ($sku->goods->getAv()['attr'] as $k => $av): ?>
                                                    <?=$av['attr_name'] ?> : <?=$av['attr_val']?$av['attr_val']:$av['value']?>,
                                                <?php endforeach ?>
                                            </p>
                                          
                                          <div class="hr hr-18 dotted hr-double" style="clear:both;"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div style="float:right;margin-right:10px;">
                                                <a href="javascript:;" id="filePicker-<?=$index?>" 
                                                    class="thumbnail filelist-<?=$index?> filePicker" 
                                                    style="max-width:380px;max-height:280px;" 
                                                    rid="<?=$model->id?>"
                                                    data-url="<?=Url::toRoute(["pl-upload"])?>" 
                                                    data-res_name="portrait"
                                                    data-use="original">
                                                      <img src="<?=Attachment::getById($model->photo_original, '380x265', '/static/images/up.png')?>"  style="max-height: 100px;max-width: 100px;">
                                                      <?= $form->field($model, "[$index]photo_original")->hiddenInput(['class'=>'portrait-img', 'value'=>$model->photo_original])->label(false) ?>
                                                </a>
                                            </div>
                                            <div class="hr hr-18 dotted hr-double" style="clear:both;"></div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-12">
                                            <?= $form->field($model, "[$index]dead_ids")->checkBoxList($dead, ['style'=>'width:50%'])->label('使用人选择') ?>
                                            <?= $form->field($model, "[$index]use_at")->textInput(['style'=>'width:150px;', 'dt'=>'true']) ?>
                                            <?= $form->field($model, "[$index]note")->textArea() ?>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                        <?php else: ?>

                        <div class="col-md-12">
                            <?php
                            $portrait = Yii::$app->params['goods']['cate']['portrait'];
                            ?>
                            <div class="alert alert-success" role="alert" style="height: 100px; text-align: center; font-size: 40px;">
                            请
                            <small>
                                <a href="<?=Url::toRoute(['/grave/admin/mall/index','category_id'=>$portrait, 'tomb_id'=>Yii::$app->request->get('tomb_id')])?>" class="modalAddButton btn btn-info" target="_blank" data-loading-text="页面加载中, 请稍后..." onclick="return false">
                                    先订购瓷像
                                </a>
                             </small>
                            </div>
                        </div>
                           

                        <?php endif ?>  

                        </div>

                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->
            
        </div><!-- /.row -->
        <div class="form-group">
            <div class="col-sm-12" style="text-align:center;">
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <?=$this->render('_order', ['order'=>$order]) ?>
    </div><!-- /.page-content-area -->
</div>


<?php $this->beginBlock('up') ?>

$(function(){

    var csrf = '<?=Yii::$app->request->getCsrfToken()?>';
    $('.pdel').click(function(e){
        e.preventDefault();
        if (!confirm('确定要删除此瓷像吗？')) return false;

        var id = $(this).data('id');
        var url = $(this).attr('href');
        var that = this;
        $.post(url, {id:id,_csrf:csrf},function(xhr){
            if (xhr.status) {
                $(that).closest('.portrait-box').remove();
            } else {
                alert(xhr.info);
            }

        },'json');
    });
})


<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?>




