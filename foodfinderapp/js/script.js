$(document).ready(function () {
  $(".modal-loginBtn").click(function(){
    $(".modal-login").fadeIn(100);
    $('.modal-container')
      .stop(true, true)
      .animate({
      marginTop: "+=30px",
      opacity:"toggle"
    },200);
  });
  $(".modal-login").click(function(){
    $(".modal-login").fadeOut(100);
    $('.modal-container')
      .stop(true, true)
      .animate({
      marginTop: "-=30px",
      opacity:"toggle"
    },200);

  }).children().click(function(e) {
    return false;
  });
});


