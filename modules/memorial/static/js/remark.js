
var publishEditor = UE.getEditor('post-msg', {
    toolbars: [['insertimage', 'music', 'insertvideo', 'attachment']],
    initialContent: '',//初始化编辑器的内容
    initialFrameHeight: 150,
	wordCount: false,
    maximumWords: 2000
});

publishEditor.addListener("focus", function () {
    $('#emotion').removeClass('open');
});

publishEditor.ready(function () {
    $("#post-msg>div").css("zIndex", "99")
});

//回复作者
var replyEditor = UE.getEditor('replyEditor', {
    toolbars: [[]],
    initialContent: '',//初始化编辑器的内容
    initialFrameHeight: 30,
    initialFrameWidth: 658,
    wordCount: false,
    maximumWords: 200,
    autoHeightEnabled: false
});

//监听编辑器动作
replyEditor.addListener("click focus blur", function (type) {
    if (type == 'click' || type == 'focus') {
        $('.activeEditor').prev('.placeholder').hide();
        this.setHeight(80);
        $('.activeEditor').siblings('ul').slideDown();
    } else if (type == 'blur') {
        if (!replyEditor.hasContents()) {
            $('.activeEditor').prev('.placeholder').show();
        }
    }
});

replyEditor.ready(function () {
    //阻止工具栏的点击向上冒泡
    $(this.container).click(function (e) {
        e.stopPropagation();
    })
});

$(document).on('click', '.reply-editor', function () {
    loadEditor($(this));
});

$(document).on('click', '.placeholder', function () {
    loadEditor($(this).next('.reply-editor'));
});


var loadEditor = function (obj) {
    var $target = obj;
    var tool = $('.activeEditor').next('ul').html();
    $('.activeEditor').next('ul').remove();
    $('.activeEditor').removeClass('activeEditor');
    $target.addClass('activeEditor');
    $target.html('');
    tool = '<ul>' + tool + '</ul>';
    $target.append(replyEditor.container);
    $target.parent().append(tool);
    replyEditor.reset();
    replyEditor.setHeight(80);
    setTimeout(function () { replyEditor.focus(); }, 100);
    $('.activeEditor').prev('.placeholder').hide();
    $('.activeEditor').siblings('ul').slideDown();
}
var moveEditor = function () {
    if ($('#replyEditor').text()== "")
    {
        $('#replyEditor').html('').append(replyEditor.container);
        var tool = $('.activeEditor').next('ul').html();
        $('.activeEditor').next('ul').remove();
        $('.activeEditor').removeClass('activeEditor');
        tool = '<ul>' + tool + '</ul>';
        $('#replyAuthor').append(tool);
        $('#replyEditor').addClass('activeEditor');
        $('#reply-user').removeClass('hidden').appendTo('body').hide();
    }
}

/*    $('.placeholder').click(function(){
        $(this).hide();
        replyEditor.setHeight(80);
        replyEditor.focus();
        $('#replyEditor').siblings('ul').slideDown();
    });*/

var replyToEditor = UE.getEditor('replyToEditor', {
    toolbars: [[]],
    initialContent: '',//初始化编辑器的内容
    initialFrameHeight: 60,
    wordCount: false,
    autoHeightEnabled: true
});

//监听编辑器动作
replyToEditor.addListener("focus click", function (type) {
    $('.reply-user .placeholder').hide();
});

$(document).on('click', '.reply-user .placeholder', function () {
    $(this).hide();
    replyToEditor.focus();
});

$(document).on("click", "[data-stopPropagation]", function (e) {
    e.stopPropagation();
});


function ChangeValidateMainCode() {
    $("#RemarkOne").attr("src", "/Remark/ValidateMainCode?time=" + (new Date()).getTime());
}

//插入图片
function insertImgDialog() {
    var myFiles = publishEditor.getDialog("insertimage");
    myFiles.open();
}

//插入音乐
function insertMusicDialog() {
    var myFiles = publishEditor.getDialog("attachment");
    myFiles.open();
}
//插入视频
function insertVideoDialog() {
    var myFiles = publishEditor.getDialog("insertvideo");
    myFiles.open();
}

//转换回信关系
function ChangeRelation(ReplyLetterRelationID, MemorialHallID) {
    $.ajax({
        type: "post",
        url: "/Remark/EditMemberAndHallRelation",
        data: {
            ReplyLetterRelationID: ReplyLetterRelationID,
            MemorialHallID: MemorialHallID
        },
        success: function (data) {

        }
    })
}

