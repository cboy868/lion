<?php 
use app\core\widgets\ActiveForm;
use app\core\helpers\Html;
use app\core\widgets\comment\Comment;
?>



<?php echo Comment::widget(['pid'=>100,'res_name'=>'goods', 'res_id'=>11, 'to'=>111]);?>
