<?php 
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;
use app\core\helpers\Html;
use app\core\helpers\Url;

use kartik\select2\Select2;

use app\assets\ExtAsset;

ExtAsset::register($this);

?>

<style type="text/css">
	.form-inline .form-group, .navbar-form .form-group{
		margin-bottom: 10px;
	}
</style>

<div class="tomb-search">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'grave_id')->dropDownList( Grave::selTree(['is_leaf'=>1], 0, ''), ['class'=>'sel-ize selg'])->label(false) ?>

    <?= $form->field($model, 'row')->textInput(['class'=>'form-control srow', 'placeholder'=>'排'])->label(false) ?>

    <?= $form->field($model, 'col')->textInput(['class'=>'form-control scol', 'placeholder'=>'号'])->label(false) ?>

    <div class="form-group">
    	<div class="col-md-10">
    		<button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> 预定</button>
	    	<button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> 办理业务</button>
	        <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> 续费</button>

	        <button class="btn btn-primary btn-sm bsearch" type="submit"><i class="fa fa-search"></i> 查找</button>
	        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index']),['class'=>'btn btn-danger btn-sm']);?>
    	</div>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="tfram"></div>

</div>




<?php $this->beginBlock('cate') ?>  
$(function(){



$('.btn').click(function(){
    alert(1);
});

    $(".srow, .scol, scus").blur(function(e){
        e.preventDefault();

        if ($('.grave_id').val() != '') {
            $('.bsearch').trigger('click');
        }
        
    });
    
    $('.bsearch').click(function(e){
        e.preventDefault();
        var da = $(this).closest('form').serialize();
        var grave_id = $('.grave_id').val();

        $('.tfram').load("<?=Url::toRoute(['list'])?>?grave_id="+ grave_id + '&' + da);

    });
    $(document).on('change', '.selg', function(e){
        e.preventDefault();

        var grave_id = $(this).val();
        var that = this;

        if (grave_id == 0) {
            return;
        }

        getData("<?=Url::toRoute(['/grave/admin/tomb/list'])?>?grave_id=" + grave_id);
        return ;


        $.get("<?=Url::toRoute(['sel-grave'])?>?grave_id=" + grave_id, {}, function(xhr){
            if (xhr.status) {
                data = xhr.data;
                options = '<option value="">--请选择墓区--</option>';
                for (grave in data) {
                    options += '<option value="'+data[grave].id+'" leaf="'+data[grave].is_leaf+'">'+data[grave].name+'</option>';
                }
                var sel = '<div class="form-group">' +
                            '<select class="form-control input-sm sel-ize selg">' +
                            options +
                            '</select>' +
                            '</div>';
                $(that).closest('.selgroup').append(sel);
            }
        },'json')

    })

})  

function getData(url)
{
    $('.tfram').load(url);
}
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  