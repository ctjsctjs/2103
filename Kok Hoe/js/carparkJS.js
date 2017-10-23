//using availability update to retrieve json object
//updates the lots field accordingly

function updateLots() {
  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var myObj = JSON.parse(this.responseText);
      for (var i = 0; i < myObj.value.length; i++) {
        //if lot is not displayed due to google api limitation reached
        //skip the lot
        if (document.getElementById("lot" + (i + 1)) === null) {
          continue;
        } else {
          document.getElementById("lot" + (i + 1)).innerHTML = myObj.value[i].Lots;
        }

      }
    }
  };
  xmlhttp.open("GET", "availabilityUpdate.php", true);
  xmlhttp.send();
}
