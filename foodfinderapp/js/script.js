
$(document).ready(function () {

  $(function hideButtons(){
    if($('#nav-profile').length){
      $(".public").css("display", "none");
    }
  });

  var status = "";
  if(window.location.href.indexOf("fail") > -1) {
      status ="login";
       document.getElementById('demo').innerHTML = "Error."
    }

  var errorArray = document.getElementsByClassName('modal-error');
  for (var i = 0; i < errorArray.length; i++){
    if (errorArray[i].innerHTML !='') {
      $(".modal").show();
      $("#modal-login").show();
    }
  }

  $(".modal-loginBtn").click(function(){
    status = "login";

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
