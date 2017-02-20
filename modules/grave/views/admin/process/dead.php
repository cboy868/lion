<?php 
use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Dead;
use app\core\helpers\Url;
use app\assets\ExtAsset;
// use app\assets\JqueryuiAsset;

// JqueryuiAsset::register($this);

ExtAsset::register($this);
?>

<style type="text/css">
    .help-block{
        margin:0;
    }
    .sel-ize {
        float: left;
    }
    .dt{
        display:none;
    }
    .odt{
        height:35px;
        width: 40%;
    }
</style>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
        	<?php  echo $this->render('_step'); ?>
        </div><!-- /.page-header -->

        <div class="col-xs-12">
            <?php if (Yii::$app->session->has('success')): ?>
                <div class="alert alert-success" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>恭喜!</strong> <?=Yii::$app->session->getFlash('success')?>
                </div>
            <?php endif ?>

            <?php if (Yii::$app->session->has('error')): ?>
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>提示!</strong> <?=Yii::$app->session->getFlash('error')?>
                </div>
            <?php endif ?>
        </div>
        
        <?php 
            $form = ActiveForm::begin();
            $form->fieldConfig['labelOptions']['class']='control-label col-sm-3';
            $form->fieldConfig['template'] = '{label}<div class="col-sm-8">{input}{hint}{error}</div>'; 
            $form->options['id']='dform';
        ?>
        <div class="row" id="dead-list">
            <?php foreach ($models as $index => $model): ?>
                          
                <?php $model->loadDefaultValues(); ?>
                <div class="col-lg-4 col-md-5 col-sm-6 deads" rel="<?=$model->id?>">
                    <div class="panel panel-info dead" style="min-height:480px;">
                        <div class="dhandler panel-heading">使用人信息
                            <button type="button" class="delit close" style="<?php if ($index == 0): ?>display:none;<?php endif ?>">
                               <span class="text-danger" aria-hidden="true"> <i class="fa fa-times"></i> </span>
                               <span class="sr-only">Close</span>
                            </button> 
                        </div>

                        <?= $form->field($model, "[$index]tomb_id")->hiddenInput()->label(false) ?>
                        <?= $form->field($model, "[$index]user_id")->hiddenInput()->label(false) ?>
                        <?= $form->field($model, "[$index]sort")->hiddenInput(['rel'=>'sort', 'value'=>$index])->label(false) ?>
                        
                        <table class="table table-condensed">
                            <tr class="tr_dead_name">
                                <td><?= $form->field($model, "[$index]dead_name")->textInput(['maxlength' => true]) ?></td>
                            </tr>
                           <!--  <tr>
                                <td><?= $form->field($model, "[$index]second_name")->textInput(['maxlength' => true]) ?></td>
                            </tr> -->
                            <tr class="tr_dead_title">
                            <?php 

                            if ($model->dead_title && !in_array($model->dead_title, $dead_title)) {
                                $dead_title[$model->dead_title] = $model->dead_title;
                            }

                             ?>
                                <td><?= $form->field($model, "[$index]dead_title")->dropDownList($dead_title,[
                                'class'=>'selize-rel'
                                ])->hint('如无选项 请直接输入'); ?></td>
                            </tr>
                            <tr class="tr_gender">
                                <td><?= $form->field($model, "[$index]gender")->radioList([1=>'男', 2=>'女']) ?></td>
                            </tr>
                            <tr class="tr_birth">
                                <td><?= $form->field($model, "[$index]birth")->textInput([
                                    'style'=>'width:70%', 
                                    'dt'=>'true', 
                                    'default'=>'1960-'.date('m-d'),
                                    'y-chante' => 'true',
                                    'm-change' =>'true'
                                    ]) ?></td>
                            </tr>
                            
                            <tr class="tr_is_alive">
                                <td><?= $form->field($model, "[$index]is_alive")->radioList(Dead::alive())->label('是否健在') ?></td>
                            </tr>
                            <tr class="tr_fete" style="<?php if ($model->is_alive !== 0): ?>display:none<?php endif ?>">
                                <td><?= $form->field($model, "[$index]fete")->textInput([
                                'style'=>'width:70%', 
                                'dt'=>'true',
                                'dt-year' => 'true',
                                'dt-month' =>'true'
                                ]) ?></td>
                            </tr>
                            <tr class="tr_is_ins" style="<?php if ($model->is_alive === 0): ?>display:none<?php endif ?>">
                                <td><?= $form->field($model, "[$index]is_ins")->radioList(Dead::ins())->label('是否立碑') ?></td>
                            </tr>
                            <tr class="tr_bone_type" style="<?php if ($model->is_alive !== 0): ?>display:none<?php endif ?>">
                                <td><?= $form->field($model, "[$index]bone_type")->radioList($bone_type) ?></td>
                            </tr>
                            <tr class="tr_bone_box" style="<?php if ($model->is_alive !== 0): ?>display:none<?php endif ?>">
                                <td><?= $form->field($model, "[$index]bone_box")->dropDownList($bone_box) ?></td>
                            </tr>
                        </table>

                        <div class="hr hr-18 dotted hr-double"></div>
                    </div>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div><!-- /.col -->

            <?php endforeach ?>
            
        </div><!-- /.row -->
        <div class="form-group">
            <div class="col-sm-12" style="text-align:center;">   
                <label style="color:green;"><input type="checkbox" checked="checked" name="is_memorial" value="1"/>生成纪念馆</label>
                <div style="width:100px;display: inline-block;margin: 0 20px;">
                <?php $form->fieldConfig['template'] = '{input}{hint}{error}';  ?>
                <?= $form->field($tomb, "mnt_by")->dropDownList($mnt_by, ['prompt'=>'请选择立碑人']); ?>
                    
                </div>
                <?=  Html::button('添加使用人', ['class' => 'btn btn-default btn-lg new-dead', 'style'=>'padding: 10px 36px']) ?>
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']-1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>上一步</a>
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-warning btn-lg', 'style'=>'padding: 10px 36px']) ?>
                <a href="<?=Url::toRoute(['index', 'tomb_id'=>$get['tomb_id'], 'step'=>$get['step']+1])?>" class="btn btn-info btn-lg" 'style'='padding: 10px 36px'>下一步</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <?=$this->render('_order', ['order'=>$order]) ?>
    </div><!-- /.page-content-area -->
