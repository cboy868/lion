<?= $form->field($lg_model, "[$lg_model->language]title")
    ->textInput(['maxlength' => true])
    ->hint('原文: '.$model->title); ?>

<?= $form->field($lg_model, "[$lg_model->language]subtitle")
    ->textInput(['maxlength' => true])
    ->hint('原文: '.$model->subtitle); ?>

<?= $form->field($lg_model, "[$lg_model->language]summary")
    ->textarea(['rows' => 6])
    ->hint('原文: '.$model->summary); ?>

<?= $form->field($lg_model, "[$lg_model->language]video")
    ->textInput(['rows' => 6])
    ->hint('原文: '.$model->video); ?>


