
<?php include_once 'includes/header.php' ?>
<?php
    if (isset($_SESSION['FIRSTNAME'])) {
        include_once 'includes/nav_user.php';
        include_once 'includes/searchbar.php';
    } else {
        include_once 'includes/nav_index.php';
    };
?>

<div class="container-carpark">
  <div class="container-responsive">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodfinderapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//Declareation
$googleKey = 'AIzaSyBUHVlBo1aiN9NZyh1Dzs91msIXblEi0NI';
$datamallKey = 'SFHPvNC5RP+jFTzftMxxFQ==';
$search = $_POST['search'];
$input_radius = $_POST['radius']/1000;
$input_lots = $_POST['minLots'];
$input_carpark = $_POST['minCarpark'];
$advanced_search = false;
$resultList = array();
$locationVector = array();

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

if ($search == ""){
  header("Location: advancedSearch.php?message=search_empty");
} else {

  $sql = "SELECT name, RIGHT(address, 6) as postalcode FROM foodestablishment WHERE name LIKE '%" . $search . "%'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    if (mysqli_num_rows($result) > 0) {

      echo "<table border = 1>";
      echo "<tr><th>Name</th>";
      echo "<th>Postal Code</th>";
      echo "<th>Latitude</th>";
      echo "<th>Longitude</th>";
      echo "<th>Carparks</th></tr>";

      while($row = mysqli_fetch_assoc($result)){
        //reset counter for valid carpark and lot;
        $validCarparks = 0;
        $lotCount = 0;

        //Radius filter
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
        if ($validCarparks >= $input_carpark){//if number of carpark with enough lots meet carpark input
          echo "<tr><td>" . $row["name"] . "</td>";
          echo "<td>" . $row["postalcode"] . "</td>";
          echo "<td>" . $locationVector[0] . "</td>";
          echo "<td>" . $locationVector[1] . "</td>";
          echo "<td>";
          echo $lotCount;
          echo "</td></tr>";
        }
      }
      echo "</table>";
    }
  }
}



?>

</div>
</div>
<?php include_once 'includes/footer_main.php' ?>
