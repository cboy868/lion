<?php

use app\core\helpers\Html;
use app\core\widgets\ActiveForm;
use app\modules\grave\models\Grave;

?>

<div class="tomb-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $form->fieldConfig = [
        'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>',
        'labelOptions' => [
            'class' => 'control-label col-sm-2'
        ]
    ];?>
    
    
    <table style="width: 800px;border: none;">
        <tr>
            <td>起始排</td>
            <td><?= $form->field($model, 'row_start')->textInput()->label(false)?></td>
            <td>截止排</td>
            <td><?= $form->field($model, 'row_end')->textInput()->label(false) ?></td>
        </tr>
        <tr>
            <td>起始列</td>
            <td><?= $form->field($model, 'col_start')->textInput()->label(false) ?></td>
            <td>截止列</td>
            <td><?= $form->field($model, 'col_end')->textInput()->label(false) ?></td>
        </tr>
        <tr>
            <td>墓区</td>
            <td>
                <?php
                $graves = Grave::find()->where(['<>', 'status', Grave::STATUS_DELETE])->asArray()->all();
                $options = [];
                foreach ($graves as $k => $v) {
                    if (!$v['is_leaf']) {
                        $options[$v['id']]['disabled'] = true;
                    }
                }
                ?>

                <?= $form->field($model, 'grave_id')->dropDownList(Grave::selTree(), ['prompt'=> '请选择墓区', 'options' => $options])->label(false) ?>

            </td>
            <td>墓价</td>
            <td>
                <?= $form->field($model, 'price')->textInput(['maxlength' => true])->label(false) ?>
            </td>
        </tr>
        <tr>
            <td>石材成本</td>
            <td><?= $form->field($model, 'cost')->textInput(['maxlength' => true])->label(false) ?></td>
            <td>墓穴个数</td>
            <td><?= $form->field($model, 'hole')->textInput()->label(false) ?></td>
        </tr>
        <tr>
            <td>封面</td>
            <td><?= $form->field($model, 'thumb')->fileInput()->label(false) ?></td>
            <td>建筑面积</td>
            <td><?= $form->field($model, 'area_total')->textInput()->label(false) ?></td>
        </tr>
        <tr>
            <td>使用面积</td>
            <td> <?= $form->field($model, 'area_use')->textInput()->label(false) ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>备注</td>
            <td colspan="3"><?= $form->field($model, 'note')->textarea(['rows' => 6])->label(false) ?></td>
        </tr>
        <tr>
            <td>
                <?=  Html::submitButton('生成墓位', ['class' => 'btn btn-primary btn-block']) ?>
            </td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>
</div>
