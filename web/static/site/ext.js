LN = {
    // 后台框架的初始化工作在这里完成
    dtInit : function(){
        // 如果存在datepicker插件
        if (typeof(jQuery.datepicker) !== 'undefined') { //
           $('input[dt=true]').each(function(){
               var $this = $(this);

               var setting = {
                  // autoclose: true,
               };
               // 1 是否可清除
               if ($this.attr('dt-clear') == true
                   || $this.attr('dt-clear') == 'true') {
                   setting['showButtonPanel'] = true;
                   setting['closeText'] = '清除';
                   setting['beforeShow'] = function (input, inst) {
                                               CurrDtInput = input;
                                           };
               }
               // 2 是否可变换年
               if ($this.attr('y-change')== true
                   || $this.attr('dt-year') == 'true') {
                  setting['changeYear'] = true;
               }
               // 3 是否可变换月
               if ($this.attr('m-change')== true
                   || $this.attr('dt-month') == 'true') {
                   setting['changeMonth'] = true;
               }
               // 4 缺省
               if ($this.attr('default')) {
                  setting['defaultDate'] = $this.attr('default');
               }
               // 5 开始时间
               if ($this.attr('min')) {
                   setting['minDate'] = $this.attr('min');
               }
               // 6 结束时间
               if ($this.attr('max')) {
                    setting['maxDate'] = $this.attr('max');
               }
               // 7 可选择年的显示范围
               if ($this.attr('year-range')) {
                    setting['yearRange'] = $this.attr('year-range');
               }
               // 6 时间格式
               if ($this.attr('format')) {
                    setting['dateFormat'] = $this.attr('format');
               }
               $this.datepicker(setting);
           });
        } // 时间选择处理结束
    },

    dttimeInit : function(){

        $('body').on('click', 'input[dttime=true]', function(e){
            $.datetimepicker.setLocale('ch');
           var $this = $(this);
           if ( !$this.data('dttimeInit') ) {
               var setting = {format:'Y-m-d H:i'};

               if ($this.attr('step')) {
                   setting['step'] = $this.attr('step');
               }

               if ($this.attr('defaultTime')) {
                   setting['defaultTime'] = $this.attr('defaultTime');
               }

               $this.datetimepicker(setting);
               $this.data('dttimeInit', true);
               $this.blur();
               $this.focus();
           }
        });
    },


    selectize : function() {
        // 最简单的
        $('.sel-ize').each(function(index, item){
            var $this = $(item);
            if ( !$this.data('select-init') ) {
                $this.selectize({
                    //create: true
                });
                $this.data('select-init', true);
            }
        });
    }
};
$(function(){
    LN.dtInit();
    LN.dttimeInit();
    LN.selectize();
});

