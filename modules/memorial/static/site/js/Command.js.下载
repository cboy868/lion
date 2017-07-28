var applicationPath = "/";
var DomainUrl = ""
var FormSame = "";
var currentMember = null;


//事件综合函数
var Event = {
    ChangeVerifyCode: function (nodeId) {
        $("#" + nodeId).bind("click", function () {
            this.src = "/Shared/VerifyCode?time=" + (new Date()).getTime();
        });
    },
    ChangeVerifyReplyCode: function (nodeClassId) {
        $("." + nodeClassId).bind("click", function () {
            this.src = "/Remark/VerifyReplyCode?time=" + (new Date()).getTime();
        });
    }
}

//切换事件函数
var Change = {
    VerifyCode: function (nodeId) {
        $("#" + nodeId).attr("src", "/Shared/SendMsgVerifyCode?time=" + (new Date()).getTime());
    }
}

//过滤综合函数
var Filter = {
    UeditorFormat: function (node) {
        var State = true;
        var ANode = $(node.document).find("a");
        var ImgNode = $(node.document).find("img");
        for (var i = 0; i < ANode.size() ; i++) {
            var href = ANode.eq(i).attr("href");
            if (!(href.indexOf("waheaven.com") > -1)) {
                //alert("由于安全性的问题，本站已禁止发表外链");
                new $.Zebra_Dialog("由于安全性的问题，本站已禁止发表外链", { 'type': 'warning', 'title': '保存失败' });
                State = false;
                break;
            }
        }
        if (State) {
            for (var i = 0; i < ImgNode.size() ; i++) {
                var href = ImgNode.eq(i).attr("src");
                if (!(href.indexOf("waheaven.com") > -1)) {
                    //alert("由于安全性的问题，本站已禁止发表外链图片");
                    new $.Zebra_Dialog("由于安全性的问题，本站已禁止发表外链", { 'type': 'warning', 'title': '保存失败' });
                    State = false;
                    break;
                }
            }
        }
        return State;
    },
    ClearHref: function (node) {
        var State = true;
        var ANode = $(node.document).find("a");
        var ImgNode = $(node.document).find("img");
        for (var i = 0; i < ANode.size() ; i++) {
            var href = ANode.eq(i).attr("href");
            if (!(href.indexOf("waheaven.com") > -1)) {
                //alert("由于安全性的问题，本站已禁止发表外链");
                ANode.eq(i).attr("href", "javascript:void(0)");
                break;
            }
        }
        for (var i = 0; i < ImgNode.size() ; i++) {
            var href = ImgNode.eq(i).attr("src");
            if (!(href.indexOf("waheaven.com") > -1)) {
                //alert("由于安全性的问题，本站已禁止发表外链图片");
                new $.Zebra_Dialog("由于安全性的问题，本站已禁止发表外链", { 'type': 'warning', 'title': '保存失败' });
                State = false;
                break;
            }
        }
        return State;
    }
}

//图片自动按比例
function AutoResizeImage(maxWidth, maxHeight, objImg) {
    var img = new Image();
    img.src = objImg.src;
    var hRatio;
    var wRatio;
    var Ratio = 1;
    var w = img.width;
    var h = img.height;
    wRatio = maxWidth / w;
    hRatio = maxHeight / h;
    if (maxWidth == 0 && maxHeight == 0) {
        Ratio = 1;
    } else if (maxWidth == 0) {//
        if (hRatio < 1) Ratio = hRatio;
    } else if (maxHeight == 0) {
        if (wRatio < 1) Ratio = wRatio;
    } else if (wRatio < 1 || hRatio < 1) {
        Ratio = (wRatio <= hRatio ? wRatio : hRatio);
    }
    if (Ratio < 1) {
        w = w * Ratio;
        h = h * Ratio;
    }
    objImg.height = h;
    objImg.width = w;
}


//手机号码的验证 
function ValidateMobile(mobile) {
    if (mobile.length != 11) { return false; }
    var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|147|177)+\d{8})$/;
    if (!myreg.test(mobile)) { return false; }
    return true;
}

