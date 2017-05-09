<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $name;
?>



<div class="container">
    <div class="margin-big-top">
    <div class="text-center">
        <br>
        <h2  class="padding-top">
            <stong><?= Html::encode($this->title) ?></stong>
        </h2>
        <p>
            <?= nl2br(Html::encode($message)) ?>
        </p>
        <img src="/static/images/wxr-1.jpg" width='20%' />
        <div class="padding-big">
            <a href="<?=Url::toRoute('/member')?>" class="button bg-yellow">go Home</a>
        </div>
    </div>
    </div>
</div>




