<?php
include_once 'includes/header.php';

if (isset($_SESSION['FIRSTNAME'])) {
  include_once 'includes/nav_user.php';
} else {
  include_once 'includes/nav_index.php';
}
?>

<section class="container-searchbar">
  <div class="container-responsive">
    <span class="page-title">Advanced Search</span>
    <form role="form" autocomplete="off" action="resultsPage.php" method="POST">
      <div class="search-row">
        <input type="text" class="search-form" placeholder="Enter a food establishment or carpark" name="search">
        <button type ="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </div>
    </form>
  </div>
</section>
<div class="container-carpark">
  <div class="container-responsive">
    <div class="loader"></div>
    <div class="container-results" id="res-allFood">
      <!--set onchange of select input to reload the listing table, displaying the sorted result set-->
      <select class="button botton-red" id="sortDrop" onchange="setSort()">
        <option value="">Sort By</option>
        <option value="0">Ascending</option>
        <option value="1">Descending</option>
      </select>
      <hr class="divider" id="result-divider">
      <div id="feResults"></div>
      <div class="row">
        <span>Page</span>
        <input type="text" id='feCurrentPageNo' value="1" size="1"></input>
        <span>of</span>
        <span id='feTotalPageNo'></span>
      </div>
      <button onclick="prevPage()" class="button button-red">Prev Page</button>
      <button onclick="nextPage()" class="button button-red">Next Page</button>
    </div>
  </div>
</div>

<?php include_once 'includes/footer_main.php' ?>
<script src='js\foodestablishmentJS.js'></script>
<script type="text/javascript" src="js/viewAllFood.js"></script>
