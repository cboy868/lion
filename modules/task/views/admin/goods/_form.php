<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\task\models\Info;
use app\core\helpers\ArrayHelper;
use app\modules\task\models\Goods;
use app\modules\shop\models\Category;
use app\modules\shop\models\Goods as ShopGoods;

app\assets\TagAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'info_id')->dropDownList(ArrayHelper::map(Info::find()->where(['status'=>Info::STATUS_NORMAL])->all(), 'id', 'name')) ?>
    <?= $form->field($model, 'trigger')->radioList(Goods::trig()) ?>
    <?= $form->field($model, 'msg_type')->checkBoxList(Goods::msgType())->hint('消息提醒类型，可多选') ?>

    <?= $form->field($model, 'msg')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'msg_time')->textarea(['rows' => 6, 'id'=>'inputTagator'])->hint('1马上, 0当天，-1提前1天,-2提前2天以此类推,多个提醒请用逗号分隔') ?>

     <?= $form->field($model, 'res_name')->radioList(Goods::res(), ['class'=>'rname']) ?>
    <?= $form->field($model, 'res_id[category]')->checkBoxList(ArrayHelper::map(Category::find()->where(['status'=>Category::STATUS_NORMAL])->all(), 'id', 'name'), ['class'=>'category'])->label('选择分类') ?>
    <?= $form->field($model, 'res_id[goods]')->checkBoxList(ArrayHelper::map(ShopGoods::find()->where(['status'=>Category::STATUS_NORMAL])->orderBy('category_id asc')->all(), 'id', 'name'), ['class'=>'goods'])->label('选择商品') ?>

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
    
    change();

    var cg = $('.rname input');
    cg.change(function(){
        change();
    });
});
function change()
{
    var val = $('.rname input:checked').val();
    $('.category, .goods').closest('.form-group').hide();
    $('.' + val).closest('.form-group').show();
}


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
