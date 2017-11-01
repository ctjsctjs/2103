
$(document).ready(function () {


    //Error messages
    var status = "";

  //If there is error, display modal immediately
  if (!$('#login-err').is(':empty'))  {
    status ="login";
    $(".modal").show();
    $("#modal-login").show();
  } else if ( !$('#reg-err').is(':empty') ) {
    status ="register";
    $(".modal").show();
    $("#modal-register").show();
  }

  //hide main menu jumbo buttons when user is logged in
  $(function hideButtons(){
    if($('#nav-profile').length){
      $(".public").css("display", "none");
    }
  });

  //login modal button
  $(".modal-loginBtn").click(function(){
    status = "login";
    $(".modal").fadeIn(100);
    $('#modal-login')
    .stop(true, true)
    .animate({
      marginTop: "+=30px",
      opacity: "show"
    },200);
  });

  //register modal button
  $(".modal-registerBtn").click(function(){
    status = "register";
    $(".modal").fadeIn(100);
    $('#modal-register')
    .stop(true, true)
    .animate({
      marginTop: "+=30px",
      opacity:"show"
    },200);
  });

  //Modal background click to exit button
  $(".modal").click(function(){
    $(".modal").fadeOut(100);
    if (status == "login"){
      $('#modal-login')
      .stop(true, true)
      .animate({
        marginTop: "-=30px",
        opacity: "hide"
      },200);
    }
    else if (status == "register"){
      $('#modal-register')
      .stop(true, true)
      .animate({
        marginTop: "-=30px",
        opacity: "hide"
      },200);
    }
  });

  //Internal modal link
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


  //Advance Search modal button
  $(".modal-advSearchBtn").click(function(){
    $(".modal").fadeIn(100);
    $('#modal-advSearch')
    .stop(true, true)
    .animate({
      marginTop: "+=30px",
      opacity:"show"
    },200);
  });

  //Prevent background clikc exit from interfering with child div
  $(this).children(".children").toggle();
  $(".modal-container *").click(function(e) {
    e.stopPropagation();
  });
});
