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
    <form role="form" autocomplete="off" action="resultsPage.php" method="POST">
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

  <div class="container-results">
    <div class="loader"></div>

    <div class="container-responsive" style="display:none;">
      <div class="results-btn-row">
        <button class="button button-red" id="toggle-res-food">Food Establishment</button>
        <button class="button button-red" id="toggle-res-carpark">Carpark</button>
      </div>

      <hr class="divider" id="result-divider">

      <!--<a name="foodEstablishment">Food Establishment Search Results<br>-->
      <?php

      $sql = "SELECT foodEstablishmentId, name, RIGHT(address, 6) as postalcode FROM foodestablishment WHERE name LIKE '%" . $_POST["search"] . "%'";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          echo '<div class="results-container" id="res-food-cont">';

          while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="res-row-food">';
            echo '<div class="res-food-img">';
            echo '<img src="images/img_1.jpg">';
            echo '</div>';

            $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=.' . $row['postalcode']. '&key=AIzaSyCaChmDfarbbuKdy_U5P5xY-NtYwvnCbbo');
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
                as distance FROM carpark HAVING distance < 0.5 ORDER BY distance LIMIT 3";

                $locateResult = mysqli_query($conn, $locateSQL) or die(mysqli_connect_error());

                if ($locateResult) {
                  echo "<div class='res-food'>";
                  echo '<a class="results-header hide-overflow" href="restaurant.php?foodEstablishmentId='.$row["foodEstablishmentId"].'">' . $row["name"] . '</a>';
                  if (mysqli_num_rows($locateResult) > 0) {
                    echo "<span class='res-food-subheader'>Carparks Nearby</span>";
                    while($locateRow = mysqli_fetch_assoc($locateResult)) {
                      $carparkLotsJson = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability";
                      $ch = curl_init($carparkLotsJson );
                      $options = array(CURLOPT_HTTPHEADER=>array("AccountKey: SFHPvNC5RP+jFTzftMxxFQ==, Accept: application/json" ),);
                      curl_setopt_array( $ch, $options );
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                      $carparkJsonResult = curl_exec( $ch );
                      $carparkJsonResult = json_decode($carparkJsonResult);
                      $lots = $carparkJsonResult->{'value'}[$locateRow["carparkId"]-1]->{'Lots'};

                      /*EACH BLOCK OF CARPARK*/
                      echo "<div class='res-blocks'>";
                      echo "<span class='res-lots'>". $lots ."</span>";
                      echo "<span class='res-name hide-overflow'>" . $locateRow["development"]. "</span>";
                      echo "<span class='res-dist'>" . sprintf(' %0.2f', $locateRow["distance"])*1000 . "m</span>";
                      echo "</div>";
                      /*END OF CARPARK BLOCK*/
                    }
                  }
                  else {
                    echo "<span class='res-empty'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Carparks Nearby</span>";
                  }
                  echo "<a class='res-more' href='restaurant.php?foodEstablishmentId=".$row['foodEstablishmentId']."'>View more <i class='fa fa-caret-right' aria-hidden='true'></i></a>";
                  echo "</div>";
                }
                echo "</div>";
              }
              echo "</div>";
            } else {
              echo '<div class="results-container" id="res-food-cont">';
              echo "<span class='empty-result'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Results are found. Please try another keyword.</span>";
              echo "</div>";
            }
          }

          ?>

          <?php

          $sql1 = "SELECT * FROM carpark WHERE area LIKE '%" . $_POST["search"] . "%' OR development LIKE '%" . $_POST["search"] . "%'";
          $result1 = mysqli_query($conn, $sql1) or die(mysqli_connect_error());
          if ($result1) {
            if (mysqli_num_rows($result1) > 0) {
              // output data of each row
              echo '<div class="results-container" id="res-carpark-cont">';

              while($row1 = mysqli_fetch_assoc($result1)) {
                $carparkLotsJson = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability";
                $ch = curl_init($carparkLotsJson );
                $options = array(CURLOPT_HTTPHEADER=>array("AccountKey: SFHPvNC5RP+jFTzftMxxFQ==, Accept: application/json" ),);
                curl_setopt_array( $ch, $options );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $carparkJsonResult = curl_exec( $ch );
                $carparkJsonResult = json_decode($carparkJsonResult);
                $lots = $carparkJsonResult->{'value'}[$row1["carparkId"]-1]->{'Lots'};

                echo '<a href=carpark.php?carparkId='.$row1["carparkId"].'" class="res-row-carpark">';
                echo "<span class='res-lots res-lots-carpark'>". $lots ."</span>";
                echo '<div class="res-name" >' . $row1["development"] . '</div>';
                echo "</a>";

              }
              echo "</div>";
            }
            else {
              echo '<div class="results-container" id="res-carpark-cont">';
              echo "<span class='empty-result'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Results are found. Please try another keyword.</span>";
              echo "</div>";
            }
          }
        }
        ?>
      </div>
    </div>


    <?php include_once 'includes/footer_main.php' ?>
    <script type="text/javascript" src="js/lot-color.js"></script>
    <script>
    $( document ).ready(function() {
      $('.container-responsive').show();
      $('.loader').hide();
    });

    $('#toggle-res-carpark').click(function() {
      $("#res-carpark-cont").show();
      $("#res-food-cont").hide();
    });

    $('#toggle-res-food').click(function() {
      $("#res-carpark-cont").hide();
      $("#res-food-cont").show();
    });

    </script>
