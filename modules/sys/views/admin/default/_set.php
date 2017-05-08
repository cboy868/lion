<?php
use yii\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\sys\models\Set;
/* @var $this yii\web\View */
/* @var $model sys\models\SysInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-info-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); 
        $form->fieldConfig=[
            'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>',
            'labelOptions' => [
                'class' => 'control-label col-sm-2'
            ],
        ];
    ?>

    <div role="tabpanel">
                  <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <?php $i=1; foreach ($settings as $k => $set):?>
        <li role="presentation" class="<?php if($i==1):?>active<?php endif;?>"><a href="#<?=$k?>" aria-controls="<?=Set::getModule($k)?>" role="tab" data-toggle="tab"><?=Set::getModule($k)?></a></li>
        <?php $i++;endforeach;?>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
         <div style="margin-top:20px;"></div>
        <?php $i=1; foreach ($settings as $ke => $set):?>
            <div role="tabpanel" class="tab-pane <?php if($i==1):?>active<?php endif;?>" id="<?=$ke?>">
                <div class="col-xs-12 sys-info-set">
                    <?php foreach ($set as $k => $model):?>
                    <?php 
                    if($model->stype == Set::TYPE_INPUT)
                    	echo $form->field($model, "[$model->sname]svalue")->textInput()->label($model->sintro)->hint('&lt?=g("'.$model->sname.'")?&gt');
                    elseif($model->stype == Set::TYPE_TEXTAREA)
                        echo $form->field($model, "[$model->sname]svalue")->textarea(['rows' => 6])->label($model->sintro)->hint('&lt?=g("'.$model->sname.'")?&gt');
                    elseif($model->stype == Set::TYPE_SELECT)
                        echo $form->field($model, "[$model->sname]svalue")->dropDownList(unserialize($model->svalues))->label($model->sintro)->hint('&lt?=g("'.$model->sname.'")?&gt');
                    elseif($model->stype == Set::TYPE_CHECKBOX)
                        echo $form->field($model, "[$model->sname]svalue")
                            ->checkboxList(unserialize($model->svalues))
                            ->label($model->sintro)
                            ->hint('&lt?=g("'.$model->sname.'")?&gt');
                    elseif($model->stype == Set::TYPE_RADIO)
                        echo $form->field($model, "[$model->sname]svalue")
                                    ->radioList(unserialize($model->svalues))
                                    ->label($model->sintro)
                                    ->hint('&lt?=g("'.$model->sname.'")?&gt');
                    elseif($model->stype == Set::TYPE_FILE) {

                         $str = <<<'STR'
                         <div class="form-group field-set-keywords-svalue">
 <label class="control-label col-sm-2" for="set-keywords-svalue">原%s</label>
 <div class="col-sm-9"><img src="%s" alt="" style="max-width:200px;max-height:100px;"></div>
 </div>
STR;

                         $str = sprintf($str, $model->sname, $model->svalue);
                        echo $str;
                        echo $form->field($model, "[$model->sname]svalue")
                                    ->fileInput()
                                    ->label($model->sintro)
                                    ->hint('&lt?=g("'.$model->sname.'")?&gt');
                    }
                        
                    ?>
                    <?php endforeach;?>
                    <div class="hr hr-18 dotted hr-double"></div>
                </div>
            </div>
        <?php $i++; endforeach;?>

        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-3">
                <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
        <div style="clear:both;"></div>
      </div>

    
        

    </div>

    <?php ActiveForm::end(); ?>
</div>
