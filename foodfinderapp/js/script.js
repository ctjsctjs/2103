
$(document).ready(function () {

  /*
  $('.modal-error').each(function() {
    if (this.length) {
      $(".modal-login").show();
      $(".modal-container").show();
    }
  });*/


  var status = "";


  if(window.location.href.indexOf("fail") > -1) {
      status ="login";
       document.getElementById('demo').innerHTML = "Error."
    }

  var errorArray = document.getElementsByClassName('modal-error');
  for (var i = 0; i < errorArray.length; i++){
    console.log(errorArray[i].innerHTML)
    if (errorArray[i].innerHTML !='') {
      $(".modal").show();
      $("#modal-login").show();
    }
  }

  $(".modal-loginBtn").click(function(){
    status = "login";
    console.log(status);

    $(".modal").fadeIn(100);
    $('#modal-login')
      .stop(true, true)
      .animate({
      marginTop: "+=30px",
      opacity: "toggle"
    },200);
  });

  $(".modal-registerBtn").click(function(){
    status = "register";
    console.log(status);
    $(".modal").fadeIn(100);
    $('#modal-register')
      .stop(true, true)
      .animate({
      marginTop: "+=30px",
      opacity:"toggle"
    },200);
  });

    $(".modal").click(function(){
      $(".modal").fadeOut(100);
      if (status == "login"){
      $('#modal-login')
        .stop(true, true)
        .animate({
        marginTop: "-=30px",
        opacity: "toggle"
      },200);
    }
    else if (status == "register"){
       $('#modal-register')
         .stop(true, true)
         .animate({
         marginTop: "-=30px",
         opacity: "toggle"
       },200);
     }
  });

  $("#modal-registerlink").click(function(){
    status = "register";
    $('#modal-login').css({
      marginTop: "-=30px",
      display:"none",
    });
    $('#modal-register').css({
      marginTop: "+=30px",
      display: "block",
    });
});

  $(this).children(".children").toggle();
  $(".modal-container *").click(function(e) {
    e.stopPropagation();
  });
});
