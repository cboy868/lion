<?php

use app\core\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
\app\assets\PluploadVideoAssets::register($this);
?>

<div class="remote-form">


    <?=Html::a('上传视频', '#', [
        'id' => 'filePicker-' . $model->id . 'a',
        'class' => ' filelist-thumb videoPicker',
        'rid' => $model->id,
        'data-url'=>Url::toRoute('video-upload'),
        'data-res_name'=>"memorial",
        'data-use'=>"thumb"
    ]);
    ?>
    <b class="percent"></b>

    <div class="form-group">
        <?=  Html::button('确 定', ['class' => 'btn btn-primary btn-sm pull-right']) ?>
    </div>

    <div class="clearfix"></div>
</div>
