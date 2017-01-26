<style type="text/css">
#option-box { font-size:12px;}
#option-box table tr{ margin-bottom:1em; border-bottom:1px dotted #e1e1e1; } 
#option-box table td { vertical-align:middle; padding:2px 0px 3px 3px; }
#option-box table td span { background-color:#ccd8ed; border-radius:3px; padding:2px 5px; color:#666;}
#option-box table td div { width:100px; float:left; line-height:30px; }
</style>

<div class="row">

    <div class="col-xs-3">
        <img class="img-circle" width="64" src="<?=$tomb->getThumb('200x100', '/static/images/default.png')?>">
    </div>
    <div class="col-xs-9">
      墓位号:<code><?=$tomb->tomb_no?></code> 价格:<code>¥<?=$tomb->price?></code> 穴数:<code><?=$tomb->hole?></code>
    </div>

    <div id="option-box" class="col-xs-12">
    <hr />
    <table>
    <?php foreach($options as $key=>$opt):?>
    <tr>
        <td width="80px;" valign="top" style="padding-top:4px;">
        <?php
        switch ($key) {
        case 'common':
            echo '<span class="option-title">普通操作</span>';
            break;

        case 'operate':
            echo '<span class="option-title">业务操作</span>';
            break;

        case 'other':
            echo '<span class="option-title">其他操作</span>';
            break;

        case 'tombwithdraw':
            echo '<span class="option-title">退墓操作</span>';
            break;

        case 'careful':
            echo '<span class="option-title">改墓操作</span>';
            break;
        //  ..... 其他的
        }
        ?>
        </td>
        <td>
        <?php foreach($opt as $item): ?>
            <div>
              <a class="<?php echo $item[2];?>" href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
            </div>
        <?php endforeach;?>
        </td>
    </tr>
    <?php endforeach;?>
    </table>
    </div>
</div>


<div id='ylw-tpl' style="display:none;">
  <div id="recommand-form" class="recommand-box">
    <form action="" method="post">
      <textarea placeholder="推荐理由" rows="5" class="form-control" name="recommand_intro"></textarea>
  </div>
  <div id="retain-form" class="retain-box">
    <form action="" method="post">
      <textarea placeholder="保留理由" rows="5" class="form-control" name="retain_intro"></textarea>
    </form>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
