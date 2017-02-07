

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
 


})
