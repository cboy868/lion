

$(function(){
    // $('.datepicker').datepicker({
    //     format: 'yyyy-mm-dd',
    // });

    $('.modalAddButton').click(function(e){
        e.preventDefault();
        // $('#modal').modal('show')
        //             .find('#modalContent')
        //             .load($(this).attr('value'));

        //加载完再显示，看着舒服一点
        $('#modalAdd').find('#modalContent')
                    .load($(this).attr('href'),function(){
                        $('#modalAdd').modal('show');
                    });
    });

    $('.modalEditButton').click(function(e){

        e.preventDefault();

        $('#modalEdit').find('#editContent')
                    .load($(this).attr('href'),function(){
                        $('#modalEdit').modal('show');
                    });
    });
 

  // $('.remoteform').click(function(e){
  //   e.preventDefault();
  //   var url = $(this).attr('href');
  //   var title = $(this).attr('title') || '';
  //   $.get(url,{},function(xhr){
  //       var box = bootbox.dialog({
  //           locale:'zh_CN',
  //           animate:false,
  //           title:title,
  //           message:xhr,
  //           buttons:{
  //               yesfn:{
  //                   label: "确 定",
  //                   className:'btn-primary',
  //                   callback:function(e){
  //                       e.preventDefault();
  //                       box.find('form.rform').submit();
  //                       return false;
  //                   }
  //               },
  //               cancelfn:{
  //                   label: '取 消',
  //                   className:'btn-default',
  //                   callback:function(){}
  //               }
  //           }
  //       });
  //   },'html');
  // });

  // $('.remoteView').click(function(e){
  //   e.preventDefault();
  //   var url = $(this).attr('href');
  //   var title = $(this).attr('title') || '';
  //   $.get(url,{},function(xhr){
  //       var box = bootbox.dialog({
  //           locale:'zh_CN',
  //           animate:false,
  //           title:title,
  //           message:xhr,
  //           buttons:{
  //               cancel:{
  //                   label: '确 定',
  //                   className:'btn-default',
  //                   callback:function(){}
  //               }
  //           }
  //       });
  //   },'html');
  // });


})
