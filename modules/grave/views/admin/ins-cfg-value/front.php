<?php 
use app\core\helpers\Url;

$this->title = '碑文模板样式制作';
$this->params['breadcrumbs'][] = ['label' => '配置首页', 'url' => ['/grave/admin/ins-cfg/index']];
$this->params['breadcrumbs'][] = ['label' => '配置项', 'url' => ['/grave/admin/ins-cfg-case/index']];
$this->params['breadcrumbs'][] = $this->title;

 ?>
<style>
hr{margin-top:2px;margin-bottom:2px;}
input, select {
    width: 50px;
}
</style>
<!-- 顶部导航结束 -->
<!-- 主体 -->
<div class="page-content">
	<div class="row">
	  <div class="col-sm-7 widget-container-span ui-sortable">
	    <div class="widget-box transparent">
	      <div class="widget-header">
	        <h4 class="lighter">定义内容</h4>
	      </div>
	      <div class="widget-body">
		    <div class="widget-main padding-6 no-padding-left no-padding-right">
		      <form class="form-horizontal" role="form" method="post" id="tpl">
		      	<input name="imgpath" value="<?=$case->img?>" class="imgpath" type="hidden">
		      	<input name="_csrf" type="hidden" value="<?=Yii::$app->request->getCsrfToken();?>">
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right">整体信息</label>
				  <div class="col-sm-10">
				  <?php if ($cfg->shape == 'v'): ?>
				  	竖碑
				  <?php else: ?>
				  	横碑
				  <?php endif ?>
			        <input type="hidden" value="<?=$cfg->shape?>" name="all[shape]" >
			        <input type="hidden" value="<?=$cfg->is_god?>" name="all[is_god]" >
			        <input type="" value="<?=$case->width?>" name="all[width]" class="input-small">
			        高
			        <input type="" value="<?=$case->height?>" name="all[height]" class="input-small">
	                <input type="hidden" name="all[case_id]" value="<?=$case->id?>"/>
				  </div>
                </div>
                <hr>
                <?php
                    foreach($fields['fields'] as $key => $field):
                    if(count($cfgs[$key])>1):
                        $ij = 0;
                        foreach($cfgs[$key] as $ck=>$cfg):
                ?>
			                <div class="form-group <?=$key?>" rel="<?=$key?>">
			                  <input type="hidden"  class="sort" name="tpl[<?=$key?>][<?=$ck?>][sort]" value="<?=$ck?>">
			                  <label class="col-sm-2 control-label no-padding-right"><?=$field?></label>
			                  <div class="col-sm-10">
			                    <span class="">
			                        <input type="text" class="input-mini size" placeholder="尺寸" name="tpl[<?=$key?>][<?=$ck?>][size]" value="<?=$cfgs[$key][$ck]['size']?>">
			                    </span>
			                    <span class="">
			                        <input type="text" class="input-mini x" placeholder="x" name="tpl[<?=$key?>][<?=$ck?>][x]" value="<?=$cfgs[$key][$ck]['x']?>">
			                    </span>
			                    <span class="">
			                        <input type="text" class="input-mini y" placeholder="y" name="tpl[<?=$key?>][<?=$ck?>][y]" value="<?=$cfgs[$key][$ck]['y']?>">
			                    </span>
                                  <!--
			                    <span class="">
			                        <input type="text" class="input-small colorpicker1" placeholder="颜色" name="tpl[<?=$key?>][<?=$ck?>][color]"   value="<?=$cfgs[$key][$ck]['color']?>">
			                    </span>
                                -->

			                    <span class="">
			                    <label>
			                    <input name="tpl[<?=$key?>][<?=$ck?>][direction]" type="checkbox" value="1" <?php if($cfgs[$key][$ck]['direction'] == 1) echo 'checked'; ?>>反向
			                    </label>
			                    </span>
			                    <span class="">
			                    <label>
			                    <input name="tpl[<?=$key?>][<?=$ck?>][is_big]" type="checkbox" value="1" <?php if($cfgs[$key][$ck]['is_big'] == 1) echo 'checked'; ?>>大字
			                    </label>
			                    </span>

			                    <span class="">
			                        <input type="text" class="input-sm" placeholder="测试值" style="width:100px;" name="tpl[<?=$key?>][<?=$ck?>][value]" value="<?=$cfgs[$key][$ck]['text']?>">
			                    </span>

			                    

			                    <?php if ($ij != 0): ?>
			                    	<button type="button" class='btn btn-minier del' caseid="<?=$case->id?>" key="<?=$key?>" sort="<?=$ck?>">删除</button>
			                    <?php else: ?>
			                    	<button type="button" class='btn btn-minier copy'>复制</button>
			                    <?php endif ?>
			                  </div>
			                </div>
                        <?php $ij++;endforeach;else:?>

                    <div class="form-group <?=$key?>" rel="<?=$key?>">
	                  <input type="hidden"  class="sort" name="tpl[<?=$key?>][1][sort]" value="1">
	                  <label class="col-sm-2 control-label no-padding-right"><?=$field?></label>
	                  <div class="col-sm-10">
	                    <span class="">
	                        <input type="text" class="input-mini size" placeholder="尺寸" name="tpl[<?=$key?>][1][size]" value="<?=$cfgs[$key][1]['size']?>">
	                    </span>
	                    <span class="">
	                        <input type="text" class="input-mini x" placeholder="x" name="tpl[<?=$key?>][1][x]" value="<?=$cfgs[$key][1]['x']?>">
	                    </span>
	                    <span class="">
	                        <input type="text" class="input-mini y" placeholder="y" name="tpl[<?=$key?>][1][y]" value="<?=$cfgs[$key][1]['y']?>">
	                    </span>
                          <!--
	                    <span class="">
	                        <input type="text" class="input-small colorpicker1" placeholder="颜色" name="tpl[<?=$key?>][1][color]"   value="<?=$cfgs[$key][1]['color']?>">
	                    </span>
                        -->
	                    <span class="">
                    	<label>
                    	<input name="tpl[<?=$key?>][1][direction]" type="checkbox" value="1" <?php if($cfgs[$key][1]['direction'] == 1) echo 'checked'; ?>>反向
                    	</label>
	                    </span>
	                    <span class="">
	                    	<label>
	                    	<input name="tpl[<?=$key?>][1][is_big]" type="checkbox" value="1" <?php if($cfgs[$key][1]['is_big'] == 1) echo 'checked'; ?>>大字
	                    	</label>
	                    </span>

	                    <span class="">
	                        <input type="text" class="input-sm" placeholder="测试值" style="width:100px;" name="tpl[<?=$key?>][1][value]" value="<?=$cfgs[$key][1]['text']?>">
	                    </span>

	                    
	                    <button type="button" class='btn btn-minier copy'>复制</button>
	                  </div>
	                </div>
                <?php endif;endforeach;?>

                <?php
                    foreach($fields['dead_fields'] as $key => $dead):
                ?>
                <h4><?=$dead?></h4>
                <hr>
                <?php for($i=1;$i<=$case->num;$i++):?>
                <input type="hidden"  name="tpl[<?=$key?>][<?=$i?>][sort]" value="<?=$i?>">
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right"><?=$dead?></label>
                  <div class="col-sm-10">
                    <span class="">
                        <input type="text" class="input-mini size" placeholder="尺寸" name="tpl[<?=$key?>][<?=$i?>][size]" value="<?=$cfgs[$key][$i]['size']?>">
                    </span>
                    <span class="">
                        <input type="text" class="input-mini x" placeholder="x" name="tpl[<?=$key?>][<?=$i?>][x]"  value="<?=$cfgs[$key][$i]['x']?>">
                    </span>
                    <span class="">
                        <input type="text" class="input-mini y" placeholder="y" name="tpl[<?=$key?>][<?=$i?>][y]"  value="<?=$cfgs[$key][$i]['y']?>">
                    </span>

                    <span class="">
                    	<label>
                    		<input name="tpl[<?=$key?>][<?=$i?>][is_big]" type="checkbox" value="1" <?php if($cfgs[$key][$i]['is_big'] == 1) echo 'checked'; ?>>大字
                    	</label>
                    </span>
                    
                    <span class="">
                        <input type="text" class="input-sm" placeholder="测试值" style="width:100px;" name="tpl[<?=$key?>][<?=$i?>][value]" value="<?=$cfgs[$key][$i]['text']?>">
                    </span>

                    
                  </div>
                </div>
                <?php endfor;endforeach;?>


                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-info" type="submit">
                            <i class="icon-ok bigger-110"></i>保存
                        </button>
                    </div>
                </div>
              </form>
		    </div>
	      </div>
	    </div>
	  </div>

	<!-- 以下为图片预览 -->
	  <div class="col-sm-5 widget-container-span ui-sortable">
	    <div class="widget-box transparent">
	      <div class="widget-header">
	        <h4 class="lighter">
	           <a href="<?=Url::toRoute(['/grave/admin/ins-cfg-value/pic'])?>" data-action="reload" id="refresh" title="刷新">生成样图
	               <i class="icon-refresh"></i>
	           </a>
	        </h4>
	      </div>
	      <div class="widget-body">
	        <div class="widget-main padding-6 no-padding-left no-padding-right">
	           <img src="<?=$case->img?>"  width="400" class="image">
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>

