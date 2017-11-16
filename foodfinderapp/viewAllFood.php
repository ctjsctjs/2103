<?php include_once 'includes/header.php' ?>
<?php
if (isset($_SESSION['FIRSTNAME'])) {
  include_once 'includes/nav_user.php';
  include_once 'includes/searchbar.php';
} else {
  include_once 'includes/nav_index.php';
}
?>

<script src='js\jquery-3.2.1.min.js'></script>
<script src='js\foodestablishmentJS.js'></script>
<div class="container-carpark">
  <div class="container-responsive">
    <div class="loader"></div>
    <div class="container-results" id="res-allFood">
      <div class="row">
        <span>Page</span>
        <input type="text" id='feCurrentPageNo' value="1" size="1"></input>
        <span>of</span>
        <span id='feTotalPageNo'></span>
      </div>
      <input type="button" id="pageJump" value="Go!" onclick="pageJump()"></input>
      <button onclick="prevPage()" class="button button-red">Prev Page</button>
      <button onclick="nextPage()" class="button button-red">Next Page</button>

      <!--
      set onchange of select input to reload the listing table, displaying the sorted result set
    -->
    <select id="sortDrop" style="float:right" onchange="setSort()">
      <option value="">Sort By</option>
      <option value="0">Ascending</option>
      <option value="1">Descending</option>
    </select>

    <div id="feResults">
      <span>Total results found: </span>
      <?php
      //NOTE current issue, using Establishment name for maps, 1st entry shows a different place (Due to Hotel stored as Hotels in DB)
      //NOTE if establishment names are people's name, map will display world map
      ?>
    </div>
  </div>
</div>
</div>


<script>
//load the php page getListing without sort criteria
initialLoad();

//enable enter key for page jump
document.getElementById("feCurrentPageNo")
.addEventListener("keyup", function(event) {
  event.preventDefault();
  if (event.keyCode == 13) {
    document.getElementById("pageJump").click();
  }
});

$( document ).ready(function() {
  $('.loader').hide();
  $('#res-allFood').show();
});
</script>


<?php include_once 'includes/footer_main.php' ?>
