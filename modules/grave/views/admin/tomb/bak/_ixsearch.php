<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\helpers\ArrayHelper;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;
use app\assets\ExtAsset;
use kartik\select2\Select2;

ExtAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\TombSearch */
/* @var $form yii\widgets\ActiveForm */
\app\assets\JqueryUiAsset::register($this);
?>

<style type="text/css">
   /* .selgroup select{
        font-size: 15px;
        font-weight: 800;
        height: 36px;
        line-height: 30px;
        margin-right: 10px;
    }*/
    .sel-ize{
        width:200px;
    }
    .form-inline .form-control.srow, .form-inline .form-control.scol{
        width:80px;
    }
    .selgroup .form-group{
        display: block;
        width: 50%;
    }
</style>
<div class="tomb-search">

    <?php $form = ActiveForm::searchBegin(); 
        // $form->action = Url::toRoute(['list']);

    ?>

    <?php 
        $gs = Grave::find()->where(['<>', 'status', Grave::STATUS_DELETE])
                           ->andWhere(['is_leaf'=>1])
                           ->asArray()
                           ->all();
        $sel = ArrayHelper::map($gs, 'id', 'name');

     ?>
        <div class="selgroup" style="margin-bottom:20px;">
        <?php 
echo $form->field($model, 'grave_id')->widget(Select2::classname(), [
    'data' => $sel,
    'options' => [
        'placeholder' => '选择墓区...',
        'class' => 'selg'
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false);

     ?>

        </div>
        

    <?= $form->field($model, 'row')->textInput(['class'=>'form-control srow']) ?>

    <?= $form->field($model, 'col')->textInput(['class'=>'form-control scol']) ?>

    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'customer_id')->textInput(['class'=>'form-control scus']) ?>

    <div class="form-group">
        <button class="btn btn-primary btn-sm bsearch" type="submit"><i class="fa fa-search"></i> 查找</button>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php $this->beginBlock('cate') ?>  
$(function(){

    var gid = "<?=Yii::$app->request->get('grave_id')?>";
    if (!isNaN(gid)) {
        var da = $('form').serialize();
        getData("<?=Url::toRoute(['ixlist'])?>?grave_id="+ gid + '&' + da);
    }

    $(".srow, .scol, scus").blur(function(e){
        e.preventDefault();
        if ($('.selg').val() != '') {
            $('.bsearch').trigger('click');
        }
    });
    
    $('.bsearch').click(function(e){
        e.preventDefault();
        var da = $(this).closest('form').serialize();
        var grave_id = $('.selg').val();

        $('.tfram').load("<?=Url::toRoute(['ixlist'])?>?grave_id="+ grave_id + '&' + da);

    });
    $(document).on('change', '.selg', function(e){
        e.preventDefault();

        var grave_id = $(this).val();
        var that = this;

        getData("<?=Url::toRoute(['ixlist'])?>?grave_id=" + grave_id);
    })

})  

function getData(url)
{
    $('.tfram').load(url);
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  
