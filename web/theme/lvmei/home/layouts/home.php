<?php
use yii\helpers\Html;
use yii\helpers\Url;

//$action = Yii::$app->controller->action->id;
$navs = \app\modules\cms\models\Nav::navs();

$controller = Yii::$app->controller;
$controller_id = $controller->id;
$module_id = $controller->module->id;
$action_id = $controller->action->id;

$c_nav = '/'.$module_id .'/'. $controller_id .'/'. $action_id;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <script src="/theme/lvmei/static/js/uaredirect.js" type="text/javascript"></script>
    <script type="text/javascript">uaredirect("http://www.yihedoors.com/m/");</script>
    <link rel="stylesheet" type="text/css" href="/theme/lvmei/static/css/common.css">
    <link rel="stylesheet" type="text/css" href="/theme/lvmei/static/css/home.css">
    <link rel="stylesheet" type="text/css" href="/theme/lvmei/static/css/style.css">
    <script type="text/javascript" src="/theme/lvmei/static/js/jquery.1.7.2.min.js"></script>
    <script type="text/javascript" src="/theme/lvmei/static/js/jquery.superslide.2.1.1.js"></script>
    <script type="text/javascript" src="/theme/lvmei/static/js/mon.js"></script>
</head>



<body>
<?php $this->beginBody() ?>
    <?=$this->render('header')?>

    <?=$content?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
