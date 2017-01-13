/**
 * ======================================================
 *   收藏与分享 因只有部分页面使用 单独分离出来 wsq
 * ======================================================
 *
 **/


// $('.fav').click(function(e){
//         e.preventDefault();

//         var res_name = $(this).data('res');
//         var res_id = $(this).data('id');
//         var title = $(this).attr('title');
//         var res_url = $(this).attr('href');
//         var _csrf = $('meta[name=csrf-token]').attr('content');
//         var url = "<?php echo Url::toRoute(['/member/default/favor'])?>";

//         var favObj = $(this);
//         var data = {res_name:res_name,res_id:res_id,title:title,res_url:res_url,_csrf:_csrf};

//         $.post(url, data, function(xhr){
//             if (xhr.status) {
//                 favObj.tooltipster({})
//                 .tooltipster('content', xhr.info)
//                 .tooltipster('open');

//             } else {
//                 favObj.tooltipster({})
//                 .tooltipster('content', xhr.info)
//                 .tooltipster('open');
//             }
//         },'json');


//     });




//php  use app\assets\TooltipAsset;

//phpTooltipAsset::register($this);

// //php $this->registerJsFile('@web/static/site/fav.js', ['depends'=>['yii\web\YiiAsset'], 'position'=> yii\web\View::POS_END]);

// //<a href="#" class="fav" res-name="goods" res-id="12" title="标题">点此收藏 (<span class="favcnt">12</span>)</a>
// $.fn.extend({
//     fav:function(res_name, res_id, res_url, title, _csrf,url, func) {
//         var favObj = $(this);
//         var data = {res_name:res_name,res_id:res_id,title:title,res_url:res_url,_csrf:_csrf};
        
//         $.post(url, data, function(xhr){
//             if (xhr.status) {
//                 // $('span', favObj).text(xhr.data.count);
//                 favObj.tooltipster({})
//                 .tooltipster('content', xhr.info)
//                 .tooltipster('open');

//             } else {
//                 favObj.tooltipster({})
//                 .tooltipster('content', xhr.info)
//                 .tooltipster('open');
//             }
//         },'json');
//     },

//     // share:function(res_name, res_id, fun){ //要引入artdialog
//     //     var shareObj = $(this);
//     //     var url = '/member/share/addshare';

//     //     var html = '';
//     //     html += '<div class="pbtm8" style="color:#cdcdcd;">你可以填写分享的理由</div>';
//     //     html += '<textarea id="share_reason" style="width:320px; height:100px; position:relation;" /></textarea>';

//     //     art.dialog({
//     //         title:'分享',
//     //         content:html,
//     //         yesFn:function(){
//     //             var shareReason = $("#share_reason").val();
//     //             var data = {res_name:res_name, res_id:res_id, reason:shareReason};
//     //             $.get(url, data,function(xhr){
//     //                 if (xhr.status) {
//     //                     $("#share_reason").val('');
//     //                     art.dialog('恭喜您，分享成功！', function(){});
//     //                 } else {
//     //                     art.dialog(xhr.info, function(){});
//     //                 }
//     //                 fun(xhr);
//     //             }, 'json');
//     //         },
//     //         cancel:function(){}
//     //     });
//     // }
// });


/**


<?php $this->beginBlock('fav') ?> 
$(function(){
    $('.fav').click(function(){
        var res_name = $(this).attr('res-name');
        var res_id = $(this).attr('res-id');
        var title = $(this).attr('title');
        var res_url = document.location.href;
        var _csrf = $('meta[name=csrf-token]').attr('content');
        var url = "<?=Url::toRoute(['/member/default/favor'])?>"
        $('.fav').fav(res_name, res_id, res_url, title, _csrf, url);
    });
})  
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['fav'], \yii\web\View::POS_END); ?>  

*/