//电子邮件的验证 
function CheckEmail(email) {
    var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if (email.value == "") { return false; }
    if (!myreg.test(email)) { return false; }
    return true;
}
//日历对象
function GetJosnSaintDate(id) {
    return {
        "gongli": {
            "id": $("#" + id).find("[name=gongli]>option:selected").val(),
            "text": $("#" + id).find("[name=gongli]>option:selected").html()
        },
        "gongyuan": {
            "id": $("#" + id).find("[name=gongyuan]>option:selected").val(),
            "text": $("#" + id).find("[name=gongyuan]>option:selected").html()
        },
        "tiangan": {
            "id": $("#" + id).find("[name=tiangan]>option:selected").val(),
            "text": $("#" + id).find("[name=tiangan]>option:selected").html()
        },
        "dizhi": {
            "id": $("#" + id).find("[name=dizhi]>option:selected").val(),
            "text": $("#" + id).find("[name=dizhi]>option:selected").html()
        },
        "nian": {
            "id": $("#" + id).find("[name=nian]").val(),
            "text": $("#" + id).find("[name=nian]").val()
        },
        "gongliyue": {
            "id": $("#" + id).find("[name=gongliyue]>option:selected").val(),
            "text": $("#" + id).find("[name=gongliyue]>option:selected").html()
        },
        "nongliyue": {
            "id": $("#" + id).find("[name=nongliyue]>option:selected").val(),
            "text": $("#" + id).find("[name=nongliyue]>option:selected").html()
        },
        "gongliri": {
            "id": $("#" + id).find("[name=gongliri]>option:selected").val(),
            "text": $("#" + id).find("[name=gongliri]>option:selected").html()
        },
        "nongliri": {
            "id": $("#" + id).find("[name=nongliri]>option:selected").val(),
            "text": $("#" + id).find("[name=nongliri]>option:selected").html()
        }
    }
}


//关注纪念馆
function Care(MemorialHallid, obj) {
    $.ajax({
        type: "post",
        url: "/Memorial/CareMemorialHall",
        beforeSend: function () { },
        data: { MemorialHallID: MemorialHallid },
        success: function (data) {
            //关注成功
            if (data.IsSuccess == true) {
                $(obj).find("span").html(data.Message);
                //$(obj).html($(obj).html().replace("我要关注", data.Message));
            }
                //关注失败
            else {
                new $.Zebra_Dialog(data.Message, {
                    'type': 'error',
                    'title': '关注出错'
                });
            }
        },
        complete: function () { },
        //关注出错
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            new $.Zebra_Dialog('<strong>错误代码:</strong>' + XMLHttpRequest.status, {
                'type': 'error',
                'title': '保存失败！'
            });
        }
    })
}
//登陆框
var _LoginDialog;
function LoginPanel(fun) {
    var url = '/Account/LoginPanel';
    if (fun != undefined) {
        url = '/Account/LoginPanel?fun=' + fun;
    }
    if ($(".ZebraDialog_Body").find("[name=UserNo]").size() > 0) {
        return;
    }
    LoginDialog = new $.Zebra_Dialog('', {
        'source': { 'ajax': url },
        width: 700, height: 300, overlay_close: false,
        'type': '',
        'title': '登录',
        'position': ['top + 30'],
        'buttons': [
           {
               caption: '确定', callback: function () { Login(fun); },
               caption: '取消', callback: function () { }
           }
        ]
    });
    $(".ZebraDialogOverlay").css("zIndex", 800);
    $(".ZebraDialog").css("zIndex", 801);
}
//登陆

