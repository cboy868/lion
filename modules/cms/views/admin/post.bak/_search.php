<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use app\core\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\cms\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-search">

<?php 
$mod = \Yii::$app->getRequest()->get('mod');
$url = Url::toRoute(['/admin/cms/post', 'mod'=>$mod]) ;
?>
    <?php $form = ActiveForm::searchBegin([
    		// 'action' => $url,
    		'fieldConfig'=>[
	            'template' => '{label}{input}',
	            'labelOptions' => [
	                'class' => 'control-label'
	            ],
	            'inputOptions' =>['class'=>'form-control input-sm']
	        ],
	        'method' => 'get',
	        'options'=> [
	            'class'=>'form-inline'
	        ]
    	]); 
    ?>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  查找', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('<i class="fa fa-reply"></i>  重置',Url::toRoute(['index', 'mod'=>$mod]),['class'=>'btn btn-danger btn-sm']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
