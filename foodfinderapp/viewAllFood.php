<?php include_once 'includes/header.php' ?>
<?php
    if (isset($_SESSION['FIRSTNAME'])) {
        include_once 'includes/nav_user.php';
    } else {
        include_once 'includes/nav_index.php';
    }
?>
<script src='js\jquery-3.2.1.min.js'></script>
<script src='js\foodestablishmentJS.js'></script>
<div>
  <div>
      <span>Displaying Page</span>
      <input type="text" id='feCurrentPageNo' value="1" size="1"></input>
      <span>of</span>
      <span id='feTotalPageNo'></span>
      <input type="button" id="pageJump" value="Go!" onclick="pageJump()"></input>
      <button onclick="nextPage()" style="float:right">Next Page</button>
      <button onclick="prevPage()" style="float:right">Prev Page</button>
      <!--
        set onchange of select input to reload the listing table, displaying the sorted result set
      -->
      <select id="sortDrop" style="float:right" onchange="setSort()">
          <option value="">Sort By</option>
          <option value="0">Ascending</option>
          <option value="1">Descending</option>
      </select>
  </div>
  <div id="feResults">
    <span>Total results found: </span>
      <?php
  //NOTE current issue, using Establishment name for maps, 1st entry shows a different place (Due to Hotel stored as Hotels in DB)
  //NOTE if establishment names are people's name, map will display world map
  ?>
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
</script>


<?php include_once 'includes/footer_main.php' ?>