function Login(fun) {
    var Form = $("#mianFormLogin");
    var LoginBtn = $("#LoginPanel").find("button");
    var LoginBtnText=LoginBtn.text();
    if (Form.valid()) {
        $.ajax({
            type: "post",
            url: "/Account/LoginToPanel",
            beforeSend: function () {
                LoginBtn.addClass("disabled").text("正在登录...");
            },
            data: Form.serialize(),
            success: function (data) {
                if (data.IsSuccess) {
                    location.reload();
                }
                else {
                    var zIndex = $(".ZebraDialogOverlay").last().css("zIndex");
                    new $.Zebra_Dialog(data.Message, { 'type': 'error', 'title': '登录失败' });
                    $(".ZebraDialogOverlay").last().css("zIndex", (parseInt(zIndex) + 1))
                }
                LoginBtn.removeClass("disabled").text(LoginBtnText);
            },
            complete: function () {
                $("#changeVerifyCodeLoginPanel").click();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                LoginBtn.removeClass("disabled").text(LoginBtnText);
                new $.Zebra_Dialog("错误代码：" + XMLHttpRequest.status, { 'type': 'error', 'title': '登录失败' });
            }
        })
        $(".ZebraDialogOverlay").css("zIndex", 800);
        $(".ZebraDialog").css("zIndex", 801);
    }
}
//检查是否登陆
function CheckLogin(fun) {
    var islogin = false;
    $.ajax({
        type: "post",
        url: "/Account/CheckLogin",
        data: {},
        async: false,
        success: function (data) {
            if (data.IsSuccess == true) { islogin = true; }
            else {
                islogin = false;
                new $.Zebra_Dialog('<strong>登录</strong>后才可以执行此操作', {
                    'type': '', 'title': '登录',
                    'buttons': [{ caption: '登录', callback: function () { LoginPanel(fun); } }, { caption: '取消', callback: function () { } }]
                });
            }
            return data.IsSuccess;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            new $.Zebra_Dialog('<strong>错误代码:</strong>' + XMLHttpRequest.status, { 'type': 'error', 'title': '保存失败！' });
        }
    })
    return islogin;
}
function isLogin() {
    var islogin = false;
    $.ajax({
        type: "post",
        url: "/Account/CheckLogin",
        data: {},
        async: false,
        success: function (data) {
            if (data.IsSuccess == true) { islogin = true; }
            else { islogin = false; }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            new $.Zebra_Dialog('<strong>错误代码:</strong>' + XMLHttpRequest.status, { 'type': 'error', 'title': '保存失败！' });
        }
    })
    return islogin;
}
//祈福
function Vote(MemorialHallid, obj) {
    var fun = function (MemorialHallid, obj) { Vote(MemorialHallid, obj); };
    $.ajax({
        type: "post",
        url: "/Memorial/VoteMemorialHall",
        beforeSend: function () { },
        data: { MemorialHallID: MemorialHallid },
        success: function (data) {
            //祈福成功
            if (data.IsSuccess == true) {
                $(obj).html($(obj).html().replace("我要祈福", "您已祈福"));
                var voteCount = $(".visit");
                voteCount.html(parseInt(voteCount.text()) + 1);
            }
                //祈福失败
            else {
                new $.Zebra_Dialog(data.Message, {
                    'type': 'warning',
                    'title': '提示'
                });
            }
        },
        complete: function () { },
        //祈福出错
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            new $.Zebra_Dialog('<strong>错误代码:</strong>' + XMLHttpRequest.status, {
                'type': 'error',
                'title': '保存失败！'
            });
        }
    })
}
//去除HTML标签
function removeHTMLTag(str) {
    if (!str) { return ""; }
    str = str.replace(/<\/?[^>]*>/g, ''); //去除HTML tag
    str = str.replace(/[ | ]*\n/g, '\n'); //去除行尾空白
    str = str.replace(/\n[\s| | ]*\r/g, '\n'); //去除多余空行
    str = str.replace(/ /ig, '');//去掉 
    return str;
}
//复制 支持IE，firefox
function copy_clip(txt) {
    if (window.clipboardData) {
        window.clipboardData.clearData();
        window.clipboardData.setData("Text", txt);
    } else if (navigator.userAgent.indexOf("Opera") != -1) {
        window.location = txt;
    } else if (window.netscape) {
        try {
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
        } catch (e) {
            alert("您的firefox安全限制限制您进行剪贴板操作，请在新窗口的地址栏里输入'about:config'然后找到'signed.applets.codebase_principal_support'设置为true'");
            return false;
        }
        var clip = Components.classes["@mozilla.org/widget/clipboard;1"].createInstance(Components.interfaces.nsIClipboard);
        if (!clip)
            return;
        var trans = Components.classes["@mozilla.org/widget/transferable;1"].createInstance(Components.interfaces.nsITransferable);
        if (!trans)
            return;
        trans.addDataFlavor('text/unicode');
        var str = new Object();
        var len = new Object();
        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
        var copytext = txt;
        str.data = copytext;
        trans.setTransferData("text/unicode", str, copytext.length * 2);
        var clipid = Components.interfaces.nsIClipboard;
        if (!clip)
            return false;
        clip.setData(trans, null, clipid.kGlobalClipboard);
    }
}

