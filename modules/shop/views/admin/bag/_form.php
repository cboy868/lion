<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;;
USE app\core\widgets\Ueditor;
use app\core\widgets\Webup\Webup;
use app\modules\shop\models\Category;
/* @var $this yii\web\View */
/* @var $model app\modules\shop\models\Bag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $category = Category::find()->asArray()->all();
        $options = [];
        foreach ($category as $k => $v) {
            if (!$v['is_leaf']) {
                $options[$v['id']]['disabled'] = true;
            }
        }

        $trees = Category::selTree();
        $trees[0] = '跨多分类';
        ksort($trees);
     ?>

    <?= $form->field($model, 'category_id')->dropDownList($trees, ['options'=>$options]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-goods-pic required">
        <!-- <label class="control-label" for="goods-pic">图片集</label> -->
        <?php echo Webup::widget(['options'=>['res_name'=>'goods_bag', 'id'=>'goods_bag']]);?>
        <div class="help-block"></div>
    </div>

    <?= $form->field($model,'intro')->widget('app\core\widgets\Ueditor\Ueditor',['option' =>['res_name'=>'goods_bag', 'use'=>'ue'] ]);?>


	<div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            <?=  Html::submitButton('保 存', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
