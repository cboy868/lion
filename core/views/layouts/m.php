<?php 
use app\assets\WeuiAsset;
use app\core\helpers\Html;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html> 
<html lang="<?= Yii::$app->language ?>">     
<head>        
	 <meta charset="UTF-8">        
	 <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">         
		<?= Html::csrfMetaTags() ?>
	    <title><?= Html::encode($this->title) ?></title>
	    <?php $this->head() ?>
	</head>    
	<body>   
	<?php $this->beginBody() ?>
	<?= $content ?>     
	<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>