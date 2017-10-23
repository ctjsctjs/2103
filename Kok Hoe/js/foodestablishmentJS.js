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
  document.getElementById("feListing").innerHTML = "<table border='1' id='feListingTable'><th>ID</th><th>Establishment Name</th><th>Address</th><th>Map</th>";
  for (var i = x; i < y; i++) {
    var spaceReplaced = feArray[i][1].split(" ").join("+");
    var symbolReplaced = spaceReplaced.split("&").join("and");
    document.getElementById("feListingTable").innerHTML += "<tr><td>" + feArray[i][0] + "</td><td>" + feArray[i][1] + "\
    </td><td>" + feArray[i][2] + "</td><td>\
    <iframe width='200' height='200' frameborder='0' src='//www.google.com/maps/embed/v1/place?q=" + symbolReplaced + ",Singapore\
    &zoom=17\
    &key=AIzaSyAlgLSolLKRBjHl8T3ED3E6BLsgXuAYYGo' allowfullscreen>\
     </iframe></td></tr>";
  }
  document.getElementById("feListing").innerHTML += "</table>";
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
