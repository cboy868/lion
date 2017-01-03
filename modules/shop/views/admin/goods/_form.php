<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\shop\models\Category;
// use app\assets\PluploaduiAssets;
USE app\core\widgets\Ueditor;
use app\core\widgets\Webup\Webup;

use app\assets\SelectAsset;



SelectAsset::register($this);
\app\assets\TagAsset::register($this);
// \wdteam\webuploader\Webuploader::widget(); 
// PluploaduiAssets::register($this);
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->hiddenInput(['value'=>Yii::$app->getRequest()->get('category_id')])->label(false)?>

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
          <div class="panel-body">
            <?php foreach ($imgs as $img): ?>
                <div class="col-xs-3 col-md-2">
                    <a href="#" class="thumbnail">
                      <img src="<?=$img['url']?>" alt="<?=$img['title']?>" rid="<?=$img['id']?>">
                    </a>
                  </div>
            <?php endforeach ?>

          </div>
        </div>
      <?php endif ?>



    <div class="form-group field-goods-pic required">
        <label class="control-label" for="goods-pic">图片集</label>
        <?php echo Webup::widget(['options'=>['res_name'=>'goods', 'id'=>'goods']]);?>
        <div class="help-block"></div>
    </div>
            <?php if ($attrs): ?>
            <div class="form-group field-goods-intro">
                <label class="control-label" for="goods-name">属性</label>
                <div class="rows">
                    <div class="col-md-12" style="padding-right:0;padding-left:0">
                        
                    <?php foreach ($attrs as $k => $attr): ?>
                        <select id="lunch" name="AvRel[<?=$attr->id?>]" class="selectpicker" data-live-search="true" title="<?=$attr->name?>">
                            <?php foreach ($attr->vals as $val): ?>
                                <option value="<?=$val->id?>" 
                                <?php if (isset($attr_sels[$attr['id']]) && in_array($val->id, $attr_sels[$attr['id']])){echo "selected=selected";} ?>>
                                <?=$val->val?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    <?php endforeach ?>
                        
                    </div>
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
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
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
