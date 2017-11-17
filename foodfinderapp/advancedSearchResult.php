
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
    //get latitude and longitude in a array using postal code
    function getLocation($postalCode, $key){
      $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=.' . $postalCode . '&key='. $key);
      $json = json_decode($json);
      $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
      $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

      return array($lat, $long);
    }

    //get carpark lot live number
    function getLots($locateRow, $key){
      $carparkLotsJson = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability";
      $ch = curl_init( $carparkLotsJson );
      $options = array(
        CURLOPT_HTTPHEADER => array( "AccountKey: ". $key . ", Accept: application/json" ),
      );
      curl_setopt_array( $ch, $options );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      $carparkJsonResult = curl_exec( $ch );
      $carparkJsonResult = json_decode($carparkJsonResult);

      return ($carparkJsonResult->{'value'}[$locateRow["carparkId"]-1]->{'Lots'});
    }

    //Declare variables
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "foodfinderapp";
    $googleKey = 'AIzaSyBUHVlBo1aiN9NZyh1Dzs91msIXblEi0NI';
    $datamallKey = 'SFHPvNC5RP+jFTzftMxxFQ==';
    $search = $_POST['search'];
    $input_radius = $_POST['radius']/1000;
    $input_lots = $_POST['minLots'];
    $input_carpark = $_POST['minCarpark'];
    $advanced_search = false;
    $resultList = array();
    $locationVector = array();

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

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
                  echo '<img src=images/'. $row['image'] .'>';
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
