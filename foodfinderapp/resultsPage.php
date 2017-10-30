<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodfinderapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
<<<<<<< HEAD
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully <br/>";
=======
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br/>";
>>>>>>> d243771d5fe2de892f1488c11cc7a9e81ef3d9ad

$googleKey = 'AIzaSyBUHVlBo1aiN9NZyh1Dzs91msIXblEi0NI';
$datamallKey = 'SFHPvNC5RP+jFTzftMxxFQ==';

$search = $_POST['search'];
$input_radius = $_POST['radius'];
$input_lots = $_POST['min-Lots'];
$input_carpark = $_POST['min-carpark'];
$advanced_search = false;
$radius = 0.5;


if ($search == ""){
  header("Location: index.php?message=search_empty");
} else {

  //If advanced search is true
  if ($input_radius !=0 || $input_lots !=0 || $input_carpark !=0){
    $advanced_search = true;
    $radius = $input_radius/1000;
    echo $radius. " DISTANCE <br>";
  }

  $sql = "SELECT name, RIGHT(address, 6) as postalcode FROM foodestablishment WHERE name LIKE '%" . $search . "%'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      echo "<table border = 1>";
      echo "<tr><th>Name</th>";
      echo "<th>Postal Code</th>";
      echo "<th>Latitude</th>";
      echo "<th>Longitude</th>";
      echo "<th>Carparks</th></tr>";

      while($row = mysqli_fetch_assoc($result)) {

        $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=.' . $row['postalcode']. '&key='. $googleKey);
        $json = json_decode($json);

        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};


        #SQL statement to find all carpark within 500m
        $locateSQL = "SELECT *, ( 6371 *
          acos(
            cos( radians(". $lat .")) * cos( radians( latitude )) *
            cos( radians( longitude ) - radians(". $long .")) +
            sin(radians(". $lat .")) * sin(radians(latitude))
            ))
            as distance FROM carpark HAVING distance < ". $radius ." ORDER BY distance";

            $locateResult = mysqli_query($conn, $locateSQL);

            if ($locateResult) {
              if (mysqli_num_rows($locateResult) > 0) {
                echo "<tr><td>" . $row["name"] . "</td>";
                echo "<td>" . $row["postalcode"] . "</td>";

                echo "<td>" . $lat . "</td>";
                echo "<td>" . $long . "</td>";

                echo "<td>";
                while($locateRow = mysqli_fetch_assoc($locateResult)) {
                  echo "carparkID" . $locateRow["carparkId"]. " - distance: " . $locateRow["distance"] . "<br>";

                  $carparkLotsJson = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability";

                  $ch      = curl_init( $carparkLotsJson );
                  $options = array(
                    CURLOPT_HTTPHEADER     => array( "AccountKey: ". $datamallKey . ", Accept: application/json" ),
                  );
                  curl_setopt_array( $ch, $options );
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                  $carparkJsonResult = curl_exec( $ch );
                  $carparkJsonResult = json_decode($carparkJsonResult);

                  $lots = $carparkJsonResult->{'value'}[$locateRow["carparkId"]-1]->{'Lots'};

                  echo "Available Lots: ". $lots ."<br><br>";


                }
                echo "</td></tr>";
              }
              else {
                echo "<td>No carparks found</td></tr>";
              }
            }
          }
          echo "</table>";
        } else {
          echo "0 results";
        }
      }
    }


    ?>