$(function(){
    // 操作项 - 墓位预订-------------------------------------------------
    $('body').on('click', 'a.tomb-preorder', function(e){
        e.preventDefault(); 
        var url = $(this).attr('href');
        $.get(url, function(json){
            if (json.info == 'ok') {
                var html = '墓位: 『'
                         + json.data['tomb_no'] 
                         + ' 』预订成功';
                bootbox.dialog({
        			title: "预订墓位成功",
                    message: '<p style="font-size:1.5em" class="alert alert-success"><i class="icon-comment-alt"></i> ' + html + '</p>',
        			buttons: 			
        			{
        				"success" :
        				 {
        					"label" : "<i class='icon-ok'></i> 进入业务流程",
        					"className" : "btn-sm btn-success",
        					"callback": function() {
        						 // window.location = '/admin/tomb/process?tomb_id='+json.data['id'];
        						 window.location = '/admin/process/all?tomb_id='+json.data['id'];
        					}
        				},
        				"button" :
						{
							"label" : "返回",
							"className" : "btn-sm",
							"callback": function() {
        						window.location = '/admin/tomb';
	       					}
						}
        			}
        		})

            }
        }, 'json');
    });

    // 操作项 - 取消预订-------------------------------------------------
    $('body').on('click', 'a.tomb-unpreorder', function(e){
        e.preventDefault(); 
        var url = $(this).attr('href');
        $.get(url, function(json){
            if (json.status == 0) {
            	bootbox.dialog({
        			title: "错误信息",
        			message: json.info
        		})
            } else {
                window.location.reload();
            }
        }, 'json');
        
    });
    
    // 保留墓位操作
    $('body').on('click', 'a.tomb-retain', function(e){
        e.preventDefault();        
        var $this = $(this);
        var url = $(this).attr('href');
        var retainForm = $('#ylw-tpl').find('#retain-form')
                                         .clone().removeAttr('id')
        retainForm.find('textarea').attr('rel','retain-box');
        retainArt = bootbox.dialog({
            title: "保留该墓位",
            message: retainForm.html(),
            buttons:            
            {
                "success" :
                 {
                    "label" : "<i class='icon-ok'></i> 保留",
                    "className" : "btn-sm btn-success",
                    "callback": function() {
                         var content = $('textarea[rel=retain-box]').val();
                            var datas = {
                                'retain_intro' : content,
                                'sale_status'  : -1
                            };
                            $.get(url, datas, function(rs){
                                if (rs.status) {
                                    $this.text('');
                                    bootbox.dialog({
                                        title: "保留墓位成功",
                                        message: '<p style="font-size:1.5em" class="alert alert-success"><i class="icon-comment-alt"></i> 保留墓位成功</p>',
                                        buttons:            
                                        {
                                            "success" :
                                             {
                                                "label" : "<i class='icon-ok'></i> 结束",
                                                "className" : "btn-sm btn-success",
                                                "callback": function() {location.reload()}
                                            },
                                        }
                                    })
                                    
                                }    
                            },'json');
                    }
                },
                "button" :
                {
                    "label" : "返回",
                    "className" : "btn-sm",
                    "callback": function() {
                        
                    }
                }
            }
        })
    });
    
 // 保留墓位操作
    $('body').on('click', 'a.tomb-retain-del', function(e){
        e.preventDefault();        
        var $this = $(this);
        var url = $(this).attr('href');
        var retainForm = $('#ylw-tpl').find('#retain-form')
                                         .clone().removeAttr('id')
        retainForm.find('textarea').attr('rel','retain-box');
        retainArt = bootbox.dialog({
            title: "取消保留",
            message: retainForm.html(),
            buttons:            
            {
                "success" :
                 {
                    "label" : "<i class='icon-ok'></i> 取消保留",
                    "className" : "btn-sm btn-success",
                    "callback": function() {
                         var content = $('textarea[rel=retain-box]').val();
                            var datas = {
                                'retain_intro' : content,
                                'sale_status'  : 1
                            };
                            $.get(url, datas, function(rs){
                                if (rs.status) {
                                    $this.text('');
                                    bootbox.dialog({
                                        title: "取消保留墓位成功",
                                        message: '<p style="font-size:1.5em" class="alert alert-success"><i class="icon-comment-alt"></i> 取消保留成功</p>',
                                        buttons:            
                                        {
                                            "success" :
                                             {
                                                "label" : "<i class='icon-ok'></i> 结束",
                                                "className" : "btn-sm btn-success",
                                                "callback": function() {location.reload()}
                                            },
                                        }
                                    })
                                    
                                }    
                            },'json');
                    }
                },
                "button" :
                {
                    "label" : "返回",
                    "className" : "btn-sm",
                    "callback": function() {
                        
                    }
                }
            }
        })
    });
    
    // 推荐墓位操作
    $('body').on('click', 'a.tomb-recommand', function(e){
        e.preventDefault();        
        var $this = $(this);
        var url = $(this).attr('href');
        var recommandForm = $('#ylw-tpl').find('#recommand-form')
                                         .clone().removeAttr('id')
        recommandForm.find('textarea').attr('rel','recommand-box');
        recommandArt = bootbox.dialog({
			title: "推荐该墓位",
			message: recommandForm.html(),
			buttons: 			
			{
				"success" :
				 {
					"label" : "<i class='icon-ok'></i> 推荐",
					"className" : "btn-sm btn-success",
					"callback": function() {
						 var content = $('textarea[rel=recommand-box]').val();
			                var datas = {
			                    'recommand_intro' : content
			                };
			                $.post(url, datas, function(rs){
			                    if (rs.info == 'ok') {
			                        $this.attr('href', rs.data.url);
			                        $this.attr('class', 'tomb-unrecommand');
			                        $this.text('取消推荐');
			                    }    
			                },'json');
					}
				},
				"button" :
				{
					"label" : "返回",
					"className" : "btn-sm",
					"callback": function() {
						
   					}
				}
			}
		})
    });
    
    // 取消推荐
    $('body').on('click', 'a.tomb-unrecommand', function(e){
        e.preventDefault();        
        var $this = $(this);
        var url = $this.attr('href');
        $.get(url, function(rs) {
            if (rs.info == 'ok') {
                $this.attr('class', 'tomb-recommand');
                $this.attr('href', rs.data.url);
                $this.text('推荐该墓位');
            }
        },'json');
    });
        
        
}); 
</script>
