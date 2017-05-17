<?php
use app\core\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<h2>您好！贵公司产品有新的关注，请关注</h2>
<br>
<?= $content ?>

<div style="margin-top:100px;font-size:18px;">Lion信息管理系统</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
