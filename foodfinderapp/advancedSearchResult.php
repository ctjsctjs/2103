
<?php
include_once 'includes/header.php';

if (isset($_SESSION['FIRSTNAME'])) {
  include_once 'includes/nav_user.php';
} else {
  include_once 'includes/nav_index.php';
};
?>
<section class="container-searchbar">
  <div class="container-responsive">
    <span class="page-title">Advanced Search results</span>
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
    <?php
    include_once 'protected/databaseconnection.php';
    include_once 'protected/functions.php';

    //Declare variables
    $search = $_POST['search'];
    $input_radius = $_POST['radius']/1000;
    $input_lots = $_POST['minLots'];
    $input_carpark = $_POST['minCarpark'];
    $advanced_search = false;
    $resultList = array();
    $locationVector = array();

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    if ($search == ""){
      header("Location: advancedSearch.php?message=search_empty");
    } else {

      $sql = "SELECT name, foodEstablishmentId, image, RIGHT(address, 6)
      as postalcode
      FROM foodestablishment
      WHERE name
      LIKE '%" . $search . "%'";

      $result = mysqli_query($conn, $sql);
      if ($result) {
        if (mysqli_num_rows($result) > 0) {

          echo '<div class="results-container" id="res-food-cont">';

          while($row = mysqli_fetch_assoc($result)){
            //reset counter for valid carpark and lot;
            $validCarparks = 0;
            $lotCount = 0;
            $locationVector = getLocation($row['postalcode'], $googleKey); //Get Coords

            //Select carparks within radius
            $locateSQL = "SELECT *, ( 6371 *
                acos(
                cos( radians(". $locationVector[0] .")) * cos( radians( latitude )) *
                cos( radians( longitude ) - radians(". $locationVector[1] .")) +
                sin(radians(". $locationVector[0] .")) * sin(radians(latitude))
                ))
                as distance FROM carpark HAVING distance < ". $input_radius ." ORDER BY distance";
                $locateResult = mysqli_query($conn, $locateSQL);

                if (mysqli_num_rows($locateResult) >= $input_carpark) { //check carpark meets carpark_lots requirement
                  while($locateRow = mysqli_fetch_assoc($locateResult)) { //for each carpark
                    $lots = getLots($locateRow, $datamallKey); //Get number of lots available
                    if ($lots >= $input_lots){
                      $validCarparks += 1; //check lots meets input_lots requirement
                      $lotCount += $lots;
                    }
                  }
                }
                //if number of carpark with enough lots meet carpark input
                if ($validCarparks >= $input_carpark){
                  echo '<div class="res-row-food res-advanced">';
                  echo '<div class="res-food-img">';
                  echo '<img src=http://ctjsctjs.com/'. $row['image'] .'>';
                  echo '</div>';
                  echo "<div class='res-food'>";
                  echo '<a class="results-header hide-overflow" href="restaurant.php?foodEstablishmentId='.$row["foodEstablishmentId"].'">' . $row["name"] . '</a>';
                  echo "<span class='res-food-subheader'>Advanced Results</span>";
                  echo "<div class='res-blocks'>";
                  echo "<span class='res-lots'>". $lotCount ."</span>";
                  echo "<span class='res-name hide-overflow'>Total Available Lots</span>";
                  echo "<span class='res-dist'>" .$validCarparks. " Valid Carparks</span>";
                  echo "</div></div>";
                  echo "<a class='res-more' href='restaurant.php?foodEstablishmentId=".$row['foodEstablishmentId']."'>View more <i class='fa fa-caret-right' aria-hidden='true'></i></a>";
                  echo "</div>";
                }
              }
              echo "</div>";
            }
          }
        }
        ?>

      </div>
    </div>
    <?php include_once 'includes/footer_main.php' ?>
