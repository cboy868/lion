<?php

use app\core\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\core\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\grave\models\Tomb */

$this->title = $model->tomb_no;
$this->params['breadcrumbs'][] = ['label' => '墓位管理', 'url' => ['index']];
?>

<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>一墓一档 <small>墓位详细信息</small></h1>
        </div>

        <div class="row">
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="tomb" loc="loc0">
                        <div class="table-header">
                            <i class="icon-credit-card"></i> 
                           <span class="title_info"> 墓位信息</span>
                    <!-- upload tomb photo -->
                    <form id="tomb-photo-form" enctype="multipart/form-data" method="post" action="/admin/tomb/photo" class="form-inline pull-right" style="margin-right:10px;">
                      <input type="hidden" name="id" value="73">
                      <div class="form-group has-error" style="margin:0px;">
                        <label class="red1" style="font-size:12px;margin-bottom:0px;">上传墓位照片</label>
                        <input type="file" class="form-control input-sm" name="tomb_photo" value="" style="">
                      </div>
                      <button type="submit" class="radius4 btn btn-xs btn-primary">提交</button>
                    <input type="hidden" name="__hash__" value="8e19bb5836d88be4e6bbff55577cf169_062db397291e580784fb3651053d89ed"><input type="hidden" name="__hash__" value="8e19bb5836d88be4e6bbff55577cf169_062db397291e580784fb3651053d89ed"></form>
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
                            <td rowspan="18" width="320">
                                <a href="#" class="tombimg_small">
                                  <img id="_tomb_photo" class="img-rounded" src="">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th width="120">墓位区排号</th>
                            <td>
                                <a href="/admin/process/all?tomb_id=73">西丙二7排1列</a>
                            </td>
                            <td rowspan="11" width="280">
                                                <div>
                                <img src="/admin/index/bindPng?user_id=50792">
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
                            <td>井振华 <a href="/admin/tomb/access/user_id/50792">以客户身份登录</a></td>
                        </tr>
                                    <tr>
                            <th>负责人</th>
                            <td>匿名用户</td>
                        </tr>
                        <tr>
                            <th>导购员</th>
                            <td>黄丹</td>
                        </tr>
                        <tr>
                            <th>业直</th>
                            <td>
                                接待员                 &nbsp;&nbsp;
                                     <a ylw-remote-form="true" href="/admin/tomb/agentModify?tomb_id=73"> 修改</a>
                                      </td>
                            
                        </tr>
                        <tr>
                            <th>安葬员</th>
                            <td>匿名用户</td>
                        </tr>
                        <tr>
                            <th>购买日期</th>
                            <td colspan="2">2005-01-22</td>
                        </tr>

                                        <tr>
                                <th>最早安葬日期</th>
                                <td colspan="2">2012-08-03 09:05:54</td>
                            </tr>
                                    <tr>
                                <th>碑文备注</th>
                                <td colspan="2">                                                                                                                                                                                                        </td>
                            </tr>            <tr>
                                <th>打印备注</th>
                                <td colspan="2">                                                                                                                                                                                                        </td>
                            </tr>           <tr>
                                <th>特殊备注</th>
                                <td colspan="2">                                                                                                                                                                                                        </td>
                            </tr>            <tr>
                            <th>墓证年限</th>
                            <td colspan="2">
                                                                        2012-08-03 至 2032-08-03                                                                 <a ylw-remote-form="true" href="/admin/tomb/editcard?tomb_id=73"> 编辑</a>
                                                  </td>
                        </tr>
                        

                        <tr>
                                                </tr>
                    </tbody>
                </table>
            </div>

                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
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
                                    <td>井振华</td>
                                    <td>暂无</td>
                                    <td>手机：13323346095</td>
                                    <td> </td>
                                    
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
            </div>
            <div class="col-xs-12 tomb-view">
            <div class="item table-responsive" id="dead" loc="loc2">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">逝者信息</span></div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr>
                                <th>姓名</th>
                                <th>籍贯</th>
                                <th>生日</th>
                                <th>祭日</th>
                                <th>是否健在</th>
                                <th>是否刻碑</th>
                                <th>亲人是购墓人的</th>
                                <th>安葬性质</th>
                                <th>预葬时间</th>
                                <th>安葬时间</th>
                            </tr>
                            <tr>
                                 <td>井万亭(男)</td>
                                 <td></td>
                                 <td>
                                                  </td>
                                 <td>
                                                  </td>
                                 <td>
                                    否                 </td>
                                 <td>
                                    是                 </td>
                                 <td>
                                                          父亲                                      </td>
                                 <td>
                                                     骨灰                                                         </td>
                                 <td></td>
                                 <td>0000-00-00 00:00:01                 
                                                  &nbsp;&nbsp;&nbsp;<a href="/admin/dead/savebury_date/id/87750" ylw-remote-form="true" title="修改安葬时间">修改</a>
                                                  
                                 </td>
                             </tr><tr>
                                 <td>张秀珍(女)</td>
                                 <td></td>
                                 <td>
                                                  </td>
                                 <td>
                                                  </td>
                                 <td>
                                    否                 </td>
                                 <td>
                                    是                 </td>
                                 <td>
                                                          母亲                                      </td>
                                 <td>
                                                     骨灰                                                         </td>
                                 <td></td>
                                 <td>2012-08-03 09:05:54                 
                                                  &nbsp;&nbsp;&nbsp;<a href="/admin/dead/savebury_date/id/87751" ylw-remote-form="true" title="修改安葬时间">修改</a>
                                                  
                                 </td>
                             </tr>        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="ins" loc="loc3">
                    <div class="table-header">
                        <i class="icon-credit-card"></i> <span class="title_info">碑文信息 </span>
                        <a class="" target="_blank" href="/admin/ins/detail/id/62">查看碑文详情</a>        <button class="btn disins">显示老碑文</button>
                        </div>
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                    <tr>
                                    <th width="100">字体</th>
                                    <!-- <th width='100'>字体(支付)</th> -->
                                    <!-- <th width='100'>字体(当前)</th> -->
                                    <th width="100">字数</th>
                                    <!--<th width='100'>是否先下后立</th>-->
                                    <th width="100">加急</th>
                                    <th width="100">状态</th>
                                    <!--<th>操作</th>-->
                                </tr>
                                <tr>
                                    <td>华文新魏</td>
                                    <!-- <td>简体</td> -->
                                    <!-- <td>简体</td> -->
                                    <td>41</td>
                                    <!--<td>-->
                                        <!---->
                                        <!--否-->
                                        <!---->
                                    <!--</td>-->
                                    <td>
                                        
                                                            否                </td>
                                    <td>
                                        已确认                </td>
                                    <!--
                                    <td>
                                     <a class="ins_down" rel="confirm-btn" 
                                            href="/admin/ins/exportpy?tomb_id=73" username="匿名用户" tomb_id="73" who_down="0">
                                         <i class="fa fa-arrow-circle-down bigger-130"></i>导出碑文数据
                                     </a>   
                                    </td>
                                    -->
                                </tr>
                                <tr>
                                    <td colspan="5">
                                    <a href="http://www.yagm.com.cn/upload/inscription/00/000/073/real_front_v_3.png" class="artimg">
                                        <img class="image" width="210" alt="碑前文" src="http://www.yagm.com.cn/upload/inscription/00/000/073/real_front_v_3.png">
                                    </a>
                                    <a href="http://www.yagm.com.cn/upload/inscription/00/000/073/real_back_v_1.png" class="artimg">
                                        <img class="image" width="210" alt="碑后文" src="http://www.yagm.com.cn/upload/inscription/00/000/073/real_back_v_1.png">
                                    </a>
                                    </td>
                                </tr>
                                <tr class="oldins hide"><th colspan="5">老碑文信息</th></tr>
                                <tr class="oldins hide">
                                    <td colspan="5">
                                        <a href="" class="artimg ">
                                            <img src="" class="image" width="200" title="碑前文">
                                        </a>
                                        <a href="" class="artimg ">
                                            <img src="" class="image" width="200" title="碑前文">
                                        </a>
                                        <a href="http://www.yagm.com.cn/upload/inscription/00/000/073/real_front_v_3.png" class="artimg ">
                                            <img src="http://www.yagm.com.cn/upload/inscription/00/000/073/real_front_v_3.png" class="image" width="200" title="碑前文">
                                        </a>
                                        <a href="http://www.yagm.com.cn/upload/inscription/00/000/073/real_back_v_1.png" class="artimg ">
                                            <img src="http://www.yagm.com.cn/upload/inscription/00/000/073/real_back_v_1.png" class="image" width="200" title="碑前文">
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="col-xs-12 tomb-view">

                <div class="item table-responsive" id="describe" loc="loc4">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">墓位备注</span>
                        <button type="button" class="btn btn-right btn-xs btn-success add" rel="73" data-toggle="note">添加备注</button>
                    </div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                        <tr>
                                    <th width="150">张芯珠<br>
                                                            </th><td class="note">
                                        <span>添加时间：2012-08-03 11:23:24 <a href="#"></a></span>
                                        <a target="_blank" href="/admin/record/history?id=4583">查看更改记录</a>
                                        <p>客户今天过来安葬，把香炉落下了，客户会在近两个星期内过来拿走</p>
                                    </td>
                                </tr><tr>
                                    <th width="150">王伯佳<br>
                                                            </th><td class="note">
                                        <span>添加时间：2012-08-03 09:03:18 <a href="#"></a></span>
                                        <a target="_blank" href="/admin/record/history?id=4576">查看更改记录</a>
                                        <p>已后联系购墓人的弟弟井振海，13323346095。哥哥年龄大了，办理事情不方便。</p>
                                    </td>
                                </tr>                    </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item" loc="loc5">
                        <div class="table-header">
                            <i class="icon-credit-card"></i> <span class="title_info">石材厂备注</span>
                            <button type="button" class="btn btn-right btn-minier btn-success add" rel="73" rid="4576" data-toggle="inscription">添加备注</button>
                        </div>
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                            <tr>
                                        <th width="150">张芯珠<br>
                                                                </th><td class="note">
                                            <span>添加时间：2012-07-31 08:49:27 <a href="#"></a></span>
                                            <a target="_blank" href="/admin/record/history?id=4544">查看更改记录</a>
                                            <p>母故去，补刻享年“八十八”描铜，订于2012-8-3合提开</p>
                                        </td>
                                    </tr>                    </tbody>
                        </table>
                    </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item" loc="loc6">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">客户描述</span>
                        <button type="button" class="btn btn-right btn-xs btn-success add" rel="93934" data-toggle="description">添加描述</button>
                    </div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                                    <tr><td>
                                暂无备注
                            </td></tr>        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="tombtodo" loc="loc7">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">墓位待办事项</span>
                    <button type="button" class="btn btn-right btn-xs btn-success todo" rel="73" data-toggle="button">添加墓位待办事项</button>
                    </div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr>
                                  <th width="100">添加人</th>
                                  <th>内容</th>
                                  <th width="150">状态</th>
                                  <th width="150">添加时间</th>
                                  <th width="150">操作</th>
                              </tr>
                              <tr>
                                       <td>manage</td>
                                       <td class="content">11111111</td>
                                       <td>未完成</td>
                                       <td>2016-12-08 10:54:39</td>
                                       <td>
                                          <button class="btn todo edit" typ="29">编辑 </button>                         <button class="btn"><a href="/admin/tomb/operate/id/29" class="over">完成</a></button>                     </td>
                                  </tr>        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" loc="loc8">
                  <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">瓷像信息</span></div>
                  <table class="table table-bordered table-condensed table-striped">
                    <tbody>
                        <tr><td>
                    暂无记录
                    </td></tr>        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="prebury" loc="loc9">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">预葬记录</span></div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr><td>
                暂无记录
                </td></tr>        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="car" loc="loc10">
                     <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">派车记录</span></div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr><td>
                暂无记录
                </td></tr>        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="bury" loc="loc11">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">安葬记录</span></div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr>
                                <th>逝者名称</th>
                                <th>预葬时间</th>
                                <th>安葬时间</th>
                                <th>随葬品</th>
                            </tr>
                            <tr>
                                    <td>张秀珍 (女, 母亲, 骨灰)<span style="color:green"> [序号:107009] </span></td>
                                    <td>2012-08-03 10:30:00</td>
                                    <td>2012-08-03 09:05:54</td>
                                    <td></td>
                                </tr>        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="order" loc="loc13">
                    <div class="table-header"><i class="icon-credit-card"></i> 
                        <span class="title_info">墓位订单</span>
                        <span>
                            <a ylw-confirm="true" title="合并" class="btn btn-minier btn-danger radius4" href="/admin/orderinfo/merge?tomb_id=73">
                                    合并未支付订单(慎重)
                                </a>
                        </span>
                    </div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr class="warning">
                                <td colspan="6">订单编号：<a target="_blank" href="/admin/orderinfo/info/id/4355">4355</a> 成交时间：2012-07-31 08:47:55</td>
                            </tr>
                            <tr class="alert alert-danger">
                                <td colspan="6">备注: </td>
                            </tr>
                                        <tr>
                                <th>服务项目</th>
                                <th>价格(元)</th>
                                <!--<th>原价格(元)</th>-->
                                <th>数量</th>
                                <th>应付款(元)</th>
                                <th>状态</th>
                            </tr>
                                         <tr>
                                              <td>西丙二7排1列                                      </td>
                                 <td>0.00</td>
                                 <!--<td>0.00</td>-->
                                 <td>1</td>
                                  <td rowspan="3" style="vertical-align:middle;text-align:center;">
                                    总款：245.00 已付款：245                                     </td>
                                 <td rowspan="3" style="vertical-align:middle;text-align:center;">支付全部</td>             </tr>             <tr>
                                              <td>二次合葬费用                                      </td>
                                 <td>200.00</td>
                                 <!--<td>200.00</td>-->
                                 <td>1</td>
                                               </tr>             <tr>
                                              <td>碑文制作                                      </td>
                                 <td>45.00</td>
                                 <!--<td>45.00</td>-->
                                 <td>1</td>
                                               </tr>        
                                </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="dead" loc="loc14">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">商品购买信息</span></div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr>
                                <th>商品名称</th>
                                <th>单价</th>
                                <th>数量</th>
                                <th>总价</th>
                                <th>使用时间</th>
                                <th width="300">备注</th>
                                <th>状态</th>
                            </tr>
                                    </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="task" loc="loc15">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info"></span></div>
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                    <tr>
                                    <th>任务标题</th>
                                    <th>处理人</th>
                                    <th width="200">任务内容</th>
                                    <th>任务状态</th>
                                    <th>结束时间</th>
                                </tr>
                                                <tr class="main">
                                       <td width="160">
                                         <a href="/admin/notice/detail/id/34751" target="_blank">安葬任务</a>
                                       </td>
                                       <td width="80">李艳敏</td>
                                       <td>西丙二7排1列， 本次安葬亲人：张秀珍(女)， 安葬类型：二次合葬，安葬日期：2012-08-03。</td>
                                       <td width="80">
                                           已完成                   </td>
                                       <td width="100">
                                           
                                           <span id="task-34751">
                                               2012-08-03                       </span>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding:-1px">
                                                                </td>
                                    </tr>
                                  </tbody>
                    </table><div class="table-header"><i class="icon-credit-card"></i> <span class="title_info"></span></div>
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                    <tr>
                                    <th>任务标题</th>
                                    <th>处理人</th>
                                    <th width="200">任务内容</th>
                                    <th>任务状态</th>
                                    <th>结束时间</th>
                                </tr>
                                                <tr class="main">
                                       <td width="160">
                                         <a href="/admin/notice/detail/id/34752" target="_blank">安葬清穴</a>
                                       </td>
                                       <td width="80">李云龙</td>
                                       <td>西丙二7排1列， 本次安葬亲人：张秀珍(女)，安葬类型：二次合葬，安葬日期：2012-08-03 10:30:00。</td>
                                       <td width="80">
                                           已完成                   </td>
                                       <td width="100">
                                           
                                           <span id="task-34752">
                                               2012-08-01                       </span>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding:-1px">
                                                                </td>
                                    </tr>
                                                <tr class="main">
                                       <td width="160">
                                         <a href="/admin/notice/detail/id/34753" target="_blank">安葬清穴</a>
                                       </td>
                                       <td width="80">李云龙</td>
                                       <td>西丙二7排1列， 本次安葬亲人：张秀珍(女)，安葬类型：二次合葬，安葬日期：2012-08-03 10:30:00。</td>
                                       <td width="80">
                                           已完成                   </td>
                                       <td width="100">
                                           
                                           <span id="task-34753">
                                               2012-08-02                       </span>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding:-1px">
                                                                </td>
                                    </tr>
                                                <tr class="main">
                                       <td width="160">
                                         <a href="/admin/notice/detail/id/34754" target="_blank">安葬清穴</a>
                                       </td>
                                       <td width="80">李云龙</td>
                                       <td>西丙二7排1列， 本次安葬亲人：张秀珍(女)，安葬类型：二次合葬，安葬日期：2012-08-03 10:30:00。</td>
                                       <td width="80">
                                           已完成                   </td>
                                       <td width="100">
                                           
                                           <span id="task-34754">
                                               2012-08-03                       </span>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding:-1px">
                                                                </td>
                                    </tr>
                                  </tbody>
                    </table><div class="table-header"><i class="icon-credit-card"></i> <span class="title_info"></span></div>
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                    <tr>
                                    <th>任务标题</th>
                                    <th>处理人</th>
                                    <th width="200">任务内容</th>
                                    <th>任务状态</th>
                                    <th>结束时间</th>
                                </tr>
                                                <tr class="main">
                                       <td width="160">
                                         <a href="/admin/notice/detail/id/34755" target="_blank">清洁任务</a>
                                       </td>
                                       <td width="80">邵珠瑾</td>
                                       <td>西丙二7排1列，本次安葬亲人：张秀珍(女)，安葬类型：二次合葬，立碑日期：0000-00-00 00:00:00。</td>
                                       <td width="80">
                                           已完成                   </td>
                                       <td width="100">
                                           
                                           <span id="task-34755">
                                               2012-08-03                       </span>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding:-1px">
                                                                </td>
                                    </tr>
                                  </tbody>
                    </table><div class="table-header"><i class="icon-credit-card"></i> <span class="title_info"></span></div>
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                    <tr>
                                    <th>任务标题</th>
                                    <th>处理人</th>
                                    <th width="200">任务内容</th>
                                    <th>任务状态</th>
                                    <th>结束时间</th>
                                </tr>
                                                <tr class="main">
                                       <td width="160">
                                         <a href="/admin/notice/detail/id/34756" target="_blank">开穴任务</a>
                                       </td>
                                       <td width="80">李云龙</td>
                                       <td>西丙二7排1列 开穴任务</td>
                                       <td width="80">
                                           已完成                   </td>
                                       <td width="100">
                                           
                                           <span id="task-34756">
                                               2012-08-03                       </span>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding:-1px">
                                                                </td>
                                    </tr>
                                  </tbody>
                    </table><div class="table-header"><i class="icon-credit-card"></i> <span class="title_info"></span></div>
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                    <tr>
                                    <th>任务标题</th>
                                    <th>处理人</th>
                                    <th width="200">任务内容</th>
                                    <th>任务状态</th>
                                    <th>结束时间</th>
                                </tr>
                                                <tr class="main">
                                       <td width="160">
                                         <a href="/admin/notice/detail/id/34757" target="_blank">碑文补字</a>
                                       </td>
                                       <td width="80">卞威卫</td>
                                       <td>西丙二7排1列，本次安葬亲人：张秀珍(女)，安葬类型：二次合葬，立碑日期：0000-00-00 00:00:00，安葬日期：2012-08-03 10:30:00</td>
                                       <td width="80">
                                           已完成                   </td>
                                       <td width="100">
                                           
                                           <span id="task-34757">
                                               2012-08-03                       </span>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding:-1px">
                                                                </td>
                                    </tr>
                                  </tbody>
                    </table><div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">上海天春维修服务</span></div>
                        <table class="table table-bordered table-condensed table-striped">
                            <tbody>
                    <tr>
                                    <th>任务标题</th>
                                    <th>处理人</th>
                                    <th width="200">任务内容</th>
                                    <th>任务状态</th>
                                    <th>结束时间</th>
                                </tr>
                                                <tr class="main">
                                       <td width="160">
                                         <a href="/admin/notice/detail/id/34928" target="_blank">维修任务</a>
                                       </td>
                                       <td width="80">黄伦站</td>
                                       <td> 西丙二7排1，配子盖，修穴口，未刻未描。前地坪有裂纹。</td>
                                       <td width="80">
                                           已完成                   </td>
                                       <td width="100">
                                           
                                           <span id="task-34928">
                                               2012-08-02                       </span>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="padding:-1px">
                                                                </td>
                                    </tr>
                                  </tbody>
                    </table>
                    </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="memorial" loc="loc19">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">墓位纪念馆信息</span></div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr>
                                <th>纪念馆名称</th>
                                <!-- 
                                <th>纪念馆封面</th>
                                 -->
                                <th>纪念馆风格</th>
                                <th>建馆日期</th>
                                <th>访问权限</th>
                            </tr>
                            <tr>
                                <td><a href="/memorial/detail?id=9779" target="_blank">井万亭 张秀珍 </a></td>
                                <!-- 
                                <td><img src=""/></td>
                                 -->
                                <td>ink</td>
                                <td>2012-07-30 23:23:00</td>
                                <td>
                                                        所有人                                        
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                                    </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="photo" loc="loc20">
                     <div class="table-header">
                     <i class="icon-credit-card"></i> <span class="title_info">相册</span> <small>右键相册打包下载</small>
                      </div>
                      <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                            <tr>
                          <td>
                           暂无记录
                          </td>
                        </tr>   </tbody>
                     </table>
                    </div>
            </div>
            <div class="col-xs-12 tomb-view">
                <div class="item table-responsive" id="withdraw" loc="loc22">
                    <div class="table-header"><i class="icon-credit-card"></i> <span class="title_info">退墓记录</span></div>
                    <table class="table table-bordered table-condensed table-striped">
                        <tbody>
                <tr><td>
                暂无记录
                </td></tr>        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>