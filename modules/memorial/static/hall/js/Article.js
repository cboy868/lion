//添加追忆文章
function AddMemorialArticle(MemorialArticleType, MemorialHallID) {
    LoadAjaxModal('添加追忆文章', '/Article/AddView?MemorialArticleType=' + MemorialArticleType + '&MemorialHallID=' + MemorialHallID + '','ArticleModal',function () {
        $("#ArticleModal").find("#submit").attr("onclick", "SubForm('formArticle')");
    });
    //_z = undefined;
    //if (_z) { _z.show(); return; }
    //_z = new $.Zebra_Dialog('', {
    //    'type': '', width: 835, height: 600,
    //    'title': '添加', noClose: true, onClose: true, overlay_close: false,
    //    'source': { 'ajax': '/Article/AddView' },
    //    'position': ['top + 30'],
    //    'buttons': [
    //        {
    //            caption: '确定', callback: function () {
    //                var _content = Ueditor.getContent();
    //                var _title = $("#UEditorControl").find("[name=Title]").val();
    //                var _CSSFileName = $("#UEditorControl").find("[name=CSSFileName]").val();
    //                if (_title == "" || _content == "") {
    //                    var zIndex = $(".ZebraDialogOverlay").last().css("zIndex");
    //                    new $.Zebra_Dialog('<strong>标题</strong>&nbsp;不能为空<br><strong>内容</strong>&nbsp;不能为空', { 'type': '', 'title': '错误提示' });
    //                    $(".ZebraDialogOverlay").last().css("zIndex",(parseInt(zIndex) + 1 ))
    //                    return;
    //                }
    //                $.ajax({
    //                    type: "post",
    //                    dataType: "json",
    //                    url: "/Article/AddArticle",
    //                    data: { MemorialHallID: MemorialHallID, Title: _title, Content: _content, CSSFileName: _CSSFileName, MemorialArticleType: MemorialArticleType },
    //                    success: function (data) {
    //                        //添加成功
    //                        if (data.IsSuccess == true) {
    //                            $("#UEditorControl").find("[name=Title]").val('');
    //                            Ueditor.setContent('');
    //                            _z.hide();
    //                            var _html =
    //                                '<li><h4><a href="/Memorial/ReView/' + data.Information + '.html">' + data.UseObject.Title + '</a></h4>' +
    //                                '<div class="new-cont">' + data.UseObject.Content + '</div>' +
    //                                '<div class="new-data"><span>发布人：<a href="javascript:void(0)">' + data.UseObject.Member.NickName + '</a></span><span>阅读（0）</span><span>评论（0)次）' +
    //                                '</span><span>点赞（0)次）</span><span>打赏（0)个天堂币）</span><span>发布时间:' + data.UseObject.AddDateTime + '</span></div></li>';
    //                            $(".news-list>ul").prepend(_html);
    //                            new $.Zebra_Dialog('<a target="_blank" href="/Memorial/ReView/' + data.Information + '.html">立即查看我的追忆吧</a>', { 'type': 'confirmation', 'title': '成功' });
    //                        }
    //                            //添加失败
    //                        else {
    //                            new $.Zebra_Dialog(data.Message, { 'type': '', 'title': '添加失败' });
    //                        }
    //                    },
    //                    error: function (XMLHttpRequest, textStatus, errorThrown) {
    //                        new $.Zebra_Dialog('<strong>错误代码:</strong>' + XMLHttpRequest.status, { 'type': 'error', 'title': '保存失败！' });
    //                    }
    //                })
    //            }
    //        },
    //        { caption: '取消', callback: function () { _z.hide(); } }]
    //});

    //$(".ZebraDialogOverlay").css("zIndex", 800);
    //$(".ZebraDialog").css("zIndex", 801);
}