//格式化时间(new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423 
//          (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18 
Date.prototype.Format = function (fmt) { //author: meizz 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
function JsonDateFormat(adddatetime) {
    var startIndex = adddatetime.indexOf("(") + 1;
    var endIndex = adddatetime.indexOf(")");
    var Date_date = new Date(parseInt(adddatetime.substring(startIndex, endIndex)));
    return Date_date;
}

//是否安装了flash
//兼容火狐和IE。
var isFlash = function () {
    var isIE = !-[1, ];
    if (isIE) {
        try {
            var swf1 = new ActiveXObject('ShockwaveFlash.ShockwaveFlash'); return true;
        } catch (e) { return false }
    } else {
        try {
            var swf2 = navigator.plugins['Shockwave Flash']; if (swf2 == undefined) { return false } else { return true; }
        } catch (e) {
            return false
        }
    }
}
//自动变化相册
//function GetAllImgPath() {
//    var arrimg = document.getElementsByName("imgpath");
//    if (arrimg != null) {
//        var rand = Math.floor(Math.random() * (arrimg.length));
//        if (arrimg[rand]) { document.getElementById("photo_pic").setAttribute("src", arrimg[rand].value); }
//        setTimeout("GetAllImgPath()", 6000);
//    }
//}

//菜单选择
function toolbarSelect(node) {
    var locationHref = location.href.replace("http://" + location.hostname, "");
    locationHref = locationHref.replace("#", "");

    node.parents("ul").find(".active").removeClass("active");
    if (locationHref == "" || locationHref == "/") {
        node.eq(0).parent().addClass("active");
    }
    else {
        var isFind = false;
        var locationHrefs = /(\w+)\/?(\w+)?\/?(\w+)?/.exec(locationHref);
        for (var i = 0; i < node.size() ; i++) {
            if (node.eq(i).attr("key") != undefined) {
                var liHref = node.eq(i).attr("key").split(',');
                for (var j = 0; j < liHref.length; j++) {
                    for (var k = 0; k < locationHrefs.length; k++) {

                        if (liHref[j] == locationHrefs[k]) {
                            node.eq(i).parent().addClass("active");
                            isFind = true;
                            break;
                        }
                    }
                    if (isFind) {
                        break;
                    }
                }
                if (isFind) {
                    break;
                }
            }
            else {
                break;
            }
        }
        if (!isFind) {
            node.eq(0).parent().addClass("active");
        }

    }

}

//show message
var showMsg = function (msg, className, func) {
    var message = $("#show_msg");
    message.children("strong").text(msg);
    var width = message.width();
    var height = message.height();
    var windowWidth = document.documentElement.clientWidth;
    var windowHeight = document.documentElement.clientHeight;
    var setLeft = (windowWidth - width) / 2;
    var setTop = (windowHeight - height) / 2 + $(window).scrollTop();
    message.stop();
    message.css({
        "left": setLeft,
        "top": 0,
        "opacity": 0
    });
    if (className == 'error') {
        message.children('span').removeAttr('class').addClass('glyphicon glyphicon-remove');
    } else {
        message.children('span').removeAttr('class').addClass('glyphicon glyphicon-ok');
    }
    message.addClass(className).show().animate({
        "top": setTop,
        "opacity": 1
    }, 600);

    var _t = setTimeout(function () {
        message.animate({
            "opacity": .3
        }, 600, function () {
            $(this).removeClass(className).removeAttr('style');
            clearTimeout(_t);
            if (typeof (func) == "function") {
                func();
            }
        });
    }, 2000);
}

//处理页面加载函数
function LoadAjaxModal(title, url, modalId, func) {
    $(document).off('shown.bs.modal').on('shown.bs.modal', "#" + modalId, function (e) {
        var node = $(this);
        $.ajax({
            type: "get",
            url: url,
            beforeSend: function () {
                node.find(".modal-body").html("正在加载...");
            },
            success: function (data) {
                node.find(".modal-header").html(title);
                node.find(".modal-body").html(data);
                if (typeof (func) == "function") {
                    func();
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                node.find(".modal-header").html("错误信息");
                node.find(".modal-body").html("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusTex);
            }
        })
    });
    $("#" + modalId).unbind().modal();
}

//通用提交表单
function SubForm(formId) {
    var status = true;
    var form = $("#" + formId);
    var isValid = form.parsley("validate");
    var btn_submit = form.find("[type=submit]");
    var beginvalid = form.attr("beginvalid"); //开始验证
    var callback = form.attr("callback");
    var OldText = btn_submit.text();
    if (isValid) {
        if (beginvalid) {
            var status = eval(beginvalid)(form);
        }
        if (status) {
            $.ajax({
                type: "post",
                url: form.attr("action"),
                beforeSend: function () {
                    if (btn_submit != undefined) {
                        btn_submit.addClass("disabled").text("正在提交...");
                    }
                },
                data: form.serialize(),
                success: function (data) {
                    if (callback) {
                        eval(callback)(data);
                    }
                    if (btn_submit != undefined) {
                        btn_submit.removeClass("disabled").text(OldText);
                    }
                }
      , error: function (XMLHttpRequest, textStatus, errorThrown) {
          alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
          if (btn_submit != undefined) {
              btn_submit.removeClass("disabled").text(OldText);
          }
        }
        })
        }
    }
}


//设置上传头像
/*
i:Img节点的name值
v:input节点隐藏name值
w:宽度
h:高度
f:form表单名
*/
function UpLoadHeadImg(i, v, w, h, f, func) {

    $(document).off('shown.bs.modal').on('shown.bs.modal', "#UpLoadImg", function (e) {
        var node = $(this).find(".modal-body").find(".row");
        if ((FormSame != f) || ($.trim(node.text()) == "")) {
            $.ajax({
                type: "get",
                url: "/UpLoadHeadImg",
                beforeSend: function () {
                    node.html("正在加载....");
                },
                data: {
                    "i": i,
                    "v": v,
                    "w": w,
                    "h": h,
                    "f": f,
                    _r: Math.random() * new Date().getTime()
                },
                success: function (data) {
                    node.html(data);
                }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
                    node.html("");
                }
            })
        }
        FormSame = f;
    })
    $("#UpLoadImg").unbind().modal();
    $("#Btn_SaveHeadImg").unbind("click").click(function () {
        var imgsrc = $("#form_crop").find("[name=imgsrc]").val();
        if (imgsrc == "") {
            alert("请上传图片再进行，保存操作！");
        }
        else {
            SaveImg(func);
        }

    })
}

//更新头像
function EditHeadImg(formId) {
    var form = $("#" + formId);
    var action = form.attr("action")
    $.ajax({
        type: "post",
        url: action,
        data: form.serialize(),
        success: function (data) {
            if (data.IsSuccess) {
                //不处理
            }
            else {
                alert(data.Message);
            }
        }
    })
}



//验证登录函数
function CheckShopLogin(func, options) {
    $.ajax({
        type: "post",
        beforeSend: function () {

        },
        url: "/Account/CheckLogin",
        success: function (data) {
            if (data.IsSuccess) {
                currentMember = data.UseObject;
                if (typeof (func) == "function") {
                    func();
                }
            }
            else {
                LoginShop(options);
            }
        }, error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
        }
    })
}

//登录函数
function LoginShop(options) {
    var btnLogin = $("#btn_login");
    var data = $.extend({
        "NextZindex": 100059,
        "PreZindex": 100051,
    }, options)

    $('#loginDialog').on('show.bs.modal', function (e) {
        $('.modal-backdrop').css({ 'z-index': data.NextZindex });
    })
    $('#loginDialog').on('hidden.bs.modal', function () {
        $('.modal-backdrop').css({ 'z-index': data.PreZindex });
    });
    $("#loginDialog").modal(); //显示登录
    $('#loginForm').find("[name=ImgVerifyCode]").click();
    $('#loginForm').checkForm(function (status, data) {
        if (status) {
            $.ajax({
                type: "post",
                url: "/Account/Login",
                beforeSend: function () {
                    btnLogin.addClass('disabled').text('正在登录中...');
                },
                data: data,
                success: function (data) {
                    if (data.IsSuccess) {
                        $('#loginDialog').modal('hide');
                    }
                    else {
                        $("#loginMsg").html(data.Message);

                    }
                    btnLogin.removeClass('disabled').text("登录");
                    $('#loginForm').find("[name=ImgVerifyCode]").click();
                }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
                    btnLogin.removeClass('disabled').text("登录");
                }
            })
        }
    });
}

