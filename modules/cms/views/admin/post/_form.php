<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\modules\cms\models\Category;

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="post-form">

<?php 

$mod = \Yii::$app->getRequest()->get('mod');
?>

    <?php $form = ActiveForm::begin(); ?>

    <input type="hidden" name="mod" value="<?=$mod?>">

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php 
        $mod = Yii::$app->request->get('mod');
        $category = Category::find()->where(['res_name'=>'post'.$mod])->asArray()->all();
        $options = [];
        foreach ($category as $k => $v) {
            if (!$v['is_leaf']) {
                $options[$v['id']]['disabled'] = true;
            }
        }
    ?>

    <?= $form->field($model, 'category_id')->dropDownList([0=>'默认分类'] + Category::selTree(['res_name'=>'post' . $mod]),['class'=>'new form-control', 'options' => $options]) ?>

    <?= $form->field($model, 'author')->textInput() ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>

    <?= $form->field($dataModel,'body')->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'post'.$mod, 'use'=>'ue'], 'value'=>$dataModel->body ]);?>


    <?php foreach ($attach as $k => $v): ?>
    	<?php if ($v['html'] == 'input'): ?>
            <?= $form->field($model, $v['name'])->textInput(['value'=>isset($model)?$model->$v['name']:'']) ?>
        <?php elseif($v['html'] == 'textarea'): ?>
            <?= $form->field($model, $v['name'])->textarea(['rows' => 6, 'value'=>isset($model)?$model->$v['name']:'']) ?>
        <?php elseif($v['html'] == 'fulltext'): ?>
            <?= $form->field($model,$v['name'])->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'post', 'use'=>'ue'], 'value'=>isset($model)?$model->$v['name']:''])->label($v['title']); ?>
    	<?php endif ?>
    <?php endforeach ?>

	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
				