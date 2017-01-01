$(function() {
    $("#uploader").plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : '<?=Url::toRoute(["pl-upload"])?>',

        // User can upload no more then 20 files in one go (sets multiple_queues to false)
        max_file_count: 20,
        
        // chunk_size: '1mb',

        // Resize images on clientside if we can
        resize : {
            width : 200, 
            height : 200, 
            quality : 90,
            crop: true // crop to exact dimensions
        },
        
        filters : {
            // Maximum file size
            max_file_size : '10mb',
            // Specify what files to browse for
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png"},
                //{title : "Zip files", extensions : "zip"}
            ],
            prevent_duplicates: true//不允许选择重复文件
        },

        // Rename files by clicking on their titles
        rename: true,
        
        // Sort files
        sortable: true,

        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,

        // Views to activate
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },

        flash_swf_url : '/static/libs/plupload/Moxie.swf',
        silverlight_xap_url : '/static/libs/plupload//Moxie.xap',

        //源来的代码里有些问题  这里是为了解决源代码中的小显示bug
        viewchanged: function(event, args) {
            $('.plupload_button').toggleClass('ui-checkboxradio-checked ui-state-active');
            $('input[name=view_mode_uploader]').each(function(){
                 $(this).attr('checked',!$(this).attr('checked'));
            });
        },
        PostInit: function() {
            document.getElementById('uploader_start').onclick = function() {
                $('#uploader').plupload('start');
                return false;
            };
        },
        uploaded:function(up, file, info){
            //res = $.parseJSON(info);
            alert(info);
        },
        
    });
});