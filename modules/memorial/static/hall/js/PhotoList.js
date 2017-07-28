$(function () {
    //var $grid = $('.photo-list ul').masonry({ itemSelector: 'li' });//瀑布流
    var $grid;
    $('.photo-list').imagesLoaded(function () {
        $grid = $('.photo-list ul').masonry({
            itemSelector: 'li'
        });
    });
    $('.prepended').click(function () { GetPhotoByPage("prepended"); return false; });//向上添加
    $('.appended').click(function () { GetPhotoByPage("appended"); return false; });//向下添加
    //加载相片
    function GetPhotoByPage(append) {
        var _data = { CurrentCount: $("[name=CurrentCount]").val(), GroupID: $("[name=CurrentGroupID]").val() };
        $.ajax({
            type: "GET",
            url: "/PhotoList/GetPhotoByPage",
            contentType: 'application/json;charset=utf-8',
            data: _data,
            error: function (XMLHttpRequest, textStatus, errorThrown) { new $.Zebra_Dialog("错误代码：" + XMLHttpRequest.status, { 'type': 'error', 'title': '发表失败' }); },
            success: function (data) {
                if (data.IsSuccess) {
                    var _html = '';
                    for (var i = 0; i < data.UseObject.length; i++) {
                        _html += "<li>" +
                              "<a data-toggle=\"modal\" data-target=\".photo_layer\" href=\"#\">" +
                                "<img img-id=\"" + data.UseObject[i].GID + "\" title=\"" + data.UseObject[i].Title + "\" longdesc=\"" + data.UseObject[i].Explanation + "\"" +
                                "largerimgsrc=\"" + data.UseObject[i].ImageImgPath + "\"" +
                                "src=\"" + data.UseObject[i].ImageImgPath + "\" />" +
                                "</a>" +
                                "<p><a href=\"" + data.UseObject[i].ImageImgPath + "\" target=\"_blank\">查看原图</a></p>" +
                                "<p><a data-toggle=\"modal\" data-target=\".photo_layer\">" + data.UseObject[i].Title + "</a></p>" +
                        "</li>";
                    }
                    var $items = $(_html);
                    $("[name=CurrentCount]").val(parseInt($("[name=CurrentCount]").val()) + data.UseObject.length);
                    if (append == "prepended") {  //向上添加                 
                        $items.imagesLoaded(function () {
                            $grid.prepend($items).masonry('prepended', $items);
                        });
                    }
                    if (append == "appended") { //向下添加
                        $items.imagesLoaded(function () {
                            $grid.prepend($items).masonry('appended', $items);
                        });
                    }
                    if (data.UseObject.length < 2) {
                        $(".load-more").hide();
                    }
                }
            }
        });
    }
    //相册
    $('.photo_layer').on('show.bs.modal', function () {
        //加载图片
        var _imgEle = '';
        $('.photo-list img').each(function () {
            var _id = $(this).attr('img-id');
            var _title = $(this).attr('title');
            var _longdesc = $(this).attr('longdesc');
            var _thumbImgSrc = $(this).attr('src');
            var _largerImgSrc = $(this).attr('largerImgSrc');
            _title = (_title == undefined ? '' : _title);
            _longdesc = (_longdesc == undefined ? '' : _longdesc);
            _largerImgSrc = (_largerImgSrc == undefined ? _thumbImgSrc : _largerImgSrc);
            _title = (_title == '' ? ' ' : _title);
            _longdesc = (_longdesc == '' ? ' ' : _longdesc);
            _largerImgSrc = (_largerImgSrc == '' ? _thumbImgSrc : _largerImgSrc);

            _imgEle += '<li><a href="' + _largerImgSrc + '">' +
				'<img src="' + _thumbImgSrc + '" img-id="' + _id + '" title="' + _title + '" longdesc="' + _longdesc + '">' +
				'</a></li>';
        });
        var _html = '<div id="gallery" class="ad-gallery"><div class="ad-image-wrapper"></div><div class="ad-controls"></div><div class="ad-nav">' +
					'<div class="ad-thumbs"><ul class="ad-thumb-list">' + _imgEle
        '</ul></div></div></div>';
        $('.my-dialog .photo-album').html(_html);
    });
    var galleries;
    $('.photo_layer').on('shown.bs.modal', function (e) {
        var self = $(e.relatedTarget);
        var _index = self.parent().index();
        var _w = $('.my-dialog .photo-album').width();
        galleries = $('.ad-gallery').adGallery({
            loader_image: '/Resource/images/loading.gif',
            width: _w,
            cycle: true,
            start_at_index: _index,
            desc_container: '#imgInfo',
            msg_container: '#msglist',
            ajax_load: { open: true, fun: loadImgMsg },
            slideshow: { start_label: '自动播放', stop_label: '停止' },
            callbacks: {
                afterImageVisible: function () { },
                beforeImageVisible: function () { $(this.settings.msg_container).html(''); }
            }
        });
    });
    $('.photo_layer').on('hidden.bs.modal', function (e) {
        galleries[0].slideshow.stop();
        $('#gallery').remove();
        $('.reply-box').children('.placeholder').show();
        replyEditor.execCommand('cleardoc');
        replyEditor.setHeight(30);
    });
    var _page = 2;
    $('#loadMoreMsg').click(function () { LoadImgMsg($(this).attr('data-id')); return false; });//加载更多留言
    var loadImgMsg = function (imgId) { $("[name=CurrentLoadCount]").val('0'); LoadImgMsg(imgId); }//加载图片留言
    function LoadImgMsg(imgId) {
        if (imgId) {
            $.ajax({
                type: "GET",
                url: "/Photolist/GetComment",
                contentType: 'application/json;charset=utf-8',
                data: { GID: imgId, CurrentCommentCount: $("[name=CurrentLoadCount]").val() },
                beforeSend: function () {
                    var j = $('#msglist').html()
                    $('#msglist').html('<div class="loading"></div>').fadeIn();
                    $(".loading").after(j);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) { new $.Zebra_Dialog("错误代码：" + XMLHttpRequest.status, { 'type': 'error', 'title': '发表失败' }); },
                success: function (data) {
                    if (data.IsSuccess) {
                        $("[name=CurrentLoadCount]").val(parseInt($("[name=LoadCommentCount]").val()) + parseInt($("[name=CurrentLoadCount]").val()));
                        var _msgs = '';
                        for (var i = 0; i < data.UseObject.length; i++) {
                            var adddatetime = data.UseObject[i].AddDateTime;
                            var startIndex = adddatetime.indexOf("(") + 1;
                            var endIndex = adddatetime.indexOf(")");
                            var Date_date = new Date(parseInt(adddatetime.substring(startIndex, endIndex)));
                            _msgs += '<dl><dt><img src="' +
                                data.UseObject[i].HeadPic + '"  alt="' + data.UseObject[i].NickName + '"/></dt><dd><p><a href="#">' + data.UseObject[i].NickName + '</a></p><div>' +
                                data.UseObject[i].Content + '</div><span>' + data.UseObject[i].AddDateTime + '</span></dd>' +
                                     '<div class="clear"></div></dl>';
                        }
                        if (!data.UseObject02) {
                            $('#loadMoreMsg').hide();
                        }
                        else {
                            $('#loadMoreMsg').show();
                        }
                        $("#msglist").append(_msgs);
                        $('#msglist .loading').fadeOut('fast', function () {
                            $('#loadMoreMsg').attr('data-id', imgId);
                        });
                    }
                }
            });
        }
    }

    //监听编辑器动作
    replyEditor.addListener("focus blur click", function (type) {
        switch (type) {
            case 'click':
                showEditor();
                break;
            case 'blur':
                if (!replyEditor.hasContents()) {
                    this.setHeight(30);
                    $('.reply-box').children('.placeholder').show();
                }
                break;
            case 'focus':
                showEditor();
                break;
        }
        galleries[0].slideshow.stop();
    });
    $('.reply-box').children('.placeholder').click(function () {
        showEditor();
    });
    var showEditor = function () {
        $('.reply-box').children('.placeholder').hide();
        replyEditor.setHeight(80);
        replyEditor.focus();
    }
    //回复
    $('#post-btn').click(function () {
        var ImgId = $(this).attr('img-id');
        var ImgIndex = $(this).attr('img-index');

        var _msg = replyEditor.getPlainTxt();
        var d = new Date();
        var t = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
        //保存数据
        $.ajax({
            type: "POST",
            url: "/Photolist/AddPhotoComment",
            contentType: 'application/json;charset=utf-8',
            data: JSON.stringify({ LT_ForeignKey: ImgId, content: _msg }),
            error: function (XMLHttpRequest, textStatus, errorThrown) { new $.Zebra_Dialog("错误代码：" + XMLHttpRequest.status, { 'type': 'error', 'title': '发表失败' }); },
            success: function (data) {
                if (data.IsSuccess) {
                    var _html = '<dl class="new-add" style="display:none;"><dt><img src="' +
                 data.UseObject.HeadPic + '" alt="' +
                 data.UseObject.NickName + '"/></dt>' +
                         '<dd><p><a href="javascript:void(0)">' +
                         data.UseObject.NickName + '</a></p><div>' +
                         _msg + '</div><span>' +
                         t + '</span></dd>' +
                         '<span class="clearfix"></span></dl>';
                    replyEditor.execCommand('cleardoc');
                    $('#msglist').prepend(_html);
                }
                else {
                    replyEditor.execCommand('cleardoc');
                    new $.Zebra_Dialog("发表失败！");
                }
                $('.new-add').slideDown('normal', function () {
                    $(this).removeClass('new-add');
                });
            }
        });

    });
    //加载表情
    (function () {
        var emotions = $('#emotions');
        emotions.children('.loading').remove();
        if (!emotions.html()) {
            $.ajax({
                type: "get",
                url: "/Emotion",
                data: "",
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
                            $.getScript("/Resource/Scripts/Memorial/emotion.js");
                        });
                    }
                }
            });
        }
    })();
});