var _z;
//添加一生大事
function AddLifeMerit(MemorialArticleType, formName) {
    var form = $("#" + formName);
    if (_z) { _z.show(); return; }
    _z=new $.Zebra_Dialog('', {
        'type': '', width: 835, height: 600,
        'title': '一生大事', noClose: true, onClose: true, overlay_close: false,
        'source': { 'ajax': '/LifeMerit/LifeMeritAdd?UEditorContent=' },
        'position': ['top + 30'],
        'buttons': [
            {
                caption: '确定', callback: function () {
                    var MemberID = form.find("[name=MemberID]").val();
                    var MemorialHallid = form.find("[name=MemorialHallID]").val();
                    var DeceasedInformationId = form.find("[name=DeceasedInformationId]").val();
                    var _content = Ueditor.getContent();
                    var _title = $("#UEditorControl").find("[name=Title]").val();
                    var _HappenTime = $("#UEditorControl").find("[name=HappenTime]").val();
                    if (_title == "" || _content == "" || _HappenTime == "") {
                        var zIndex = $(".ZebraDialogOverlay").last().css("zIndex");
                        new $.Zebra_Dialog('<strong>时间</strong>&nbsp;不能为空<br><strong>标题</strong>&nbsp;不能为空<br><strong>内容</strong>&nbsp;不能为空', { 'type': '', 'title': '错误提示' });
                        $(".ZebraDialogOverlay").last().css("zIndex", (parseInt(zIndex) + 1))
                        return;
                    }
                    $.ajax({
                        type: "post",
                        url: "/LifeMerit/LifeMeritAddContent",
                        data: { MemorialHallID: MemorialHallid, DeceasedInformationId: DeceasedInformationId, HappenTime: _HappenTime, Title: _title, Content: _content, MemorialArticleType: MemorialArticleType },
                        success: function (data) {
                            //添加成功
                            if (data.IsSuccess == true) {
                                //var _html =
                                //    '<li><h4><a href="/ArticleView/' + data.UseObject.SerialNumber + '">' + data.UseObject.Title + '</a></h4>' +
                                //    '<div class="new-cont">' + data.UseObject.Content + '</div>' +
                                //    '<div class="new-data"><span>发布人：<a href="javascript:void(0)">我</a></span><span>阅读（1）</span><span>评论（0)次）</span><span>点赞（0)次）</span><span>打赏（0)个天堂币）</span></div></li>';
                                //$(".life_" + DeceasedInformationId).prepend(_html);
                                var _html = "<li data-id=\"" + data.UseObject.MemorialArticleID + "\">" +
                                           "<input type=\"hidden\" value=\"" + data.UseObject.MemorialArticleID + "\" name=\"Id\">" +
                                           "<input type=\"hidden\" value=\"" + data.UseObject.SerialNumber + "\" name=\"SerialNumber\">" +
                                           "<div class=\"cbp_tmtime\"><span>" + data.UseObject.HappenTime + "</span></div>" +
                                           "<div class=\"cbp_tmicon ui-sortable-handle\"></div>"+
                                           "<div class=\"cbp_tmlabel\">"+
                                           "<h3><a href=\"/Memorial/ReView/" + data.Information + ".html" + data.UseObject.SerialNumber + "\">" + data.UseObject.Title + "</a></h3>" +
                                           "<div>" + data.UseObject.Content + "</div>" +
                                           "</div></li>"
                                $(".life_" + DeceasedInformationId).find("ol").prepend(_html);
                                _z.close(true);
                                _z = undefined;
                            }
                                //添加失败
                            else {
                                new $.Zebra_Dialog(data.Message, { 'type': '', 'title': '一生大事' });
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            new $.Zebra_Dialog('<strong>错误代码:</strong>' + XMLHttpRequest.status, { 'type': 'error', 'title': '保存失败！' });
                        }
                    })
                }
            },
            { caption: '取消', callback: function () { _z.hide(); } }]
    });
    $(".ZebraDialogOverlay").css("zIndex", 800);
    $(".ZebraDialog").css("zIndex", 801);


}

//添加档案资料、纪念文集、作品锦集、相关报道
function AddArticle(MemorialArticleType, MemorialHallID) {
    var MemberID = $("[name=MemberID]").val();
    if (_z) { _z.show(); return; }
    _z = new $.Zebra_Dialog('', {
        'type': '', width: 835, height: 600,
        'title': '添加', noClose: true, onClose: true, overlay_close: false,
        'source': { 'ajax': '/Memorial/UeditorControl?UEditorContent=' },
        'position': ['top + 30'],
        'buttons': [
            {
                caption: '确定', callback: function () {
                    var _content = Ueditor.getContent();
                    var _title = $("#UEditorControl").find("[name=Title]").val();
                    var _CSSFileName = $("#UEditorControl").find("[name=CSSFileName]").val();
                    if (_title == "" || _content == "") {
                        var zIndex = $(".ZebraDialogOverlay").last().css("zIndex");
                        new $.Zebra_Dialog('<strong>标题</strong>&nbsp;不能为空<br><strong>内容</strong>&nbsp;不能为空', { 'type': '', 'title': '错误提示' });
                        $(".ZebraDialogOverlay").last().css("zIndex", (parseInt(zIndex) + 1))
                        return;
                    }
                    var _Article = { MemorialHallID: MemorialHallID, Title: _title, Content: _content, CSSFileName: _CSSFileName, MemorialArticleType: MemorialArticleType };
                    $.ajax({
                        type: "post",
                        url: "/Article/AddArticle",
                        data: _Article,
                        success: function (data) {
                            //添加成功
                            if (data.IsSuccess == true) {
                                _z.close(true);
                                _z = undefined;
                                var _html =
                                    '<li><h4><a href="/Memorial/ReView/' + data.Information + '.html">' + data.UseObject.Title + '</a></h4>' +
                                    '<div class="new-cont">' + data.UseObject.Content + '</div>' +
                                    '<div class="new-data"><span>发布人：<a href="javascript:void(0)">' + data.UseObject.Member.NickName + '</a></span><span>阅读（0）</span>' +
                                    '<span>评论（0)次）</span><span>点赞（0)次）</span><span>打赏（0)个天堂币）</span>'+
                                    '<span>发布时间:' + data.UseObject.AddDateTime + '</span></div></li>';
                                $(".news-list>ul").prepend(_html);
                                new $.Zebra_Dialog('<a target="_blank" href="/Memorial/ReView/' + data.Information + '.html">发表成功，立即查看吧</a>', { 'type': 'confirmation', 'title': '成功' });
                            }
                                //添加失败
                            else {
                                new $.Zebra_Dialog(data.Message, { 'type': '', 'title': '添加失败' });
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            new $.Zebra_Dialog('<strong>错误代码:</strong>' + XMLHttpRequest.status, { 'type': 'error', 'title': '保存失败！' });
                        }
                    })
                }
            },
            { caption: '取消', callback: function () { _z.hide(); } }]
    });
    $(".ZebraDialogOverlay").css("zIndex", 800);
    $(".ZebraDialog").css("zIndex", 801);
}