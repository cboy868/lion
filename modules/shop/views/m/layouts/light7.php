<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\Light7Asset;



Light7Asset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- <script type="text/javascript" src="/static/libs/jquery/jquery-2.1.3.min.js"></script> -->
  </head>
  <body>
    <?php $this->beginBody() ?>
    <div class="page-group">
        <!-- 单个page ,第一个.page默认被展示-->
        <?=$content?>
    </div>   

<?php $this->endBody() ?>
<script type="text/javascript">
//   $("#my-input").calendar({
//     value: ['2015-12-05']
// });
$.init() 
</script>
  </body>
</html>
<?php $this->endPage() ?>