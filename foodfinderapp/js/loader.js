$( document ).ready(function() {
  $('.load').show();
  $('.loader').hide();

  $(".res-img").on('load', function(){
    console.log('HERE');
    $(this).siblings(".img-loader").hide();
    $(this).show();
  });
});
