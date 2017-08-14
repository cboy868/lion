<?php
$this->params['current_nav'] = 'record';
$mem = Yii::$app->getAssetManager()->publish(Yii::getAlias('@app/modules/memorial/static/hall'));
$this->registerCssFile($mem[1] . '/css/records.css');

?>
<style type="text/css">
    .date {
        padding:0 15px;
    }
    .date input {
        float: left;
        width: 150px;
        margin-right:3px;
    }
    .date span {
        float:left;
        line-height:30px;
    }
    .date button {
        margin-left:3px;
        float:left;
    }

</style>

<div class="container memorial-container">
    <div class="row">
        <!---------------左边开始----------------->
        <div class="col-md-3 hidden-sm no-padding-right mb20">

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'info','mid'=>Yii::$app->request->get('id')])?>

            <div class="blank"></div>
            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'album','mid'=>Yii::$app->request->get('id')])?>

            <div class="blank"></div>

            <?=\app\modules\memorial\widgets\Mem::widget(['method'=>'track','mid'=>Yii::$app->request->get('id')])?>
        </div>
        <!---------------左边结束----------------->
        <div class="col-md-9 mb20">
            <div class="box">
                <div class="row page-nav">
                    <ul class="list-unstyled">
                        <li class=active><a href="/Memorial/SLList/1/1/69.html">使用中</a></li>
                        <li ><a href="/Memorial/SLList/2/1/69.html">已过期</a></li>
                        <li ><a href="/Memorial/SLList/3/1/69.html">已删除</a></li>

                    </ul>
                    <div class="alert alert-warning" style="position: absolute; color: orangered; padding: 4px 15px; right: 16px; top: 0; width: 400px; ">
                        <strong>温馨提示：</strong>
                        祭品记录数据只读取1年内数据，如果想查看更多请调动日期！
                    </div>
                </div>
                <div class="blank"></div>
                <!---------------右边开始----------------->

                <form method="get" action="/SacrificeLog">
                    <div class="row date">
                        <input name="Name" type="text" class="form-control" placeholder="祭品名字" />
                        <input id="StartDate" type="text" name="StartDate" class="form-control" placeholder="购买开始日期" data-provide="datepicker" data-date-end-date="0d" value="2016-07-22" />
                        <span>-&nbsp;</span>
                        <input id="EndDate" type="text" name="EndDate" class="form-control" placeholder="购买结束日期" data-provide="datepicker" value="2017-07-22" />
                        <input type="hidden" name="sacrificeLogType" value="1" />
                        <input type="hidden" name="id" value="69" />
                        <button type="submit" class="btn btn-default">搜索</button>
                    </div>
                </form>
                <hr />
                <div id="SacrificeLogPageDIV">
                    <div class="main-page">

                        <style type="text/css">
                            .PaginationMain {
                                float: left;
                                text-align: center;
                                /*margin:20px auto;*/
                            }

                            .PaginationMain .Jump {
                                width: 40px;
                                height: 30px;
                                text-align: center;
                                background-color: #fff;
                                background-image: none;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
                                color: #555;
                                font-size: 14px;
                            }

                            .PaginationMain button {
                                margin: -5px 0 0 0;
                            }
                        </style>

                        <div class="memorials-pager">
                            <div style="float:left ">
                                <ul class="pagination pagination-sm m-t-none m-b-none">

                                    <li class="disabled"><a aria-label="Previous" href="javascript:void(0)"><span aria-hidden="true">首页</span></a></li>
                                    <li class="disabled"><a aria-label="Previous" href="javascript:void(0)"><span aria-hidden="true">«上一页</span></a></li>
                                    <li class="active"><a href="javascript:void(0)">1</a></li>
                                    <li>
                                        <a href="/Memorial/SLList/1/2/69.html">2</a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" href="/Memorial/SLList/1/2/69.html"><span aria-hidden="true">下一页»</span></a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" href="/Memorial/SLList/1/2/69.html"><span aria-hidden="true">尾页</span></a>
                                    </li>
                                </ul>
                            </div>
                            <form class="PaginationMain" islocation="true" method="get" id="form47" onsubmit="return false">
                                <div>
                                    &nbsp;
                                    <span style="display:inline-block">共2页,到第</span>
                                    <input class="Jump" name="PageIndex" type="text" value="1" />页&nbsp;
                                    <input name="Keyword" type="hidden" />
                                    <input name="Sort" type="hidden" value="" />
                                    <input name="Order" type="hidden" value="" />
                                    <button class="btn btn-default btn-sm" onclick="GetSubmitUrl(&#39;form47&#39;)" type="submit">确定</button>
                                </div>
                            </form>
                        </div>


                        <script type="text/javascript">
                            var backdropLoading = {
                                create: function (ele) {
                                    var html = '<div class="backdropLoading" style="background-color:#000;background-color:rgba(0,0,0,.6);width:100%;height:100%;position:absolute;left:0;top:0;z-index:99999;">'
                                        + '<div style="position:absolute;top:10px;left:0;color:#fff;font-size:18px;width:100%;text-align:center;">正在加载中...</div>'
                                        + '<div style="position:absolute;bottom:10px;left:0;color:#fff;font-size:18px;width:100%;text-align:center;">正在加载中...</div></div>';
                                    ele = ele ? ele : 'body';
                                    $(ele).css({ 'position': 'relative' }).append(html);
                                },
                                remove: function (ele) {
                                    ele = ele ? ele : 'body';
                                    $('.backdropLoading', ele).remove();
                                }
                            };

                            function GetSubmitUrl(formIdName) {
                                var form = $("#" + formIdName);
                                var PageUrlRule = "/Memorial/SLList/1/{PageIndex}/69.html";
                                if (PageUrlRule != "") {
                                    PageUrlRule = PageUrlRule.replace("{PageIndex}", form.find("[name=PageIndex]").val());
                                    location.href = PageUrlRule;
                                }
                            }

                            function GetAjaxData(url) {
                                $.ajax({
                                    type: "get",
                                    url: url + "&_r=" + Math.random() * new Date().getTime(),
                                    beforeSend: function () {
                                        if ("" == "") {
                                            backdropLoading.create()
                                        }
                                        else {
                                            backdropLoading.create('#');
                                        }
                                    },
                                    success: function (data) {
                                        $("#").html(data);

                                        if ("" == "") {
                                            backdropLoading.remove()
                                        }
                                        else {
                                            backdropLoading.remove('#');
                                        }

                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
                                        if ("" == "") {
                                            backdropLoading.remove()
                                        }
                                        else {
                                            backdropLoading.remove('#');
                                        }
                                    }
                                })
                            }
                        </script>
                    </div>
                    <div class="blank"></div>
                    <!---------------内容开始----------------->
                    <div class="row">
                        <div class="jdjl-list">
                            <ul>
                                <li>
                                    <h4>烧钱</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="烧钱" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/091224175643263.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=576390" href="javascript:void(0)">
                                            波斯猫
                                        </a>
                                        在<span>2017年04月01日18时47分32秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>253天13时58分10秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>西瓜</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="西瓜" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100405140949509.gif"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=576390" href="javascript:void(0)">
                                            波斯猫
                                        </a>
                                        在<span>2017年04月01日18时46分40秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>253天13时57分18秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>花圈</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="花圈" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100405115232681.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=581180" href="javascript:void(0)">
                                            狄国老
                                        </a>
                                        在<span>2017年01月07日13时53分28秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>169天9时4分6秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>花圈</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="花圈" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100405115232681.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=581180" href="javascript:void(0)">
                                            狄国老
                                        </a>
                                        在<span>2017年01月07日13时53分28秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>169天9时4分6秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>普通香</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="普通香" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100413115357414.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=581180" href="javascript:void(0)">
                                            狄国老
                                        </a>
                                        在<span>2017年01月07日13时52分44秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>169天9时3分22秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>粤兴长明灯</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="粤兴长明灯" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100505162655718.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日10时01分52秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时12分30秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>粤兴长明灯</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="粤兴长明灯" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100505162655718.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日10时01分52秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时12分30秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>粤兴长明灯</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="粤兴长明灯" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100505162655718.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日10时01分52秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时12分30秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>粤兴长明灯</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="粤兴长明灯" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100505162655718.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日10时01分52秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时12分30秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>香蕉</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="香蕉" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100405115813415.gif"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日09时52分27秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时3分5秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>香蕉</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="香蕉" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100405115813415.gif"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日09时52分27秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时3分5秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>香蕉</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="香蕉" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100405115813415.gif"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日09时52分27秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时3分5秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>香蕉</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="香蕉" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/100405115813415.gif"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日09时52分27秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时3分5秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>鲜花</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="鲜花" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/bd9661a1e89846b0a979550b65ae8025.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日09时50分04秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时42秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>鲜花</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="鲜花" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/bd9661a1e89846b0a979550b65ae8025.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日09时50分04秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时42秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>鲜花</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="鲜花" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/bd9661a1e89846b0a979550b65ae8025.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日09时50分04秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时42秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>鲜花</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="鲜花" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/bd9661a1e89846b0a979550b65ae8025.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月05日09时50分04秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>136天5时42秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>香炉</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="香炉" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/5a263250319443db89c1280860c4a71f.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月02日14时15分39秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>133天9时26分17秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>烧钱</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="烧钱" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/091224175643263.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月02日14时12分28秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>133天9时23分6秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>烧钱</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="烧钱" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/091224175643263.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月02日14时12分28秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>133天9时23分6秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>烧钱</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="烧钱" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/091224175643263.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月02日14时12分28秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>133天9时23分6秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>烧钱</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="烧钱" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/091224175643263.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月02日14时12分28秒</span>
                                        献于墓园,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>133天9时23分6秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>烧钱</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="烧钱" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/091224175643263.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月02日14时12分28秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>133天9时23分6秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>烧钱</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="烧钱" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/091224175643263.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月02日14时12分28秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>133天9时23分6秒</span>
                                    </div>
                                </li>
                                <li>
                                    <h4>烧钱</h4>
                                    <p><img onload="AutoResizeImage(132, 96, this)" alt="烧钱" src="/UploadFiles/Image/Heaven/Sacrifice/PhotoPath/091224175643263.jpg"></p>
                                    <div>
                                        该祭品由
                                        <a data-toggle="modal" data-target=".user-info-dialog"
                                           data-url="/MemberInfo?id=545250" href="javascript:void(0)">
                                            诗意一一
                                        </a>
                                        在<span>2016年12月02日14时12分28秒</span>
                                        献于灵堂,使用<strong>0</strong>天堂币,有效时间<strong>365</strong>天,还剩余
                                        <span>133天9时23分6秒</span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!---------------内容结束----------------->
                    <div class="main-page">

                        <style type="text/css">
                            .PaginationMain {
                                float: left;
                                text-align: center;
                                /*margin:20px auto;*/
                            }

                            .PaginationMain .Jump {
                                width: 40px;
                                height: 30px;
                                text-align: center;
                                background-color: #fff;
                                background-image: none;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
                                color: #555;
                                font-size: 14px;
                            }

                            .PaginationMain button {
                                margin: -5px 0 0 0;
                            }
                        </style>

                        <div class="memorials-pager">
                            <div style="float:left ">
                                <ul class="pagination pagination-sm m-t-none m-b-none">

                                    <li class="disabled"><a aria-label="Previous" href="javascript:void(0)"><span aria-hidden="true">首页</span></a></li>
                                    <li class="disabled"><a aria-label="Previous" href="javascript:void(0)"><span aria-hidden="true">«上一页</span></a></li>
                                    <li class="active"><a href="javascript:void(0)">1</a></li>
                                    <li>
                                        <a href="/Memorial/SLList/1/2/69.html">2</a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" href="/Memorial/SLList/1/2/69.html"><span aria-hidden="true">下一页»</span></a>
                                    </li>
                                    <li>
                                        <a aria-label="Next" href="/Memorial/SLList/1/2/69.html"><span aria-hidden="true">尾页</span></a>
                                    </li>
                                </ul>
                            </div>
                            <form class="PaginationMain" islocation="true" method="get" id="form83" onsubmit="return false">
                                <div>
                                    &nbsp;
                                    <span style="display:inline-block">共2页,到第</span>
                                    <input class="Jump" name="PageIndex" type="text" value="1" />页&nbsp;
                                    <input name="Keyword" type="hidden" />
                                    <input name="Sort" type="hidden" value="" />
                                    <input name="Order" type="hidden" value="" />
                                    <button class="btn btn-default btn-sm" onclick="GetSubmitUrl(&#39;form83&#39;)" type="submit">确定</button>
                                </div>
                            </form>
                        </div>


                        <script type="text/javascript">
                            var backdropLoading = {
                                create: function (ele) {
                                    var html = '<div class="backdropLoading" style="background-color:#000;background-color:rgba(0,0,0,.6);width:100%;height:100%;position:absolute;left:0;top:0;z-index:99999;">'
                                        + '<div style="position:absolute;top:10px;left:0;color:#fff;font-size:18px;width:100%;text-align:center;">正在加载中...</div>'
                                        + '<div style="position:absolute;bottom:10px;left:0;color:#fff;font-size:18px;width:100%;text-align:center;">正在加载中...</div></div>';
                                    ele = ele ? ele : 'body';
                                    $(ele).css({ 'position': 'relative' }).append(html);
                                },
                                remove: function (ele) {
                                    ele = ele ? ele : 'body';
                                    $('.backdropLoading', ele).remove();
                                }
                            };

                            function GetSubmitUrl(formIdName) {
                                var form = $("#" + formIdName);
                                var PageUrlRule = "/Memorial/SLList/1/{PageIndex}/69.html";
                                if (PageUrlRule != "") {
                                    PageUrlRule = PageUrlRule.replace("{PageIndex}", form.find("[name=PageIndex]").val());
                                    location.href = PageUrlRule;
                                }
                            }

                            function GetAjaxData(url) {
                                $.ajax({
                                    type: "get",
                                    url: url + "&_r=" + Math.random() * new Date().getTime(),
                                    beforeSend: function () {
                                        if ("" == "") {
                                            backdropLoading.create()
                                        }
                                        else {
                                            backdropLoading.create('#');
                                        }
                                    },
                                    success: function (data) {
                                        $("#").html(data);

                                        if ("" == "") {
                                            backdropLoading.remove()
                                        }
                                        else {
                                            backdropLoading.remove('#');
                                        }

                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
                                        if ("" == "") {
                                            backdropLoading.remove()
                                        }
                                        else {
                                            backdropLoading.remove('#');
                                        }
                                    }
                                })
                            }
                        </script>
                    </div>
                </div>
                <!---------------右边结束----------------->
            </div>
        </div>
    </div>
</div>
<div class="blank"></div>
