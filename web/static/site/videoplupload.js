// rid="<?=$model->id?>"
// data-url="<?=Url::toRoute(["pl-upload"])?>" 
// data-res_name="portrait"
// data-use="original"
if (typeof LN == 'undefined') {LN = {}};
LN.vplupload = function(){
      $('.videoPicker').each(function(i){
        var imgNum = $(this).attr('num');
        imgNum = imgNum ? imgNum : 'false';
        var that = this;
        var index = parseInt(i) + 1;
        var uploaderv = [];
        btn = $(this).attr('id');
        var use = $(this).attr('use');
        var res_id = $(this).attr('rid');
        var bt;
        var url = $(this).data('url');
        var res_name = $(this).data('res_name');
        var use = $(this).data('use');
        $(this).removeClass('videoPicker'); //去除 此class 防止再次each时，多次循还

        uploaderv[index] = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : btn, // you can pass an id...
            url : url,
            flash_swf_url : '/static/libs/plupload-2.1.9/js/Moxie.swf',
            silverlight_xap_url : '/static/libs/plupload-2.1.9/js//Moxie.xap',
            file_data_name:'file',
            multi_selection: false,
            filters : {
                max_file_size : '20mb',
                mimeTypes: 'mp4',
                prevent_duplicates: true//不允许选择重复文件
            },
            multipart_params:{
                res_name : res_name,
                use : use,
                res_id : res_id
            },

            init: {
                PostInit: function() {},
                FilesAdded: function(up, files) {
                bt = $('#myButton').button('loading');
                    if (files.length > imgNum) {
                        alert('最多只能上传'+imgNum+'个文件哦');
                        uploaderv[index].splice(imgNum, files.length-imgNum);
                    } 

                    // plupload.each(files, function(file, i) {
                    //     if (!file || !/image\//.test(file.type)) return; //确保文件是图片
                    //         if (file.type == 'image/gif') {//gif使用FileReader进行预览,因为mOxie.Image只支持jpg和png
                    //             var fr = new mOxie.FileReader();
                    //             fr.onload = function () {
                    //                 if (imgNum > 1) {
                    //                     $('.filelist-patch').find('img').eq(i).attr('src', fr.result);
                    //                 }
                    //                 $(that).find('img').eq(i).attr('src', fr.result);
                    //                 fr.destroy();
                    //                 fr = null;
                    //             }
                    //             fr.readAsDataURL(file.getSource());
                    //         } else {
                    //             var preloader = new mOxie.Image();
                    //             preloader.onload = function () {
                    //                 preloader.downsize(404, 486);//先压缩一下要预览的图片,宽300，高300
                    //                 var imgsrc = preloader.type == 'image/jpeg' ? preloader.getAsDataURL('image/jpeg', 80) : preloader.getAsDataURL(); //得到图片src,实质为一个base64编码的数据
                    //                 if (imgNum > 1) {
                    //                     $('.filelist-patch').find('img').eq(i).attr('src', imgsrc);
                    //                 } else {
                    //                     $(that).find('img').eq(i).attr('src', imgsrc);
                    //                 }
                    //
                    //                 preloader.destroy();
                    //                 preloader = null;
                    //             };
                    //             preloader.load(file.getSource());
                    //         }
                    //
                    // });

                    uploaderv[index].start();
                },

                UploadProgress: function(up, file) {
                    $('.percent'+res_id).html('<span>' + file.percent + "%</span>");
                },

                FileUploaded: function(up, file, info) {
                    res = $.parseJSON(info.response);
                },
                UploadComplete:function(up,file){
                    bt.button('reset');
                    location.reload();
                },

                Error: function(up, err) {
                    //document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
                }
             }//init
        });//uploader
        uploaderv[index].init();
      });//each
    };

$(function(){
    LN.vplupload();
});

