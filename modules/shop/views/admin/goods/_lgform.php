<?= $form->field($lg_model, "[$lg_model->language]name")
    ->textInput(['maxlength' => true])->hint('原文: '.$model->name) ?>

<?= $form->field($lg_model, "[$lg_model->language]intro")
    ->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'goods', 'use'=>'ue'] ]);?>

<?= $form->field($lg_model, "[$lg_model->language]unit")
    ->textInput(['maxlength' => true])
    ->hint('原文: '.$model->unit) ?>

<?= $form->field($lg_model, "[$lg_model->language]skill")
    ->textArea(['maxlength' => true])
    ->label('附加')
    ->hint('原文: '.$model->skill) ?>






