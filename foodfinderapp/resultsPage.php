<?php include_once 'includes/header.php' ?>
<?php
if (isset($_SESSION['FIRSTNAME'])) {
  include_once 'includes/nav_user.php';
  include_once 'includes/searchbar.php';
} else {
  include_once 'includes/nav_index.php';
}
?>


<script src="js\jquery-3.2.1.min.js"></script>
<script src="js\carparkJS.js"></script>

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

    $googleKey = 'AIzaSyBUHVlBo1aiN9NZyh1Dzs91msIXblEi0NI';
    $datamallKey = 'SFHPvNC5RP+jFTzftMxxFQ==';

    $search = $_POST['search'];
    $advanced_search = false;
    $radius = 0.5;


    if ($search == ""){
      header("Location: index.php?message=search_empty");
    } else {

      //If advanced search is true

      $sql = "SELECT name, RIGHT(address, 6) as postalcode FROM foodestablishment WHERE name LIKE '%" . $search . "%'";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          echo "<div class='list-carpark'>";

          while($row = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo "<span>" . $row["name"] . "</span>";
            echo "<span>" . $row["postalcode"] . "</span>";
            $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=.' . $row['postalcode']. '&key='. $googleKey);
            $json = json_decode($json);

            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

            echo "<span>" . $lat . "</span>";
            echo "<span>" . $long . "</span>";

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
                    echo "<span>";
                    while($locateRow = mysqli_fetch_assoc($locateResult)) {
                      echo "carparkID" . $locateRow["carparkId"]. " - distance: " . ($locateRow["distance"]*1000) . " metres <br>";

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
                    echo "</span>";
                    echo "</li>";
                  }
                  else {
                    echo "<span>No carparks found</span>";
                  }
                }
              }
              echo "</div>";
            } else {
              echo "0 results";
            }
          }
        }


        ?>
      </div>
    </div>
    <?php include_once 'includes/footer_main.php' ?>
