var Ueditor = UE.getEditor('Ueditor', {
    maximumWords: 50000, initialFrameHeight: 600, toolbars: [
                        ['fullscreen', 'source', 'undo', 'redo', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|', 'insertimage', 'emotion']
    ]
});
$(function () {
    Ueditor.addListener("ready", function () {
        // editor准备好之后才可以使用
        Ueditor.setContent($("#LifeIntroduction").html());
    });
})

//点击完善生平简介
function EditLifeIntroduction() {
    var fun = function () { EditLifeIntroduction() };
    if (!CheckLogin(fun)) { return; }
    var DeceasedInformationID = $("#person_left").find(".active").find("[name=Id]").val();
    Ueditor.setContent($("#LifeIntroduction_" + DeceasedInformationID).html());
    $("#LifeIntroduction_" + DeceasedInformationID).hide();
    $("#EditLifeIntroduction").show();
    $("#btnEdit").hide();
    $("#btnSave").show();
    $("#btnSave1").show();
}

//保存生平简介
function SaveLifeIntroduction()
{
    var DeceasedInformationID = $("#person_left").find(".active").find("[name=Id]").val();
    var _content = Ueditor.getContent();
    var _MemorialHallID = $("[name=MemorialHallID]").val();
    var _data = { MemorialHallID: _MemorialHallID, DeceasedInformationID: DeceasedInformationID, Content: _content };
    $.ajax({
        type: "post",
        async:false,
        url: "/LifeIntroduction/UpdateContent",
        beforeSend: function () { },
        data: _data,
        success: function (data) {
            //添加成功
            if (data.IsSuccess) {
                $("#LifeIntroduction_" + DeceasedInformationID).html(Ueditor.getContent());
                $("#LifeIntroduction_" + DeceasedInformationID).show();
                $("#EditLifeIntroduction").hide();
                $("#btnEdit").show();
                $("#btnSave").hide();
                $("#btnSave1").hide();
                new $.Zebra_Dialog("更新生平简介<strong>成功</strong>", { 'type': 'confirmation', 'title': '保存成功' });
            }
            //添加失败
            else {new $.Zebra_Dialog(data.Message, {'type': 'error','title': '保存失败！'});}
        },
        //添加出错
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            new $.Zebra_Dialog('<strong>错误代码:</strong>' + XMLHttpRequest.status, {'type': 'error','title': '保存失败'});
        }
    })
}