<?php $this->beginBlock('cate') ?>  
$(function(){
$(function(){
    $('#sidebar').addClass('menu-min');
	$('#refresh').click(function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		var formValue = $('#tpl').serialize();
		$.post(url,formValue,function(xhr){
			if(xhr.status==1) {
				$('.image').attr('src',xhr.data);
				$('.imgpath').val(xhr.data);
			}
		},'json');
	});


	//copy
	$('body').on('click', '.copy', function(){
		var line = $(this).closest('.form-group').clone();
		var mart = line.attr('rel');
		var count = $('.'+mart).length;
		line.find('input, select').each(function(){
			var name = $(this).attr('name');
			var newname = name.replace(1, count+1);
			$(this).attr('name',newname);
		});
		line.find('button').html('删除').removeClass('copy').addClass('del');
		line.find('.sort').val(count+1);
        $('.'+mart+':last').after(line);

	})

	$('body').on('click', '.del', function(){
		//$(this).closest('.form-group').remove();
	})

    $('body').on('click', '.del', function(e){
        e.preventDefault();
        var case_id = $(this).attr('caseid');
        var sort = $(this).attr('sort');
        var key = $(this).attr('key');

        if (!case_id) {
            return $(this).closest('.form-group').remove();
        }
        _this = this;
        $.get('<?=Url::toRoute(['/grave/admin/ins-cfg-value/remove'])?>',{case_id:case_id, sort:sort, key:key},function(xhr){
            if(xhr.status) {
                $(_this).closest('.form-group').remove();
            } else {
                alert(xhr.info);
            }
        },'json');
    });
});
   
    
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['cate'], \yii\web\View::POS_END); ?>  





