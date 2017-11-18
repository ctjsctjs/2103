$( document ).ready(function() {
  $('.load').show();
  $('.loader').hide();
});

$('#toggle-res-carpark').click(function() {
  $(this).addClass("active");
  $('#toggle-res-food').removeClass("active");

  $("#res-carpark-cont").show();
  $('.label-food').hide();
  $('.label-carpark').show();
  $("#res-food-cont").hide();
});

$('#toggle-res-food').click(function() {
  $(this).addClass("active");
  $('#toggle-res-carpark').removeClass("active");

  $("#res-carpark-cont").hide();
  $("#res-food-cont").show();
  $('.label-food').show();
  $('.label-carpark').hide();
});