//主页登录
function LoginIndex(node) {
    var self = $(node);
    var form = self.parents("form");
    var userName = form.find("[name=userName]");
    var userPassword = form.find("[name=userPassword]");
    var errmsg = form.find("#error-message");
    if ($.trim(userName.val()) == "") {
        //errmsg.text("请输入用户名！").parent().show();
        showMsg("请输入用户名！", 'error');
        userName.focus();
        return;
    }
    if ($.trim(userPassword.val()) == "") {
        //errmsg.text("请输入密码！").parent().show();
        showMsg("请输入密码！", 'error');
        userPassword.focus();
        return;
    }
    $.ajax({
        type: "post",
        url: "/Account/LoginIndex",
        beforeSend: function () {
            self.addClass('disabled').text('正在登录中...');
        },
        data: form.serialize(),
        success: function (data) {
            if (data.IsSuccess) {
                location.reload();
            }
            else {
                //errmsg.text(data.Message).parent().hide().fadeIn("slow");
                showMsg(data.Message, 'error');
                form.find("[name=userPassword]").val("").focus();
            }
            self.removeClass('disabled').text("登录");
        }, error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusText)
            self.removeClass('disabled').text("登录");
        }
    })
}


(function ($) {
    // 验证表单
    $.fn.checkForm = function (callback, options) {
        var root = this;
        var isok = false;
        var defaults = {
            tips_success: '',
            tips_required: '不能为空',
            tips_email: '邮箱地址格式有误',
            tips_num: '请填写数字',
            tips_chinese: '请填写中文',
            tips_mobile: '手机号码格式有误',
            tips_idcard: '身份证号码格式有误',
            tips_phone: '电话格式有误',
            tips_code: '验证码不正确',
            reg_email: /^\w+\@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/i,  //验证邮箱
            reg_num: /^\d+$/,                                  //验证数字
            reg_chinese: /^[\u4E00-\u9FA5]+$/,                 //验证中文
            reg_mobile: /^1[3458]{1}[0-9]{9}$/,                //验证手机
            reg_idcard: /^\d{14}\d{3}?\w$/,                    //验证身份证
            reg_phone: /^([2-9][0-9]{6,7})/
        };

        if (options)
            $.extend(defaults, options);

        $(":text,:password,:hidden,textarea", root).each(function () {
            $(this).blur(function () {
                var _validate = $(this).attr("check");
                if (_validate) {
                    var arr = _validate.split(' ');
                    for (var i = 0; i < arr.length; i++) {
                        if (!check($(this), arr[i], $(this).val()))
                            return false;
                        else
                            continue;
                    }
                }
            })
        })

        function _onSubmit() {
            isok = true;
            var callbackdata = '';
            $(":text,:password,:hidden,textarea", root).each(function () {
                var _validate = $(this).attr("check");
                callbackdata += '&' + $(this).attr('name') + "=" + $(this).val() + "";
                if (_validate) {
                    var arr = _validate.split(' ');
                    for (var i = 0; i < arr.length; i++) {
                        if (!check($(this), arr[i], $(this).val())) {
                            isok = false;
                            return;
                        }
                    }
                }

            });

            if (callback) {

                callback(isok, callbackdata.substr(1));
                isok = false;
            }
        }
        //判断当前对象是否为表单，如果是表单，则提交时要进行验证
        if (root.is("form")) {
            root.unbind().bind("submit", function () {
                _onSubmit();
                return false;
            })
        }
        //验证方法
        var check = function (obj, _match, _val) {
            switch (_match) {
                case 'required':
                    return _val ? showMsg(obj, defaults.tips_success, true) : showMsg(obj, obj.attr('errmsg'), false);
                case 'email':
                    return chk(_val, defaults.reg_email) ? showMsg(obj, defaults.tips_success, true) : showMsg(obj, defaults.tips_email, false);
                case 'num':
                    return chk(_val, defaults.reg_num) ? showMsg(obj, defaults.tips_success, true) : showMsg(obj, defaults.tips_num, false);
                case 'chinese':
                    return chk(_val, defaults.reg_chinese) ? showMsg(obj, defaults.tips_success, true) : showMsg(obj, defaults.tips_chinese, false);
                case 'mobile':
                    return chk(_val, defaults.reg_mobile) ? showMsg(obj, defaults.tips_success, true) : showMsg(obj, defaults.tips_mobile, false);
                case 'idcard':
                    return chk(_val, defaults.reg_idcard) ? showMsg(obj, defaults.tips_success, true) : showMsg(obj, defaults.tips_idcard, false);
                case 'phone':
                    return chk(_val, defaults.reg_phone) ? showMsg(obj, defaults.tips_success, true) : showMsg(obj, defaults.tips_phone, false);
                    //case 'code': //ajaxCode(obj, _val);
                    //    break;
                default:
                    return true;
            }
        }

        //正则匹配
        var chk = function (str, reg) {
            return reg.test(str);
        }
        //显示信息
        var showMsg = function (obj, msg, mark) {
            $(obj).siblings("div").remove();
            var _html = '<div style="display:inline-block;vertical-align:middle;"><i class="formIcon err"></i><span style="color:red;width:auto;text-align:left;">' + msg + '</span></div>';
            if (mark) {
                _html = "";
                //_html = '<div style="display:inline-block;vertical-align:middle;"><i class="formIcon ok"></i></div>';
            }
            obj.parent().append(_html);
            return mark;
        }
    }
})(jQuery);

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};