//显示回信
function ShowRelationText(MemorialHallID) {
    var huixin = 19;
    var relation = $('input[name="relation"]').val();
    $.ajax({
        type: "get",
        url: "/Remark/RemarkReplyLetterInfo",
        data: {
            "Relation": relation,
            "MemorialHallID": MemorialHallID
        },
        success: function (data) {
            $(".reply-mail-dialog").find(".modal-body").html(data);
            var _rand = Math.round(Math.random() * (huixin - 1)) + 1;
            var _huixinClass = "huixin_box_" + _rand;
            $('.reply-mail', '#reply-mail-dialog').addClass(_huixinClass);
            $('#reply-mail-dialog').modal();
        }
    })
    ////是否已经选择关系
    //if (relation) {
    //    var _rand = Math.round(Math.random() * (huixin.length - 1)) + 1;
    //    var _huixinClass = "huixin_box_" + _rand;
    //    $('.reply-mail', '#reply-mail-dialog').addClass(_huixinClass);

    //    $('#reply-mail-dialog').modal();

    //} else {
    //    $('#relationship-dialog').modal();
    //}

}

//读取精选留言
var remarkCustomData = function (node, classId, func) {
    $.ajax({
        type: "get",
        url: "/RemarkCustom/" + classId,
        cache: false,
        beforeSend: function () {
            node.html('<div class="loading"></div>');
        },
        error: function () {
        },
        success: function (data) {
            if (data) {
                node.children('.loading').fadeOut('fast', function () {
                    node.html(data);
                    node.find("li").click(function () {
                        publishEditor.execCommand('inserthtml', $(this).text());
                    })
                    $('#choice-type').change(function () {
                        var _id = $(this).val();
                        remarkCustomData(node, _id);

                    });
                    if (typeof (func) == "function") {
                        func();
                    }
                });
            }
        }
    });
}
//加载精选内容
$('#choice').on('show.bs.dropdown', function () {
    var jxly = $('#jxly');
    jxly.children('.loading').remove();
    var _html = jxly.html();
    if (!_html) {
        remarkCustomData(jxly, '1');
    }
});

//回信关系
$('.relation-list li').on('click', function () {
    $("#fromCommentContent").find("[name=Relation]").val($(this).attr('data-id'));
    $('.show-relation').text($(this).text());
});


