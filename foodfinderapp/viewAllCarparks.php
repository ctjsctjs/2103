<?php
include_once 'includes/header.php';
include_once 'protected/databaseconnection.php';

if (isset($_SESSION['FIRSTNAME'])) {
  include_once 'includes/nav_user.php';
} else {
  include_once 'includes/nav_index.php';
}
?>

<section class="container-searchbar">
  <div class="container-responsive">
    <span class="page-title">Carparks</span>
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
    <?php
    $query = "SELECT * FROM carpark";
    if ($result = mysqli_query($conn, $query) or die(mysqli_connect_error)) {
      $rowcount = mysqli_num_rows($result);
      if ($rowcount > 0) {
        $datamallKey = 'SFHPvNC5RP+jFTzftMxxFQ==';
        $carparkLotsJson = "http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability";

        $ch      = curl_init($carparkLotsJson);
        $options = array(
          CURLOPT_HTTPHEADER     => array( "AccountKey: ". $datamallKey . ", Accept: application/json" ),
        );
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $carparkJsonResult = curl_exec($ch);
        $carparkJsonResult = json_decode($carparkJsonResult);

        echo '<div class="results-container" id="res-carpark-cont">';
        for ($i = 0; $i < $rowcount; $i++) {
          $row = mysqli_fetch_array($result, MYSQLI_NUM);
          $lat = $row[2];
          $lng = $row[1];
          $lots = $carparkJsonResult->{'value'}[$row[0]-1]->{'Lots'};
          $location =  $carparkJsonResult->{'value'}[$row[0]-1]->{'Development'};
          echo '<a href=carpark.php?carparkId='.$row[0].' class="res-row-carpark">';
          echo "<span class='res-lots res-lots-carpark'>". $lots ."</span>";
          echo '<div class="res-name" >' .$location. '</div>';
          echo "</a>";
        }
      }
      echo "</div>";
    }
    ?>
  </div>
</div>
<p id="demo"></p>

<?php include_once 'includes/footer_main.php' ?>
<script type="text/javascript" src="js/carparkJS.js"></script>
<script type="text/javascript" src="js/lot-color.js"></script>