</div>
<div class="newDead">
    
</div>
<?php $this->beginBlock('cate') ?>  
$(function(){
    var DeadForm  = $('#dform');
    var DeadList = $('#dead-list')

    var males    = ['父亲','祖父','丈夫','哥哥','弟弟','儿子','侄子','姑父','舅舅','叔叔'];
    var females  = ['母亲','祖母','妻子','姐姐','妹妹','女儿','侄女','姑姑','舅妈','阿姨'];
    var olds     = ['父亲','母亲','祖父','祖母','丈夫','妻子','姑姑','姑父','舅舅','舅妈','叔叔','阿姨'];
    var youngs   = ['哥哥','弟弟','姐姐','妹妹','女儿','儿子','侄子','侄女'];

    var getGender = function(name) {
        for (key in males) {
            if (males[key] == name) {
               return 1; 
            }
        }
        for (key in females) {
            if (females[key] == name) {
                return 0;
            }
        }
        return 1;
    };

    $('#dead-list').sortable({
        handle: "div.dhandler",

        update : function(e, ui){
            var deadBox = DeadForm.find('div.dead');
            var i=0;
            deadBox.each(function(i, item){
                $(item).find('input[rel=sort]').val(i+1);

                var dBtn = $(item).find('button.delit');
                if (i == 0) {
                    dBtn.hide();
                } else {
                    dBtn.show();     
                }
            })

        }
    });



//添加使用人
$('.new-dead').on('click', function(e){
    e.preventDefault();

    $.get('<?=Url::toRoute(['add-dead'])?>', null, function(xhr){
        location.reload();
    }, 'json');
});


$.fn.deadinfo = function() {
    $this = $(this);
    $this.each(function(index, dead){
        var $dead = $(dead);  
        var bone_type = $dead.find('tr.tr_bone_type');  
        var bone_box = $dead.find('tr.tr_bone_box');

        $dead.find('tr.tr_is_alive input').change(function(e){
            var isAlive = $(this);
            //showMemorial();
            var feteTime = $dead.find('tr.tr_fete');
            var isIns = $dead.find('tr.tr_is_ins');

            if (isAlive.val() == 0) {
                feteTime.show();
                isIns.hide();
                bone_type.show();
                bone_box.show();

            } else {
                feteTime.hide();
                isIns.show();
                bone_type.hide();
                bone_box.hide();
            }
        });


        // 逝者关系
        $dead.find('tr.tr_dead_title select').change(function(e){
            $(this).relGender();
        });

        $dead.find('tr.tr_dead_title select').relGender();

        //删除使用人 
        $dead.find('.delit').on('click', function(e){

            var that = this
            var rel = $(this).closest('.deads').attr('rel');

            $.get("<?=Url::toRoute(['del-dead', 'tomb_id'=>$get['tomb_id']])?>&dead_id="+rel, null, function(xhr){
                if (xhr.status) {
                    $(that).closest('.deads').remove();
                }
            }, 'json');
        });
    });

};

$.fn.relGender = function(){
    var gender = getGender($(this).val());
    var opGender = $(this).closest('table').find('tr.tr_gender input');
    switch (gender)
    {
        case 1:
            opGender.val(['1']);
            break;
        case 0:
            opGender.val(['2']);
            break;
        case false:
            opGender.val(['1']);
            break;
    }
}

DeadList.find('div.deads').deadinfo();
$('.selize-rel').each(function(index, item){
    var $this = $(item);
    if ( !$this.data('select-init') ) {
        $this.selectize({
            create: true
        });
    }
});
    
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  







	


	

				

