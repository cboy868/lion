<?= $form->field($lg_model, "[$lg_model->language]title")
    ->textInput(['maxlength' => true])
    ->hint('原文: '.$model->title);
?>

<?= $form->field($lg_model, "[$lg_model->language]summary")
    ->textarea(['rows' => 6])
    ->hint('原文: '.$model->summary); ?>

