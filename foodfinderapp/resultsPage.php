<?php include_once 'includes/header.php' ?>

<?php
if(isset($_SESSION['FIRSTNAME']))
include_once 'includes/nav_user.php';
else
include_once 'includes/nav_index.php';
?>
<section class="container-searchbar">
  <div class="container-responsive">
    <span class="page-title">Search Results</span>

    <form class="form" role="form" autocomplete="off" action="resultsPage.php" method="POST">
      <div class="search-row">
        <input type="text" class="search-form" placeholder="Enter a food establishment or carpark" name="search">
        <button type ="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </div>
    </form>
  </div>
</section>

<?php
include_once 'protected/databaseconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  ?>

  <div class="container-carpark">
    <div class="container-responsive">
      <ul class="section-header text-center favourites">
        <li style="display: inline"><a href="#foodEstablishment"><b>Food Establishment Search Results</b></a></li>
        <li style="display: inline"> | </li>
        <li style="display: inline"><a href="#carpark"><b>Carpark Search Results</b></a></li>
      </ul>

      <!--<a name="foodEstablishment">Food Establishment Search Results<br>-->
      <?php

      $sql = "SELECT foodEstablishmentId, name, RIGHT(address, 6) as postalcode FROM foodestablishment WHERE name LIKE '%" . $_POST["search"] . "%'";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          echo '<div class="results-container">';

          while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="results-row">';
            echo '<a href="restaurant.php?foodEstablishmentId='.$row["foodEstablishmentId"].'">' . $row["name"] . '</a>';

            $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=.' . $row['postalcode']. '&key=AIzaSyDbEqIHfTZwLD9cgm9-elubEhOCm7_C3VE');
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
                as distance FROM carpark HAVING distance < 0.5 ORDER BY distance";

                $locateResult = mysqli_query($conn, $locateSQL) or die(mysqli_connect_error());

                if ($locateResult) {
                  if (mysqli_num_rows($locateResult) > 0) {
                    echo "<td><br>";
                    while($locateRow = mysqli_fetch_assoc($locateResult)) {

                      echo "Carpark name:" . $locateRow["development"]. "<br>";
                      echo "Distance from food establishment: " . sprintf('%0.2f', $locateRow["distance"])*1000 . "m<br>";

                      $carparkLotsJson = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability";

                      $ch = curl_init($carparkLotsJson );
                      $options = array(CURLOPT_HTTPHEADER=>array("AccountKey: SFHPvNC5RP+jFTzftMxxFQ==, Accept: application/json" ),);
                      curl_setopt_array( $ch, $options );
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                      $carparkJsonResult = curl_exec( $ch );
                      $carparkJsonResult = json_decode($carparkJsonResult);

                      $lots = $carparkJsonResult->{'value'}[$locateRow["carparkId"]-1]->{'Lots'};

                      echo "Lots Available: ". $lots;
                    }
                  }
                  else {
                    echo "<td>No Carparks Nearby</td></tr>";
                  }
                }
                echo "</div>";

              }
              echo "</div>";
            } else {
              echo "0 results";
            }
          }

          ?></a>

          <br><br><br>

          <a name="carpark">Carpark Search Results<br><?php

          $sql1 = "SELECT * FROM carpark WHERE area LIKE '%" . $_POST["search"] . "%' OR development LIKE '%" . $_POST["search"] . "%'";
          $result1 = mysqli_query($conn, $sql1) or die(mysqli_connect_error());
          if ($result1) {
            if (mysqli_num_rows($result1) > 0) {
              // output data of each row
              echo "<table border = 1>";
              echo "<tr><th>Carpark Name</th>";
              echo "<th>Food Establishments Nearby</th></tr>";

              while($row1 = mysqli_fetch_assoc($result1)) {
                echo '<tr><td><br><a href="carpark.php?carparkId='.$row1["carparkId"].'">' . $row1["development"] . '</a><br>';

                $carparkLotsJson = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability";

                $ch = curl_init($carparkLotsJson );
                $options = array(CURLOPT_HTTPHEADER=>array("AccountKey: SFHPvNC5RP+jFTzftMxxFQ==, Accept: application/json" ),);
                curl_setopt_array( $ch, $options );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

                $carparkJsonResult = curl_exec( $ch );
                $carparkJsonResult = json_decode($carparkJsonResult);

                $lots = $carparkJsonResult->{'value'}[$row1["carparkId"]-1]->{'Lots'};

                echo "Lots Available: ". $lots ."<br><br></td>";

                echo "<td>";

                echo "i will try to do the food establishments nearby but not confirm can complete it.";

                echo"</td></tr>";
              }
              echo "</table>";
            }
            else {
              echo "0 results";
            }
          }
        }
        ?></a>
      </div>
    </div>
