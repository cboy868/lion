<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\shop\models\Category;
USE app\core\widgets\Ueditor;
use app\core\widgets\Webup\Webup;
use app\core\helpers\Url;
use app\assets\SelectAsset;

use app\assets\ExtAsset;
ExtAsset::register($this);

// SelectAsset::register($this);
\app\assets\TagAsset::register($this);
// \wdteam\webuploader\Webuploader::widget(); 
// PluploaduiAssets::register($this);
?>
<style type="text/css">
.pic div.thumbnail.active{
border-color:#337ab7;
}
.thumbnail {
    border: 3px solid #ccc;
    }
</style>
<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->hiddenInput(['value'=>Yii::$app->getRequest()->get('category_id')])->label(false)?>

    <?= $form->field($model, 'serial')->textInput()->label()->hint('序列号如不填写，则自动生成')?>

    <?= $form->field($model,'intro')->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'goods', 'use'=>'ue'] ]);?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tags')->textInput(['id'=>'inputTagator', 'value'=>$tags])->hint('多关键词，请用半角逗号分隔') ?>

    <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'skill')->textArea(['maxlength' => true])->label('附加') ?>

    <?php if (isset($imgs)): ?>
     <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">已上传图片</h3>
      </div>

          <div class="panel-body row">
            <?php foreach ($imgs as $img): ?>
                <div class="col-xs-3 col-md-2 pic" >
                    <div href="#" class="thumbnail <?php if ($model->thumb == $img['id']): ?>active<?php endif ?>">
                      <img src="<?=$img['url']?>" alt="<?=$img['title']?>" rid="<?=$img['id']?>">
                      <a class="btn btn-danger btn-sm del" href="<?=Url::toRoute(['del-img'])?>"><span class="fa fa-trash"></span></a>
                      <a class="btn btn-success btn-sm cover"><span class="fa fa-flag"></span>封面</a>
                    </div>
                  </div>
            <?php endforeach ?>

          </div>
        </div>
      <?php endif ?>


    <div class="form-group field-goods-pic required">
        <!-- <label class="control-label" for="goods-pic">图片集</label> -->
        <?php echo Webup::widget(['options'=>['res_name'=>'goods', 'id'=>'goods']]);?>
        <div class="help-block"></div>
    </div>
            <?php if ($attrs): ?>

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">属性</h3>
                  </div>

                  <div class="panel-body row form-group">
                    
                        <?php foreach ($attrs as $k => $attr): ?>
                            <div class="col-md-5">
                            <?php if ($attr->is_multi == 2): ?>
                                <?php $ats = $model->getAv(); ?>
                                <label class="control-label"><?=$attr->name?></label>
                                    <input name="AvRel[<?=$attr->id?>]" class="form-control " value="<?=$ats['attr'][$attr->id]['value']?>">
                            <?php else: ?>
                                <label class="control-label"><?=$attr->name?></label>
                                    <select id="lunch" name="AvRel[<?=$attr->id?>]" class="sel-ize" title="<?=$attr->name?>">
                                        <?php foreach ($attr->vals as $val): ?>
                                            <option value="<?=$val->id?>" 
                                            <?php if (isset($attr_sels[$attr['id']]) && in_array($val->id, $attr_sels[$attr['id']])){echo "selected=selected";} ?>>
                                            <?=$val->val?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                            <?php endif ?>
                            </div>

                        <?php endforeach ?>

                  </div>
                </div>
            <?php endif ?>

            <?php if ($specs): ?>
                <div class="form-group field-goods-intro">
                    <label class="control-label" for="goods-name">规格</label>
                    <?php foreach ($specs as $k => $spec): ?>
                        <div class="form-group spec-control field-avrel-<?=$spec->id?>-av_id">
                            <label class="control-label spec-label col-sm-1" for="avrel-<?=$spec->id?>-av_id"><?=$spec->name?></label>
                            <div class="col-sm-11">
                                
                                <strong style="color:green">  </strong>
                                <?php foreach ($spec->vals as $ke => $va): ?>
                                        <label id="avrel-<?=$spec->id?>-av_id">
                                        <input type="checkbox" data-text="<?=$va->val?>" 
                                        data-attr="<?=$spec['id']?>" name="AvRel[<?=$spec->id?>][]" 
                                        value="<?=$va->id?>" 
                                        <?php if (isset($attr_sels[$spec['id']]) && in_array($va->id, $attr_sels[$spec['id']])){echo "checked";} ?>
                                        class="sel-spec"> <?=$va->val?>
                                        </label>
                                <?php endforeach ?>
                                    
                                <div class="help-block">
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>



            <?php if ($tables['data']): ?>
            <div class="form-group">
                <label class="control-label" for="avrel-intro">相应规格价格增量填写</label>
                <div >
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <?php foreach ($tables['labels'] as $v): ?>
                                    <td><?=$specs[$v]->name?></td>
                                <?php endforeach ?>
                                <td>价格</td>
                                <td>数量</td>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($tables['data'] as $k => $spec): ?>
                        <?php 
                            $sku_key = '';
                            foreach ($spec as $v) {
                                $sku_key .= $v['attr_id'] . ':' . $v['id'] .';';
                            }
                            $k = trim($sku_key,';');
                        ?>
                            <tr sku-key="<?=$sku_key?>" sku-tmp="<?=$sku_key?>" class="hide">
                                <?php foreach ($spec as $v): ?>
                                    <td key="<?=$v['attr_id']?>:<?=$v['id']?>"><?=$v['val']?></td>
                                <?php endforeach ?>
                                <td><input name="sku[price][<?=$k?>]" sku-key="<?=$sku_key?>" value="<?=isset($skus[$k]['price'])?$skus[$k]['price']:0?>"/></td>
                                <td><input name="sku[num][<?=$k?>]" sku-key="<?=$sku_key?>" value="<?=isset($skus[$k]['num'])?$skus[$k]['num']:0?>"/></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
            <?php endif ?>


	<div class="form-group">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-info btn-lg', 'style'=>'margin: 20px 0;width: 200px;']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('tag') ?>  

