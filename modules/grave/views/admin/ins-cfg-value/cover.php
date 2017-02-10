<div class="breadcrumbs" id="breadcrumbs">
  <script type="text/javascript">
     try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){ }
  </script>
  <ul class="breadcrumb">
  <li>
    <a href="/admin/inscfg"><i class="fa fa-share"></i>配置列表</a>
    </li>
  </ul>
</div>
<style>
hr{margin-top:2px;margin-bottom:2px;}
</style>
<!-- 顶部导航结束 --> 
<!-- 主体 -->
<div class="page-content">
    <div class="page-header">
     <h1>制作模板<small>碑后文模板图片货制作</small></h1>
    </div>
	<div class="row">
	  <div class="col-sm-7 widget-container-span ui-sortable">
	    <div class="widget-box transparent">
	      <div class="widget-header">
	        <h4 class="lighter">定义内容</h4>
	      </div>
	      <div class="widget-body">
		    <div class="widget-main padding-6 no-padding-left no-padding-right">
		      <form class="form-horizontal" role="form" method="post" id="tpl">
            <input name="imgpath" value="{$cfg_info.img}" class="imgpath" type="hidden">
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right">整体信息</label>
				  <div class="col-sm-10">
				      <eq name="cfg_info.shape" value="v">竖碑<else/>横碑</eq>
              <input type="hidden" value="{$cfg_info.shape}" name="all[shape]" >
              宽
              <input type="" value="{$cfg_info.width}" name="all[width]" class="input-small">
              高
              <input type="" value="{$cfg_info.height}" name="all[height]" class="input-small">
	            <input type="hidden" name="all[case_id]" value="{$cfg_info.id}"/>
				  </div>
                </div>
                <hr>
                <?php for($i=1;$i<=$cfg_info['num'];$i++):?>
                <input type="hidden"  name="tpl[main][{$i}][sort]" value="{$i}">
                <div class="form-group">
                  <label class="col-sm-2 control-label no-padding-right">主内容</label>
                  <div class="col-sm-10">
	                    <span class="">
	                        <input type="text" class="input-mini size" placeholder="尺寸" name="tpl[main][{$i}][size]" value="{$cfgs['main'][$i]['size']}">
	                    </span>
                    <span class="">
                        <input type="text" class="input-mini x" placeholder="x" name="tpl[main][{$i}][x]" value="{$cfgs['main'][$i]['x']}">
                    </span>
                    <span class="">
                        <input type="text" class="input-mini y" placeholder="y" name="tpl[main][{$i}][y]" value="{$cfgs['main'][$i]['y']}">
                    </span>
                    <span class="">
                        <input type="text" class="input-small colorpicker1" placeholder="颜色" name="tpl[main][{$i}][color]"   value="{$cfgs['main'][$i]['color']|default='#333333'}">
                    </span>
                    <span class="">
                      <select  name="tpl[main][{$i}][direction]">
                        <option value="0" <?php if($cfgs['main'][$i]['direction'] == 0) echo 'selected'; ?>>正向</option>
                        <option value="1" <?php if($cfgs['main'][$I]['direction'] == 1) echo 'selected'; ?>>反向</option>
                      </select>
                    </span>
                    <span class="">
                        <input type="text" class="input-sm" placeholder="测试值"  name="tpl[main][{$i}][value]" value="{$cfgs['main'][$i]['text']}">
                    </span>
                  </div>
                </div>
                <?php endfor;?>

                <div class="form-group">
                <input type="hidden"  name="tpl[inscribe][1][sort]" value="1">
                  <label class="col-sm-2 control-label no-padding-right">落款</label>
                  <div class="col-sm-10">
                        <span class="">
                            <input type="text" class="input-mini size" placeholder="尺寸" name="tpl[inscribe][1][size]" value="{$cfgs['inscribe'][1]['size']}">
                        </span>
                    <span class="">
                        <input type="text" class="input-mini x" placeholder="x" name="tpl[inscribe][1][x]" value="{$cfgs['inscribe'][1]['x']}">
                    </span>
                    <span class="">
                        <input type="text" class="input-mini y" placeholder="y" name="tpl[inscribe][1][y]" value="{$cfgs['inscribe'][1]['y']}">
                    </span>
                    <span class="">
                        <input type="text" class="input-small colorpicker1" placeholder="颜色" name="tpl[inscribe][1][color]"   value="{$cfgs['inscribe'][1]['color']|default='#333333'}">
                    </span>
                    <span class="">
                      <select  name="tpl[inscribe][1][direction]">
                        <option value="0" <?php if($cfgs['inscribe'][1]['direction'] == 0) echo 'selected'; ?>>正向</option>
                        <option value="1" <?php if($cfgs['inscribe'][1]['direction'] == 1) echo 'selected'; ?>>反向</option>
                      </select>
                    </span>
                    <span class="">
                        <input type="text" class="input-sm" placeholder="测试值"  name="tpl[inscribe][1][value]" value="{$cfgs['inscribe'][1]['text']}">
                    </span>
                  </div>
                </div>
                
                <div class="form-group">
                <input type="hidden"  name="tpl[inscribe_date][1][sort]" value="1">
                  <label class="col-sm-2 control-label no-padding-right">落款日期</label>
                  <div class="col-sm-10">
                        <span class="">
                            <input type="text" class="input-mini size" placeholder="尺寸" name="tpl[inscribe_date][1][size]" value="{$cfgs['inscribe_date'][1]['size']}">
                        </span>
                    <span class="">
                        <input type="text" class="input-mini x" placeholder="x" name="tpl[inscribe_date][1][x]" value="{$cfgs['inscribe_date'][1]['x']}">
                    </span>
                    <span class="">
                        <input type="text" class="input-mini y" placeholder="y" name="tpl[inscribe_date][1][y]" value="{$cfgs['inscribe_date'][1]['y']}">
                    </span>
                    <span class="">
                        <input type="text" class="input-small colorpicker1" placeholder="颜色" name="tpl[inscribe_date][1][color]"   value="{$cfgs['inscribe_date'][1]['color']|default='#333333'}">
                    </span>
                    <span class="">
                      <select  name="tpl[inscribe_date][1][direction]">
                        <option value="0" <?php if($cfgs['inscribe_date'][1]['direction'] == 0) echo 'selected'; ?>>正向</option>
                        <option value="1" <?php if($cfgs['inscribe_date'][1]['direction'] == 1) echo 'selected'; ?>>反向</option>
                      </select>
                    </span>
                    <span class="">
                        <input type="text" class="input-sm" placeholder="测试值"  name="tpl[inscribe_date][1][value]" value="{$cfgs['inscribe_date'][1]['text']}">
                    </span>
                  </div>
                </div>
                
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
               <a href="/admin/greate/pic" data-action="reload" id="refresh" title="刷新">生成样图
                   <i class="icon-refresh"></i>
               </a>
            </h4>
	      </div>
	      <div class="widget-body">
	        <div class="widget-main padding-6 no-padding-left no-padding-right">
	           <img src="{$cfg_info.img}"  width="400" class="image">
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<script src="/static/assets/js/bootstrap-colorpicker.min.js"></script>
<link rel="stylesheet" href="/static/assets/css/colorpicker.css">
<script>
$(function(){
	$('.colorpicker1').colorpicker();
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
	
	//如何让大家一起变呢，不好处理哦
	$('.size,.x,.y,.font').blur(function(){
		var value = $(this).val();
	});
});
</script>