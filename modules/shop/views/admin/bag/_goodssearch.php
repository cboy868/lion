<?php
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\helpers\Url;
use app\modules\shop\models\Category;
?>

<div class="bag-search">

    <?php $form = ActiveForm::searchBegin(); ?>
    <?php if ($model->category_id == 0): ?>
        <?php $form->action = 'search-goods' ?>
    <?php else: ?>
        <?php $form->action=Url::toRoute(['search-goods', 'category_id'=>$model->category_id]) ?>
    <?php endif ?>
    

    <?php if ($model->category_id == 0): ?>
        <div class="form-group field-bagsearch-title">
            <label class="control-label" for="bagsearch-title">分类</label>
            <?php 
            $category = Category::find()->asArray()->all();
            $options = [];
            foreach ($category as $k => $v) {
                if (!$v['is_leaf']) {
                    $options[$v['id']]['disabled'] = true;
                }
            }
             ?>
            <?=Html::dropDownList('category_id', null, Category::selTree(), ['class'=>'form-control', 'options' => $options, 'prompt'=>'选择分类'])?>
        </div>
    <?php endif ?>
    

    <div class="form-group field-bagsearch-title">
		<label class="control-label" for="bagsearch-title">商品名</label>
		<input type="text" id="bagsearch-title" class="form-control input-sm" name="name">
	</div>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm s-goods']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