$(function () {

    //提交信箱内容
    $("#code").keydown(function (e) {
        e = (e) ? e : ((window.event) ? window.event : "") //兼容IE和Firefox获得keyBoardEvent对象  
        var key = e.keyCode ? e.keyCode : e.which; //兼容IE和Firefox获得keyBoardEvent对象的键值  
        if (key == 13) {
            if (!!window.ActiveXObject || "ActiveXObject" in window)  
            {
                $("#publish-btn").click();
            }
            //$('#publish-btn').trigger("click");
        }
    });

    //举报
    $(document).on('keyup', '#jb-con', function () {
        if ($(this).val().length > 200) {
            $('#cur-num').css('color', '#ff0000');
        } else {
            $('#cur-num').removeAttr('style');
        }
        $('#cur-num').text($(this).val().length);
    });

    $(document).on('show.bs.modal', '.jb-modal', function (e) {
        var self = $(e.relatedTarget);
        var _info = eval('(' + self.attr('data-info') + ')');
        $('#jb-con').val('');
        $('#jb-name').text(_info.name);
        $('#add-report').attr('data-id', _info.id);
        $('#errmsg').addClass('hidden');
        $('.jb-body').removeClass('hidden');
        $('#jb-success').addClass('hidden');
        $('#add-report').removeClass('hidden');
    });

    $(document).on('click', '#add-report', function () {
        var self = $(this);
        var _id = self.attr('data-id');
        if ($('#jb-con').val() == '') {
            $('#errmsg').text('请输入举报原因！').removeClass('hidden');
            return false;
        }
        if ($('#cur-num').val().length > 200) {
            $('#errmsg').text('超出可输入字符！').removeClass('hidden');
            return false;
        }

        $.ajax({
            type: "post",
            url: "",
            data: { id: _id },
            beforeSend: function () {
                $('#errmsg').addClass('hidden');
                self.addClass('disabled');
            },
            error: function () { },
            success: function (data) {
                $('.jb-body').addClass('hidden');
                $('#jb-success').removeClass('hidden');
                self.removeClass('disabled').addClass('hidden');
            }
        });
    });

    //**********************************************************************//
    //发表
    //**********************************************************************//
    $('#publish-btn').unbind("click").click(function () {
        var form = $(this).parents("form");
        var publishbtn = form.find("#publish-btn");
        var oldText = publishbtn.text();
        var MemorialHallID = form.find("[name=MemorialHallID]").val();
        var isValid = form.parsley("validate");
        //var _msg = publishEditor.getContent();
        //var _user = $('#user-name').val();
        //var _pub = $('input[name="p"]:checked').val();
        //var _RelationCall = $("[name=relation]").val(); //回信关系
        //var _CommentMain = {
        //    MemorialHallID: $("[name=MemorialHallID]").val(),
        //    Content: _msg, RelationCall: _RelationCall,
        //    ValidateCode: $("#verification-code").val()
        //};
        var textContent = publishEditor.getPlainTxt();
        if ($.trim(textContent) == "") {
            //new $.Zebra_Dialog("信箱内容不能空！", { 'type': 'warning', 'title': '添加失败' });
            showMsg("信箱内容不能空！", 'error');
            return;
        }
        //if (textContent.length < 2)
        //{
        //    new $.Zebra_Dialog("内容太少，请填入最少2个字符！", { 'type': 'warning', 'title': '添加失败' });
        //    return;
        //}
        if (isValid) {
             var requestData = form.serialize() + "&Content=" + encodeURIComponent(publishEditor.getContent());
            $.ajax({
                type: "post",
                url: "/Remark/AddHallComment",
                beforeSend: function () {
                   publishbtn.text("正在提交...");
                },
                complete: function () {
                    form.find("#RemarkOne").click(); //更换验证码
                    form.find("#code").val(""); //清空验证码
                },
                data: requestData,
                success: function (data) {
                    //if (data.UseObject03 === false) { $("[name=isValidateCode]").show(); }
                    //else { $("[name=isValidateCode]").hide(); }
                    if (data.IsSuccess) {
                        publishEditor.execCommand('cleardoc');
                        $.ajax({
                            type: "get",
                            url: "/Remark/RemarkPage?MemorialHallID=" + MemorialHallID + '&_r=' + Math.random() * new Date().getTime(),
                            beforeSend: function () {
                                moveEditor();
                            },
                            success: function (data) {
                                $("#replayContet").html(data)
                                ShowRelationText(MemorialHallID); //显示回信信息
                            }
                        })

                    }
                    else {
                        new $.Zebra_Dialog(data.Message, { 'type': 'warning', 'title': '添加失败' });
                    }
                    publishbtn.text(oldText);

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    new $.Zebra_Dialog("错误代码：" + XMLHttpRequest.status, { 'type': 'error', 'title': '发表失败' });
                    publishbtn.text(oldText);
                }
            })
        }
    });

    //**********************************************************************//
    //显示回复框
    //**********************************************************************//
    $(document).on('click', '.replyto', function (e) {

        e.stopPropagation();

        replyToEditor.setContent('');

        //隐藏回复作者编辑框
        $('.reply-author').removeClass('hidden');
        $(this).parentsUntil('.publish-content').siblings('.reply-author').addClass('hidden');
        //$(this).parents('.publish-content').find('.reply-author').addClass('hidden')

        /*		_reply_editor_html = $('#reply-user').removeClass('hidden').prop("outerHTML");
                $('#reply-user').slideUp('fast', function(){
                    $(this).remove();
                    self.parent().append(_reply_editor_html);
                    $('#reply-user').hide();
                    $('#reply-user').slideDown('fast');
                });*/

        $('#reply-user').removeClass('hidden').remove().clone().insertAfter($(this).parent()).hide();
        var replyUser = $(this).parent().siblings('a:first-child');
        var reply_user_name = replyUser.text();
        var reply_user_id = replyUser.attr('user-id');
        $('#reply-user').slideDown('fast', function () {
            $('#reply-user .placeholder').show().text('@' + reply_user_name.replace("：", "") + '：');
            $('#reply-user-btn').attr('user-data', '{"UserId":"' + reply_user_id + '","UserName":"' + reply_user_name + '"}');
            replyToEditor.execCommand('inserthtml', '<button contenteditable="false" tabindex="-1" style="border:none;background-color:#FFF;">回复 ' + reply_user_name.replace("：", "") + ':</button>');
            replyToEditor.focus();
        });

        var _w = $(this).parent().width();
        $('#reply-user .edui-editor, #reply-user .edui-editor-iframeholder').css('width', _w - 18);


        return false;
    });

    //**********************************************************************//
    //收起回复框
    //**********************************************************************//
    $(document).click(function (e) {
        var target = $(e.target);
        if (target.closest(".reply-user").length == 0) {
            if (!replyToEditor.hasContents()) {
                $('#reply-user .placeholder').show();
                $('#reply-user').addClass('hidden');
                $("#reply-user").parentsUntil('.p-reply').parent().siblings('.reply-author').removeClass('hidden');
            }
        }

        if (target.closest(".reply-author").length == 0) {
            if (!replyEditor.hasContents()) {
                replyEditor.setHeight(30);
                $('.activeEditor').prev('.placeholder').show();
            }
            $('.activeEditor').siblings('ul').slideUp();
        }
    });

    $(document).on('click', '#cancle-reply-btn', function () {
        $('#reply-user').slideUp();
        $("#reply-user").parentsUntil('.p-reply').parent().siblings('.reply-author').removeClass('hidden');
        return false;
    });

    //**********************************************************************//
    //回复留言
    //**********************************************************************//
    $(document).on('click', '#reply-user-btn', function () {
        var userData = eval("(" + $(this).attr("user-data") + ")")
        var form = $(this).parents("form");
        //保留格式的文本内容
        var _post_msg = replyToEditor.getPlainTxt();
        var replyBtn = $(this);
        var oldText = replyBtn.text();
        _post_msg = _post_msg.replace(/^回复.+:/, '');
        var requestData = form.serialize() + "&Content=" + _post_msg;
        $.ajax({
            type: "post",
            url: "/Remark/AddHallCommentReply",
            data: requestData,
            beforeSend: function () {
                replyBtn.text("正在提交...");
            },
            error: function () {
                replyBtn.text(oldText);
            },
            success: function (data) {
                if (data.IsSuccess) {
                    $('#reply-user').slideUp();
                    var _html = ' <form onsubmit="return false" ><div class="u-cont"><div class="rr-user"><a href="#">'
                                + '<img alt="' + data.UseObject.NickName + '" src="' + data.UseObject.HeadPic + '"></a></div>'
                                + '<div class="rr-cont"><a target="_blank" href="#">' + '' + data.UseObject.NickName + '' + '</a> 回复 <a target="_blank" href="#">' + userData.UserName + '</a> '
                                + data.UseObject.Content
                                + '<p class="post-date">' + data.UseObject.AddDateTime + ' <a href="javascript:;" class="replyto"><span class="postIcon reply"></span>我要回复</a></p>'
                                + '</div><div class="clear"></div></div>'
			                    + '<input type="hidden" name="MemorialHallID" value="' + form.find("[name=MemorialHallID]").val() + '" />'
                                + '<input type="hidden" name="HallCommentMainID" value="' + form.find("[name=HallCommentMainID]").val() + '" />'
                                + '<input type="hidden" name="ParentId" value="' + data.UseObject.HallCommentReplyID + '" />'
                    '</from>';

                    if ($('#reply-user').parent().hasClass('a-cont')) {
                        $('#reply-user').parent().after(_html);
                    } else {
                        $('#reply-user').parent().parent().after(_html);
                    }
                    $("#reply-user").parentsUntil('.p-reply').parent().siblings('.reply-author').removeClass('hidden');
                }
                else {
                    new $.Zebra_Dialog(data.Message, { 'type': 'warning', 'title': '添加失败' });
                }
                replyBtn.text(oldText);
            }
        });

    });


    //**********************************************************************//
    //回复作者
    //**********************************************************************//
    $(document).on('click', '#reply-author-btn', function () {
        var form = $(this).parents("form");
        //获取编辑框内容
        var _post_msg = replyEditor.getPlainTxt();
        if ($.trim(_post_msg) == "") {
            showMsg("回复内容不能空！", 'error');
            return;
        }

        var replyBtn = $(this);
        var oldText = replyBtn.text();
        var requestData = form.serialize() + "&Content=" + _post_msg;
        $.ajax({
            type: "post",
            url: "/Remark/AddHallCommentReply",
            data: requestData,
            beforeSend: function () {
                replyBtn.text("正在提交...");
            },
            error: function () {
                replyBtn.text(oldText);
            },
            success: function (data) {
                if (data.IsSuccess) {
                    //获取日期
                    //var d = new Date();
                    //var t = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                    var _html = '<div class="p-reply"><div class="r-author"><a href="#">' +
                        '<img src="' + data.UseObject.HeadPic + '" alt="' + data.UseObject.NickName + '"/></a></div>' +
                        '<div class="r-user"><form onsubmit="return false"><div class="a-cont">' +
                        '<a data-id="1" href="#" target="_blank">' + data.UseObject.NickName + '：</a>' +
                        data.UseObject.Content +
                        '<p class="post-date">' + data.UseObject.AddDateTime + ' <a class="replyto" href="javascript:;"><span class="postIcon reply"></span>我要回复</a></p>' +
                        '<input type="hidden" name="MemorialHallID" value="' + form.find("[name=MemorialHallID]").val() + '" />' +
                        '<input type="hidden" name="HallCommentMainID" value="' + form.find("[name=HallCommentMainID]").val() + '" />' +
                        '<input type="hidden" name="ParentId" value="' + data.UseObject.HallCommentReplyID + '" />' +
                        '</from></div></div><div class="clear"></div></div>';
                    $('.activeEditor').parent().before(_html);
                    replyEditor.execCommand('cleardoc');
                    replyEditor.blur();
                    replyEditor.setHeight(30);
                    $('.activeEditor').siblings('ul').slideUp();
                    $('.activeEditor').prev('.placeholder').show();
                }
                else {
                    new $.Zebra_Dialog(data.Message, { 'type': 'warning', 'title': '添加失败' });
                }
                replyBtn.text(oldText);
            }
        });
    });

    //评论
    $(document).on('click', '.review', function () {
        var _reply_author = $(this).parentsUntil('.p-tool').parent().siblings('.reply-author');
        _reply_author.children('.reply-editor').click();
        $('html, body').animate({ scrollTop: _reply_author.position().top }, 1000);
        return false;
    });

    //点赞
    $(document).on('click', '.praise', function () {
        var self = $(this);
        var form = $(this).parents("form");
        var _num = self.children('em');
        var _html = '<div class="add-one"><span class="postIcon za"></span></div>';
        $.ajax({
            type: "post",
            url: "/Remark/AddHallCommentMainPraise",
            data: form.serialize(),
            beforeSend: function () {
            },
            error: function () {
            },
            success: function (data) {
                if (data.IsSuccess) {
                    self.parent().append(_html);
                    $('.add-one').animate({ 'top': 0, 'opacity': 0 }, function () {
                        $(this).remove();
                    });
                    _num.text(parseInt(_num.text()) + 1);
                    //用户头像
                    var _user = '<li style="display:none;"><a href="#"><img alt="' + data.UseObject.NickName + '" src="' + data.UseObject.HeadPic + '"></a></li>';
                    self.parentsUntil('.p-tool').parent().siblings('.ttxx-dz').children('ul').children('li').eq(0).fadeIn().after(_user);
                    self.parentsUntil('.p-tool').parent().siblings('.ttxx-dz').children('ul').children('li').eq(1).fadeIn();
                }
                else {
                    new $.Zebra_Dialog(data.Message, { 'type': 'warning', 'title': '添加失败' });
                }
            }
        });
        return false;
    });

    //加载表情
    $(document).on('show.bs.dropdown', '#replyEmotion', function () {
        var _faceHtml = $('#emotions').prop("outerHTML");
        $('#emotions').remove();
        $(this).children('.dropdown-menu').html(_faceHtml);
    });

    $(document).on('show.bs.dropdown', '#replytoEmotion', function () {
        var _faceHtml = $('#emotions').prop("outerHTML");
        $('#emotions').remove();
        $(this).children('.dropdown-menu').html(_faceHtml);
    });

    $(document).on('show.bs.dropdown', '#publishEmotion', function () {
        var _faceHtml = $('#emotions').prop("outerHTML");
        $('#emotions').remove();
        $(this).children('.dropdown-menu').html(_faceHtml);
    });

    (function () {
        var emotions = $('#emotions');
        emotions.children('.loading').remove();
        if (!emotions.html()) {
            $.ajax({
                type: "get",
                url: "/Emotion",
                cache: true,
                beforeSend: function () {
                    emotions.html('<div class="loading"></div>');
                },
                error: function () {
                },
                success: function (data) {
                    if (data) {
                        emotions.children('.loading').fadeOut('fast', function () {
                            emotions.html(data);
                            $.getScript("/resource/Scripts/Memorial/emotion.js");
                        });
                    }
                }
            });
        }
    })();

   
});
