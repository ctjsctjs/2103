
$(document).ready(function () {

  /*
  $('.modal-error').each(function() {
    if (this.length) {
      $(".modal-login").show();
      $(".modal-container").show();
    }
  });*/

  var errorArray = document.getElementsByClassName('modal-error');
  for (var i = 0; i < errorArray.length; i++){
    console.log(errorArray[i].innerHTML)
    if (errorArray[i].innerHTML !='') {
      $(".modal-login").show();
      $(".modal-container").show();
    }
  }



  $(".modal-loginBtn").click(function(){
    $(".modal").fadeIn(100);
    $('#modal-login')
      .stop(true, true)
      .animate({
      marginTop: "+=30px",
      opacity:"toggle"
    },200);
  });
  $(".modal").click(function(){
    $(".modal").fadeOut(100);
    $('.modal-container')
      .stop(true, true)
      .animate({
      marginTop: "-=30px",
      opacity:"toggle"
    },200);
    $(this).children(".children").toggle();
  });
  $(".modal-container *").click(function(e) {
        e.stopPropagation();
  });
});
