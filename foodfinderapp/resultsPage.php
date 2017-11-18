<?php include_once 'includes/header.php' ?>

<?php
  if(isset($_SESSION['FIRSTNAME']))
    include_once 'includes/nav_user.php';
  else
    include_once 'includes/nav_index.php';
  
   date_default_timezone_set("Asia/Singapore");
    $datetime = date('Y-m-d H:i:s');
?>
<section class="container-searchbar">
  <div class="container-responsive">
    <span class="page-title">Search Results</span>
    <form role="form" autocomplete="off" action="resultsPage.php" method="POST">
      <div class="search-row">
        <input type="text" class="search-form" placeholder="Enter a food establishment or carpark" name="search">
        <button type ="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </div>
    </form>
  </div>
</section>

<div class="container-results">
  <div class="container-responsive">
    <div class="results-btn-row">
      <a class="button-link active" id="toggle-res-food">Food Establishment</a>
      <a class="button-link" id="toggle-res-carpark">Carpark</a>
    </div>
    <hr class="divider" id="result-divider">
    <div class="loader"></div>
    <div class="results-container">

      <?php
      include_once 'protected/databaseconnection.php';
      include_once 'protected/functions.php';
      //FOOD ESTABLISHMENT SEARCH ALGO

      $sql = "SELECT foodEstablishmentId, image, name, RIGHT(address, 6) as postalcode FROM foodestablishment WHERE name LIKE '%" . $_POST["search"] . "%'";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        if (mysqli_num_rows($result) > 0) {
          echo '<ul class="load" id="res-food-cont">';
          while($row = mysqli_fetch_assoc($result)) {

            $userId = $_SESSION['ID'];
            $foodId = $row['foodEstablishmentId'];
            $term = $_POST['search'];
            date_default_timezone_set("Asia/Singapore");
            $datetime = date('Y-m-d H:i:s');

            if(isset($_SESSION['ID'])) {

              $insertFoodSearch = "INSERT INTO foodsearch(userId, foodEstablishmentId, termSearch, datetimeSearch)VALUES('$userId', '$foodId', '$term', '$datetime')";

              mysqli_query($conn, $insertFoodSearch) or die(mysqli_connect_error());
            }

            /*EACH FOOD INSTANCE*/
            echo '<li class="res-row-food">'
            .'<a class="res-food-img" href="restaurant.php?foodEstablishmentId='.$row["foodEstablishmentId"].'">'
            .'<img src=http://ctjsctjs.com/'. $row['image'] .'>'
            .'</a>'
            ."<div class='res-food'>"
            .'<a class="results-header hide-overflow" href="restaurant.php?foodEstablishmentId='.$row["foodEstablishmentId"].'">' . $row["name"] . '</a>'
            ."<span class='res-food-subheader'>Nearest Carpark</span>";

            #SQL statement to find all carpark within 500m
            $locationVector = getLocation($row['postalcode'], $googleKey); //Get Coords
            $dist = "( 6371 * acos( cos( radians(". $locationVector[0] .")) * cos( radians( latitude )) * cos( radians( longitude ) - radians(". $locationVector[1] .")) + sin(radians(". $locationVector[0] .")) * sin(radians(latitude))))";
            $locateSQL = "SELECT *, ".$dist." as distance FROM carpark HAVING distance < 0.5 ORDER BY distance ASC LIMIT 1 ";
            $locateResult = mysqli_query($conn, $locateSQL) or die(mysqli_connect_error());

            if ($locateResult) {
              if (mysqli_num_rows($locateResult) > 0) {
                while($locateRow = mysqli_fetch_assoc($locateResult)) {
                  $lots = getLots($locateRow, $datamallKey); //Get number of lots available
                  /*EACH BLOCK OF CARPARK*/
                  echo '<a href=carpark.php?carparkId='.$locateRow["carparkId"].' class="res-blocks">'
                  ."<span class='res-lots'>". $lots ."</span>"
                  ."<span class='res-name hide-overflow'>" . $locateRow["development"]. "</span>"
                  ."<span class='res-dist'>" . sprintf(' %0.2f', $locateRow["distance"])*1000 . "m</span>"
                  ."</a>";
                  /*END OF CARPARK BLOCK*/
                }
              }
              else {
                echo "<span class='res-empty'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Carparks Nearby</span>";
              }
              echo "<a class='res-more' href='restaurant.php?foodEstablishmentId=".$row['foodEstablishmentId']."'>View more <i class='fa fa-caret-right' aria-hidden='true'></i></a></div>";
            }
            echo "</li>";
          }
          echo '</ul>';
        } else {
          echo "<span class='empty-result' id='label-food'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Results are found. Please try another keyword.</span>";
        }
      }

      //CARPARK SEARCH ALGO

      $sql1 = "SELECT * FROM carpark WHERE area LIKE '%" . $_POST["search"] . "%' OR development LIKE '%" . $_POST["search"] . "%'";
      $result1 = mysqli_query($conn, $sql1) or die(mysqli_connect_error());
      if ($result1) {
        if (mysqli_num_rows($result1) > 0) {
          // output data of each row
          echo '<ul id="res-carpark-cont">';

          while($row1 = mysqli_fetch_assoc($result1)) {

            $userId = $_SESSION['ID'];
            $carparkId = $row1['carparkId'];
            $term = $_POST['search'];
            date_default_timezone_set("Asia/Singapore");
            $datetime = date('Y-m-d H:i:s');

            if(isset($_SESSION['ID'])) {

              $insertFoodSearch = "INSERT INTO carparksearch(userId, carparkId, termSearch, datetimeSearch)VALUES('$userId', '$carparkId', '$term', '$datetime')";

              mysqli_query($conn, $insertFoodSearch) or die(mysqli_connect_error());
            }

            $lots = getLots($row1, $datamallKey); //Get number of lots available

            echo '<li class="res-row-food">'
            .'<a class="res-food-img" href=carpark.php?carparkId='.$row1["carparkId"].'>'
            .'<src=http://ctjsctjs.com/'.$row1["image"].'>'
            .'</a>'
            ."<div class='res-food'>"
            .'<a class="results-header hide-overflow" href=carpark.php?carparkId='.$row1["carparkId"].'>' . $row1["development"] . '</a>'
            ."<span class='res-food-subheader'>Lots Available</span>"
            .'<a href=carpark.php?carparkId='.$row1["carparkId"].' class="res-blocks">'
            ."<span class='res-lots'>". $lots ."</span>"
            ."<span class='res-name res-single hide-overflow'>". $row1["development"] ."</span>"
            ."</a>"
            . "<a class='res-more' href=carpark.php?carparkId=".$row1["carparkId"].">View more <i class='fa fa-caret-right' aria-hidden='true'></i></a></div>"
            ."</li>";
          }
          echo '</ul>';
        }
        else {
          echo "<span class='empty-result label-carpark'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Results are found. Please try another keyword.</span>";
        }
      }

    ?>
  </div>
</div>
</div>

<?php include_once 'includes/footer_main.php' ?>
<script type="text/javascript" src="js/lot-color.js"></script>
<script type="text/javascript" src="js/resultsPage.js"></script>
