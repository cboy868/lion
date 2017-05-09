$(document).on("pageInit", "#page-default", function(e, id, $page) {

  $(document).on('refresh', '.page-default',function(e) {
    setTimeout(function() {
      $($("#index-tpl").html()).insertBefore($(".list a").eq(0));
      $.pullToRefreshDone('.page-default');
    }, 2000);
  });

  var loading = false;
  $(document).on('infinite', '.page-default',function() {
    if(loading) return;
    loading = true;
    setTimeout(function() {
      $(".page-default .list").append($($("#index-tpl").html()));
      loading = false;
    }, 2000);
  });

});

$(document).on("pageInit", "#page-goods", function(e, id, $page) {
  var loading = false;
  $(document).on('infinite', '.page-goods',function() {
    if(loading) return;
    loading = true;
    setTimeout(function() {
      $(".page-goods ul").append($(".page-goods ul").html());
      loading = false;
    }, 2000);
  });
});

var $dark = $("#dark-switch").on("change", function() {
  $(document.body)[$dark.is(":checked") ? "addClass" : "removeClass"]("theme-dark");
});

$.init();