function openSinaMicroblogLoginUI() {
    window.open('/Account/LoginSinaWeibo');
}

function openQzoneLogin() {
    window.open("/Account/LoginQQ");
    // window.open("/Account/LoginQQ", 'QQ绑定', 'height=400, width=600, top=0,left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no');
}

$(function () {
    $("#customerService a").hover(function () {
        $(this).stop().animate({ marginRight: '0px' }, 'normal');
    }, function () {
        $(this).stop().animate({ marginRight: '-80px' }, 'normal', function () { });

    });
    $("#top_btn").click(function () { if (scroll == "off") return; $("html,body").animate({ scrollTop: 0 }, 300); });

    $("#customerService a").hover(function () {
        var attr = $(this).attr('data-type');
        if (attr == 'weixin') {
            $('.cs-attention').fadeIn('fast');
        }
        $(this).stop().animate({ marginRight: '0px' }, 'fast');
    }, function () {
        var attr = $(this).attr('data-type');
        if (attr == 'weixin') {
            $('.cs-attention').fadeOut('fast');
        }
        $(this).stop().animate({ marginRight: '-80px' }, 'fast', function () { });
    });

    $('.user-info-dialog').on('show.bs.modal', function (e) {
        var self = $(this);
        var btn = $(e.relatedTarget);
        var url = btn.attr('data-url');
        $.ajax({
            type: "get",
            url: url,
            success: function (data) {
                self.html(data);
            }
        })
    })
})


