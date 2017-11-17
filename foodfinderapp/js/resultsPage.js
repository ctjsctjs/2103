$( document ).ready(function() {
  $('.container-responsive').show();
  $('.loader').hide();
});

$('#toggle-res-carpark').click(function() {
  $("#res-carpark-cont").show();
  $("#res-food-cont").hide();
});

$('#toggle-res-food').click(function() {
  $("#res-carpark-cont").hide();
  $("#res-food-cont").show();
});
