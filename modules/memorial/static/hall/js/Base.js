
//处理页面加载函数
function LoadAjaxModal(idName,title, url,func) {
    $(document).off('shown.bs.modal').on('shown.bs.modal', "#" + idName, function (e) {
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
                if (typeof (func) == "function")
                {
                    func();
                }

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                node.find(".modal-header").html("错误信息");
                node.find(".modal-body").html("NetworkError:" + XMLHttpRequest.status + " " + XMLHttpRequest.statusTex);
            }
        })
    });
    $("#" + idName).unbind().modal();
}

