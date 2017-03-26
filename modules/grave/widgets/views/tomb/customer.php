
<?php if ($customer): ?>
    

<div class="col-xs-12 tomb-view">
<div class="item table-responsive" id="customer" loc="loc1">
    <div class="table-header"><i class="fa fa-user"></i> <span class="title_info">客户信息</span></div>
    <table class="table table-bordered table-condensed table-striped">
        <tbody>
<tr>
                <th>购墓人</th>
                <th>身份证号</th>
                <th>联系方式</th>
                <th>通讯地址</th>
                <th>座机电话</th>
                <th>微信号</th>
                <th>邮箱</th>
                <th>QQ号</th>
                
                <th>业直</th>
                <th>***</th>
                <th>第二联系人姓名</th>
                <th>第二联系人联系方式</th>
            </tr>
            <tr>
                <td><?=$customer->name;?></td>
                <td>暂无</td>
                <td>手机：<?=$customer->mobile;?></td>
                <td>天津市 </td>
                
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                
                <td></td>
                <td>
                                            否                </td>
                <td></td>
                <td></td>
            </tr>
             <tr>
             <!-- 
         <td colspan='8'></td>
          -->
       </tr>
        </tbody>
    </table>
</div>

<div class="hr hr-18 dotted hr-double"></div>
</div><!-- /.col -->

<?php endif ?>