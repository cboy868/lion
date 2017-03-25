<div class="col-xs-12">
<div class="item table-responsive" id="tomb" loc="loc0">
	<div class="table-header">
        <i class="icon-credit-card"></i> 
       <span class="title_info"> 墓位信息</span>
<!-- upload tomb photo -->
<form id="tomb-photo-form" enctype="multipart/form-data" method="post" action="/admin/tomb/photo" class="form-inline pull-right" style="margin-right:10px;">
  <input type="hidden" name="id" value="119">
  <div class="form-group has-error" style="margin:0px;">
    <label class="red1" style="font-size:12px;margin-bottom:0px;">上传墓位照片</label>
    <input type="file" class="form-control input-sm" name="tomb_photo" value="" style="">
  </div>
  <button type="submit" class="radius4 btn btn-xs btn-primary">提交</button>
<input type="hidden" name="__hash__" value="4cf23401bff4c7d8de5f95fd33ba728a_a3296242cbb3ea3edfb6139067e5a1d4"><input type="hidden" name="__hash__" value="4cf23401bff4c7d8de5f95fd33ba728a_a3296242cbb3ea3edfb6139067e5a1d4"></form>
<script type="text/javascript" charset="utf-8" src="/static/js/jquery.form.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
    var photoForm = $('#tomb-photo-form');
    photoForm.ajaxForm(function(url) {     
        if ( url ) {
            $('#_tomb_photo').attr('src', url);
        }
    });  
}); 
</script>
<!-- upload tomb photo -->

    </div>
    <table class="table table-bordered table-condensed table-striped">
        <tbody>
<tr>
                <td rowspan="17" width="320">
                    <a href="#" class="tombimg_small">
                      <img id="_tomb_photo" class="img-rounded" src="">
                    </a>
                </td>
            </tr>
            <tr>
                <th width="120">墓位区排号</th>
                <td>
                    <a href="/admin/process/all?tomb_id=119">西丙二10排11列</a>
                </td>
                <td rowspan="11" width="280">
                                    <div>
                    <img src="/admin/index/bindPng?user_id=61140">
                    <br>
                    <span style="margin-left:20px;font-size:20px">购买人微信扫码，绑定微信</span>
                    </div>
                                </td>
            </tr>
            <tr>
                <th>墓位价格</th>
                <td>14800元</td>
            </tr>
            <tr>
                <th>销售状态</th>
                <td>全部安葬</td>
            </tr>
            <tr>
                <th>碑型</th>
                <td>竖碑</td>
            </tr>
            <tr>
                <th>颜料</th>
                <td>铜粉</td>
            </tr>
            <tr>
                <th>石材</th>
                <td></td>
            </tr>
                        <tr>
                <th>客户账号</th>
                <td>陈卓硕2016 <a href="/admin/tomb/access/user_id/61140">以客户身份登录</a></td>
            </tr>
                        <tr>
                <th>负责人</th>
                <td>匿名用户</td>
            </tr>
            <tr>
                <th>导购员</th>
                <td>王斌</td>
            </tr>
            <tr>
                <th>业直</th>
                <td>
	                接待员	                &nbsp;&nbsp;
                         <a ylw-remote-form="true" href="/admin/tomb/agentModify?tomb_id=119"> 修改</a>
                          </td>
                
            </tr>
            <tr>
                <th>安葬员</th>
                <td>陆长青</td>
            </tr>
            <tr>
                <th>购买日期</th>
                <td colspan="2">2005-01-22</td>
            </tr>

                            <tr>
                    <th>最早安葬日期</th>
                    <td colspan="2">2016-04-29 10:06:28</td>
                </tr>
                        <tr>
	                <th>碑文备注</th>
	                <td colspan="2">                                                                                                                                                                                                        </td>
	            </tr>            <tr>
	                <th>打印备注</th>
	                <td colspan="2">                                                                                                                                                                                                        </td>
	            </tr>	        <tr>
	                <th>特殊备注</th>
	                <td colspan="2">                                                                                                                                                                                                        </td>
	            </tr>            <tr>
                <th>墓证年限</th>
                <td colspan="2">
                                                            2005-01-22 至 2025-01-22                                                                 <a ylw-remote-form="true" href="/admin/tomb/editcard?tomb_id=119"> 编辑</a>
                                      </td>
            </tr>
            

            <tr>
                                    </tr>
        </tbody>
    </table>
</div>
</div>