<?php

use app\core\helpers\Html;
use app\core\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\core\widgets\GridView;
use yii\bootstrap\Modal;

$this->params['current_menu'] = 'grave/ins-cfg/index';

$this->title = '碑文墓区样式配置';
$this->params['breadcrumbs'][] = ['label' => '配置总表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style type="text/css" media="screen">
ul.grave-list {
    margin:0px;
    padding:0px;
    list-style:none;
    font-size:14px;
    padding:10px 20px;
    border:1px #ccc dashed;
}
ul.grave-list li {
    float:left;
    width:10em;
    border:1px solid white;
    margin:5px;
    padding:3px;
    cursor:pointer;
}
ul.grave-list li.selected{
    background-color: #E0DF95;
}
</style>


<div class="page-content">
  <div class="page-header">
    <h1> 墓区配置分配<small> <i class="icon-double-angle-right"></i></small> </h1>
  </div>
  <div class="row">
    <div class="col-xs-12">
        <h2><?=$cfg['name']?> -- <font size="5"><?=$cfg['note']?></font>
            <button class="btn btn-xs all" rel='add'>全选</button>
            <button class="btn btn-xs all" rel='del'>全部删除</button></span>
        </h2>
		<ul class="grave-list">

            <?php foreach ($graves as $grave): ?>
                <li rel="grave-id" data-grave_id="<?=$grave['id']?>" <?php if(in_array($grave['id'],$selected)):?>class="selected"<?php endif;?> > <?=$grave['name']?></li>
            <?php endforeach ?>
		    <div style="clear:both"></div>
		</ul>
		<input type="hidden" name="cfg_id" value="<?=$cfg['id']?>" />
	</div>
  </div>
</div>

<?php $this->beginBlock('up') ?>  
$(function(){
    $('ul.grave-list li').click(function(e) {
        var $this = $(this);
        var grave_id = $(this).data('grave_id');
        var cfg_id = $('input[name=cfg_id]').val();
        var action = $(this).hasClass('selected')? 'del' : 'add';
        var datas = {
            'grave_id' : grave_id,
            'cfg_id' : cfg_id,
            'action' : action,
        };
        $.post("<?=Url::toRoute(['/grave/admin/ins-cfg/cfg-grave'])?>", datas, function(rs){
            if (rs.status == 0) {
                alert(rs.info);
            } else {
                $this.toggleClass('selected');
            }
        },'json');
        
    });
    $('.all').click(function(){
        var action = $(this).attr('rel');
        var cfg_id = $('input[name=cfg_id]').val();
        var datas = {action:action,cfg_id : cfg_id,_csrf:$('meta[name=csrf-token]').attr('content')};
        $.post("<?=Url::toRoute(['/grave/admin/ins-cfg/cfg-grave'])?>", datas, function(rs){
            if (!rs.status) {
                alert(rs.info);
            } else {
                location.reload();
            }
        },'json');
    });
})


<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['up'], \yii\web\View::POS_END); ?> 