$(function () {
    tag();
});

function tag()
{
    if ($('#inputTagator').data('tagator') === undefined) {
        $('#inputTagator').tagator({
            autocomplete: []
        });
        $('#activate_tagator').val('销毁 tagator');
    } else {
        $('#inputTagator').tagator('destroy');
        $('#activate_tagator').val('激活 tagator');
    }
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['tag'], \yii\web\View::POS_END); ?>  

<?php $this->beginBlock('spec') ?>  
      $(function(){

        spec();

        $('.sel-spec').change(function(){
            var ar = [];

            $('tbody tr').addClass('hide');
            $('tr').each(function(){
                $(this).attr('sku-tmp', $(this).attr('sku-key'));
            });

            spec();
        });

        function spec()
        {
            $('input.sel-spec:checked').each(function(){
                var attr = $(this).data('attr');
                var prop = $(this).val();
                var tmp = attr + ':' + prop;

                $('td[key="'+tmp+'"]').closest('tr').each(function(){
                    var sku_tmp = $(this).attr('sku-tmp');
                    var sku_tmp = sku_tmp.replace(tmp +';', '');
                    $(this).attr('sku-tmp', sku_tmp);


                    if (sku_tmp == ';;' || sku_tmp=='') {
                        $(this).removeClass('hide');
                    } else {
                        $(this).addClass('hide');
                    }
                });

            });
            $('tr input:hidden').val('');
        }

      })
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['spec'], \yii\web\View::POS_END); ?>  

<?php $this->beginBlock('img') ?>  
$(function(){

    $('.del').click(function(e){
        e.preventDefault();
        var that = this;
        if (!confirm('确定要删除此图片?')){
            return 
        }

        var url = $(this).attr('href');
        var thumb = $(this).siblings('img').attr('rid');
        var _csrf = $('meta[name=csrf-token]').attr('content');
        var that = this;

        $.post(url, {_csrf:_csrf, thumb:thumb}, function(xhr){
            if (xhr.status) {
                $(that).closest('.pic').fadeOut();
            } else {
                alert(xhr.info);
            }
        },'json');

    });
    $('.cover').click(function(e){
        e.preventDefault();
        var that = this;

        var url = "<?=Url::toRoute(['cover'])?>";
        var _csrf = $('meta[name=csrf-token]').attr('content');
        var goods_id = "<?=$model->id?>";
        var thumb = $(this).siblings('img').attr('rid');

        if (thumb == "<?=$model->thumb?>") {
            return ;
        }


        $.post(url, {_csrf:_csrf,goods_id:goods_id,thumb:thumb}, function(xhr){
            if (xhr.status) {
                $('.thumbnail').removeClass('active');
                $(that).closest('.thumbnail').addClass('active');
            }
        }, 'json');
    });
    
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['img'], \yii\web\View::POS_END); ?>  
