function calculateTotalPage() {
  var totalRows = document.getElementById("feTotalResults").innerHTML;
  var totalPage = Math.ceil(totalRows / 25);
  document.getElementById("feTotalPageNo").innerHTML = totalPage;
}

function prevPage() {
  var currentPage = document.getElementById("feCurrentPageNo").value;
  var endCount;
  var startCount;
  if (currentPage > 1) {
    currentPage--;
    endCount = currentPage * 25;
    startCount = endCount - 25;
  } else {
    startCount = 0;
    endCount = 25;
  }
  document.getElementById("feCurrentPageNo").value = currentPage;
  listResult(startCount, endCount);
}

function nextPage() {
  var currentPage = document.getElementById("feCurrentPageNo").value;
  var totalPage = document.getElementById("feTotalPageNo").innerHTML;
  var startCount = currentPage * 25;
  var endCount;
  if (currentPage < totalPage) {
    currentPage++;
    endCount = currentPage * 25;
    while (endCount > feArray.length) {
      endCount--;
    }
    document.getElementById("feCurrentPageNo").value = currentPage;
    listResult(startCount, endCount);
  }
}

function pageJump() {
  var currentPage = document.getElementById("feCurrentPageNo").value;
  var startCount = (currentPage - 1) * 25;
  var endCount = currentPage * 25;
  listResult(startCount, endCount);
}

function listResult(x, y) {
  document.getElementById("feListing").innerHTML = "<div class='results-container'  id='feListingTable'>";
  for (var i = x; i < y; i++) {
    var spaceReplaced = feArray[i][1].split(" ").join("+");
    var symbolReplaced = spaceReplaced.split("&").join("and");
    //document.getElementById("feListingTable").innerHTML += "<div class='res-row-food'>" + feArray[i][0] + "</br>" + feArray[i][1] + "</br>" + feArray[i][2] + "</div>";
    document.getElementById("feListingTable").innerHTML += "<a class='res-row-carpark' href=restaurant.php?foodEstablishmentId=" + feArray[i][0] + ">" +
    '<div class="res-name">' + feArray[i][1] + "</div>" + '<div class="res-name-light">' + feArray[i][2] + "</div>" + "</a>";
  }
  document.getElementById("feListing").innerHTML += "</div>";
}

function initialLoad() {
  $('#feResults').load('getListing.php');
  return false;
}

function setSort() {
  var sortSelect = document.getElementById("sortDrop");
  var sortValue = sortSelect.options[sortSelect.selectedIndex].value;
  //clear the feResults div to replace with new results
  document.getElementById("feResults").innerHTML = "";
  $('#feResults').load('getListing.php?sort=' + sortValue);
  return false;
}
