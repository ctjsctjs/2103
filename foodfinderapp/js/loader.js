$( document ).ready(function() {
  console.log('Document loaded');
  $('.load').show();
  $('.loader').hide();

  $(".res-img").on('load', function(){
    console.log('Img loaded');
    $(this).siblings(".img-loader").hide();
    $(this).show();
  });
});
