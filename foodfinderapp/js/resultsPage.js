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

function initialFoodLoad(){
    var foodCount = document.getElementById("foodCounts").innerHTML;
    if (foodCount == 0){
      document.getElementById("res-food-cont").innerHTML += "<span class='empty-result' id='label-food'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Results are found. Please try another keyword.</span>";
    } else {
    if (foodCount > 0 && foodCount < 24){
        var endLength = foodCount;
    } else if (foodCount >= 24){
        var endLength = 24;
    }
    for (var i = 0; i < endLength; i++){
        document.getElementById("res-food-cont").innerHTML += "<li class='res-row-food' id='res-food-" + i + "'>"
            + "<a class='res-food-img' href='restaurant.php?foodEstablishmentId=" + foodArray[i].foodEstablishmentId + "'>"
            + "<img src=http://ctjsctjs.com/" + foodArray[i].image + ">"
            + "</a>"
            + "<div class='res-food'>"
            + "<a class='results-header hide-overflow' href='restaurant.php?foodEstablishmentId=" + foodArray[i].foodEstablishmentId + "'>" + foodArray[i].name + "</a>"
            + "<span class='res-food-subheader'>Nearest Carpark</span>";
        if (foodArray[i].cpStatus == true){
            document.getElementById("res-food-" + i).innerHTML += "<a href=carpark.php?carparkId=" + foodArray[i].carparkId + " class='res-blocks'>"
                + "<span class='res-lots'>" + foodArray[i].lots + "</span>"
                + "<span class='res-name hide-overflow'>" + foodArray[i].development + "</span>"
                + "<span class='res-dist'>" + (foodArray[i].distance * 1000).toFixed(2) + "m</span>"
                + "</a>";
        } else {
            document.getElementById("res-food-" + i).innerHTML += "<span class='res-empty'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Carparks Nearby</span>";
        }
        document.getElementById("res-food-" + i).innerHTML += "<a class='res-more' href='restaurant.php?foodEstablishmentId=" + foodArray[i].foodEstablishmentId + "'>View more <i class='fa fa-caret-right' aria-hidden='true'></i></a></div>";
    }
  }
}

function nextFoodPage(){
    var currentPage = document.getElementById("foodCurrentPage").innerHTML;
    var maxPage = document.getElementById("foodMaxPage").innerHTML;
    var startResult = currentPage;
    if (currentPage < maxPage){
        currentPage++;
        document.getElementById("foodCurrentPage").innerHTML = currentPage;
        var endResult = currentPage;
        listFoodResult(startResult,endResult);
    }
}

function prevFoodPage(){
    var currentPage = document.getElementById("foodCurrentPage").innerHTML;
    if (currentPage > 1){
        currentPage--;
        var endResult = currentPage;
        document.getElementById("foodCurrentPage").innerHTML = currentPage;
        var startResult = currentPage - 1;
        listFoodResult(startResult,endResult);
    }
}

function listFoodResult(x,y){
    var startIndex = x * 24;
    var endIndex = y * 24;
    var totalFood = document.getElementById("foodCounts").innerHTML;
    if (endIndex > totalFood){
        endIndex = totalFood;
    }
    document.getElementById("res-food-cont").innerHTML = "";
    for (var i = startIndex; i < endIndex; i++){
        document.getElementById("res-food-cont").innerHTML += "<li class='res-row-food' id='res-food-" + i + "'>"
            + "<a class='res-food-img' href='restaurant.php?foodEstablishmentId=" + foodArray[i].foodEstablishmentId + "'>"
            + "<img src=http://ctjsctjs.com/" + foodArray[i].image + ">"
            + "</a>"
            + "<div class='res-food'>"
            + "<a class='results-header hide-overflow' href='restaurant.php?foodEstablishmentId=" + foodArray[i].foodEstablishmentId + "'>" + foodArray[i].name + "</a>"
            + "<span class='res-food-subheader'>Nearest Carpark</span>";
        if (foodArray[i].cpStatus == true){
            document.getElementById("res-food-" + i).innerHTML += "<a href=carpark.php?carparkId=" + foodArray[i].carparkId + " class='res-blocks'>"
                + "<span class='res-lots'>" + foodArray[i].lots + "</span>"
                + "<span class='res-name hide-overflow'>" + foodArray[i].development + "</span>"
                + "<span class='res-dist'>" + (foodArray[i].distance * 1000).toFixed(2) + "m</span>"
                + "</a>";
        } else {
            document.getElementById("res-food-" + i).innerHTML += "<span class='res-empty'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Carparks Nearby</span>";
        }
        document.getElementById("res-food-" + i).innerHTML += "<a class='res-more' href='restaurant.php?foodEstablishmentId=" + foodArray[i].foodEstablishmentId + "'>View more <i class='fa fa-caret-right' aria-hidden='true'></i></a></div>";
    }
}
