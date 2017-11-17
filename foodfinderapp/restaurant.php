<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/databaseconnection.php' ?>
<?php
if(isset($_SESSION['FIRSTNAME']))
include_once 'includes/nav_user.php';
else
include_once 'includes/nav_index.php';

if(isset($_GET['foodEstablishmentId'])) {
  ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLgOEetVt0oeA8HdyUmOAdW8O1e0qpB7Q"></script>


  <section class="container-searchbar">
    <div class="container-responsive">
      <span class="page-title">Food Establishment</span>
      <form  role="form" autocomplete="off" action="resultsPage.php" method="POST">
        <div class="search-row">
          <input type="text" class="search-form" placeholder="Enter a food establishment or carpark" name="search">
          <button type ="submit" class="search-button"><i class="fa fa-search" aria-hidden="true"></i>
          </button>
        </div>
      </form>
    </div>
  </section>

  <?php

  // Editted SQL statement (Nizam)
  $foodID = $_GET['foodEstablishmentId'];
  $selectedFoodEstablishment = "SELECT name, address,image, RIGHT(address, 6) as postalcode,CAST(AVG(review.AvgRating) as decimal(18,1)), COUNT(review.AvgRating) FROM foodestablishment INNER JOIN review ON foodestablishment.foodestablishmentId = review.foodEstablishmentId WHERE foodestablishment.foodEstablishmentId = '".$_GET['foodEstablishmentId']."'";
  $result = mysqli_query($conn, $selectedFoodEstablishment) or die(mysqli_connect_error());
  $row = mysqli_fetch_array($result);
  $rating = $row[3];
  $numofreview = $row[4];

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

      // create arrays to store carpark name and distance
      $carparkIdsArray = [];
      $carparkNameArray = [];
      $carparkLatArray = [];
      $carparkLongArray = [];
      $carparkDistanceArray = [];

      if ($locateResult) {
        if (mysqli_num_rows($locateResult) > 0) {
          while($locateRow = mysqli_fetch_assoc($locateResult)) {
            array_push($carparkIdsArray, $locateRow["carparkId"]);
            array_push($carparkNameArray, $locateRow["development"]);
            array_push($carparkLatArray, $locateRow["latitude"]);
            array_push($carparkLongArray, $locateRow["longitude"]);
            array_push($carparkDistanceArray, sprintf('%0.2f', $locateRow["distance"])*1000);

          }
        }
      }
      $carparkLotsJson = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability";

      $ch      = curl_init( $carparkLotsJson );
      $options = array(
        CURLOPT_HTTPHEADER     => array( "AccountKey: SFHPvNC5RP+jFTzftMxxFQ==, Accept: application/json" ),
      );
      curl_setopt_array( $ch, $options );
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

      $carparkJsonResult = curl_exec( $ch );
      $carparkJsonResult = json_decode($carparkJsonResult);
    }
    ?>

    <div class="container-results">
      <div class="container-responsive">

        <div class="res-left-col">
          <div class="res-wrapper">
            <div class="res-wrapper-header">
              <h><?php echo $row["name"]; ?></h>
            </div>
            <div class="food-img" style="background-image: url(images/<?php echo $row['image'] ?>)">
            </div>
          </div>
          <div class="res-body">
            <span class="res-add"><?php echo $row["address"]; ?></span>
            <table class="demo-table">
              <tbody>
                <div id="tutorial-<?php echo $_GET['foodEstablishmentId']; ?>">
                  <?php $property=array("Quality","Cleaniness","Comfort","Ambience","Service"); ?>
                  <?php
                  $reviewquery = "SELECT ROUND(AVG(quality)) AS quality, ROUND(AVG(clean)) AS clean,ROUND(AVG(comfort)) AS comfort,ROUND(AVG(ambience)) AS ambience,ROUND(AVG(service)) AS service FROM review WHERE foodestablishmentID = '".$_GET['foodEstablishmentId']."'";
                  $listreview = mysqli_query($conn, $reviewquery);
                  $property=array("Quality","Cleaniness","Comfort","Ambience","Service");
                  if ($listreview) {
                    while ($row = mysqli_fetch_row($listreview)) {
                      $count = 0;

                      for($p = 0; $p < 5;$p++ ){
                        echo '<tr><td>'.$property[$p].'</td>';
                        echo '<td><input type="hidden" name="rating" id="rating" value="'.$rating.'"/>';
                        echo '<ul>';
                        for($i=1;$i<=5;$i++) {
                          $selected = "";
                          if(!empty($row[$p]) && $i<=$row[$p]) {
                            $selected = "selected";
                          }
                          echo '<li class="'.$selected.'">&#9733;</li>';
                        }
                        echo '</ul>';
                        echo '</td></tr>';
                      }
                    }
                  }

                  ?>
                </div>
              </div>
            </tbody>
          </table>
          <span class="res-no-review"><?php echo $numofreview?> reviews</span>

        </div>
      </div>

      <div class="res-right-col">
        <?php
        $userID = $_SESSION['ID'];
        if (isset($_POST['saveFood']) == 'save'.$foodID){
          $insert = "INSERT INTO favouritefood(foodestablishmentid, userid, status)
          VALUES  ($foodID,$userID , '1')";
          if ($conn->query($insert) === TRUE) {
            echo "<span class='res-saved'><i class='fa fa-check' aria-hidden='true'></i> Added to favourites</span>";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
        echo "<form method='post' action='restaurant.php?foodEstablishmentId=".$foodID."' id='form' name='form'>"
        . "<input type='hidden' name='saveFood' value='save".$foodID."'>"
        . "<button class='button button-red button-wide' id='btn-save'>Save</button>"
        . "<a href='foodReview.php?foodEstablishmentId=".$foodID."' class='button button-red button-wide'>Rate</a>"
        . "</form>";
        ?>
      </div>

      <div class="res-right-col"><div id="foodCarparkMap"></div></div>

      <div class="res-right-col">
        <span class='res-food-subheader'>Carparks nearby</span>
        <?php
        if (count($carparkNameArray) > 0) {

          for($i=0; $i < count($carparkNameArray); $i++) {
            echo '<a href=carpark.php?carparkId=1" class="res-blocks">';
            echo "<span class='res-lots'>".$carparkJsonResult->{'value'}[$carparkIdsArray[$i]-1]->{'Lots'}."</span>";
            echo '<div class="res-name" >' .$carparkNameArray[$i]. '</div>';
            echo '<div class="res-dist" >' .$carparkDistanceArray[$i]. 'm</div>';
            echo "</a>";
          }
        }
        else{
          echo "<span class='res-empty'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Carparks Nearby</span>";
        }

        ?>
      </div>
    </div>
  </div>

  <?php include_once 'includes/footer_main.php' ?>
  <script type="text/javascript" src="js/lot-color.js"></script>

  <script>

  function foodEstablishmentMap() {

    maps = new google.maps.Map(document.getElementById('foodCarparkMap'), {
      zoom: 16,
      center: {lat: <?php echo $lat ?>, lng: <?php echo $long ?>}
    });

    addRestaurantMarker({lat: <?php echo $lat ?>, lng: <?php echo $long ?>}, 'restaurant Name');

    <?php
    $max2 = sizeof($carparkLatArray);
    for($j=0; $j < $max2; $j++) {
      ?>
      addCarparkMarker({lat: <?php echo $carparkLatArray[$j] ?>, lng: <?php echo $carparkLongArray[$j] ?>});
      <?php
    }
    ?>

    //Add carpark marker function
    function addCarparkMarker(coords, carparkDetails) {
      var marker = new google.maps.Marker({
        position:coords,
        map:maps,
        icon: "images/carpark.png"
      });


    }

    //Add restaurant marker function
    function addRestaurantMarker(coords, restuarantDetails) {
      var marker = new google.maps.Marker({
        position:coords,
        map:maps,
        icon: "images/restaurant.png"
      });
    }

  }

  google.maps.event.addDomListener(window, 'load', foodEstablishmentMap);
</script>
