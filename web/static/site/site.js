$(function(){

    // bootstrapButton = $.fn.button.noConflict();
    // $.fn.bootstrapBtn = bootstrapButton;
    // $('.datepicker').datepicker({
    //     format: 'yyyy-mm-dd',
    // });

    $('.modalAddButton').click(function(e){
        e.preventDefault();
        // $('#modal').modal('show')
        //             .find('#modalContent')
        //             .load($(this).attr('value'));
        var btn = $(this).button().button('loading');
        //加载完再显示，看着舒服一点
        $('#modalAdd').find('#modalContent')
                    .load($(this).attr('href'),function(xhr){
                        $('#modalAdd').modal('show');
                        btn.button().button('reset');
                    });

        return false;
    });

    $('.modalEditButton').click(function(e){
        e.preventDefault();
        var btn = $(this).button('loading');
        $('#modalEdit').find('#editContent')
                    .load($(this).attr('href'),function(){
                        $('#modalEdit').modal('show');
                        btn.button('reset');
                    });
        return false;
    });


    $('.modalViewButton').click(function(e){
        e.preventDefault();
        var btn = $(this).button('loading');
        $('#modalView').find('#viewContent')
            .load($(this).attr('href'),function(){
                $('#modalView').modal('show');
                btn.button('reset');
            });
        return false;
    });



})
