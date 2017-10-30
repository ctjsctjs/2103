<?php include_once 'includes/header.php' ?>
<?php
    if (isset($_SESSION['FIRSTNAME'])) {
        include_once 'includes/nav_user.php';
    } else {
        include_once 'includes/nav_index.php';
    }
?>
<?php include_once 'includes/searchbar.php' ?>

<script src="js\jquery-3.2.1.min.js"></script>
<script src="js\carparkJS.js"></script>

<div class="container-carpark">
  <div class="container-responsive">
<?php
// include database connection
include_once 'protected/databaseconnection.php';
$query = "SELECT * FROM carpark LIMIT 10";
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

        echo "<ul class='list-carpark'>";
        for ($i = 0; $i < $rowcount; $i++) {
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            echo "<li>";
            $lat = $row[2];
            $lng = $row[1];
            //need to get api key to work consistently
            //$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&key=AIzaSyAlgLSolLKRBjHl8T3ED3E6BLsgXuAYYGo&sensor=true";
                        //adding key causes request denied, possibly requires activating
            $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&sensor=true";
            $data = @file_get_contents($url);
            $jsondata = json_decode($data, true);
            $temp1 = "";
            $temp2 = "";
            $temp3 = "";
            $location = $carparkJsonResult->{'value'}[$row[0]-1]->{'Development'};
            if (is_array($jsondata)) {
                if ($jsondata['status'] == "OK") {
                    if (count($jsondata['results']) > 0) {
                        if (count($jsondata['results']['1']["address_components"]) > 2) {
                            $temp1 = $jsondata['results']['1']["address_components"]['2']['long_name'];
                        }
                        if (count($jsondata['results']['1']["address_components"]) > 1) {
                            $temp2 = $jsondata['results']['1']["address_components"]['1']['long_name'];
                        }
                        if (count($jsondata['results']['0']["address_components"]) > 2) {
                            $temp3 = $jsondata['results']['0']["address_components"]['1']['long_name'];
                        }
                    }
                                        /*
                                        echo $temp1 . " ";
                                        echo $temp2 . " ";
                                        echo $temp3;
                                        */
                                        echo "<span class='carpark-location'>".$location."</span>";

                                        //using location name to display map

                                        /*
                                        //using lat lng to display map
                                        echo "<iframe width='200' height='200' frameborder='0' src='//www.google.com/maps/embed/v1/place?q=". $lat . "," . $lng . "&amp;&zoom=17&key=AIzaSyAlgLSolLKRBjHl8T3ED3E6BLsgXuAYYGo' allowfullscreen></iframe>";
                                        echo "</td>";
                                        */
                                        $lots = $carparkJsonResult->{'value'}[$row[0]-1]->{'Lots'};
                    echo "<td id='lot". $row[0] ."'>";
                    echo "<span class='carpark-lots'>".$lots." lots</span>";
                    echo "<iframe width='250' height='250' frameborder='0' src='//www.google.com/maps/embed/v1/place?q=". str_replace(" ", "+", $location) . ",Singapore
&zoom=17
&key=AIzaSyAlgLSolLKRBjHl8T3ED3E6BLsgXuAYYGo' allowfullscreen></iframe>";

                } else {
                    echo "<td>";
                    echo $jsondata['status'];
                    echo "</td>";
                    echo "<td>N.A</td>";
                    echo "<td>N.A</td>";
                }
            }
            echo "</li>";
        }
        echo "</ul>";
    }
}
?>
</div>
</div>
<p id="demo"></p>
<script>
//set to update the lots every 60 seconds
setInterval(function () {
		updateLots();
}, 60000);

</script>
<?php include_once 'includes/footer_main.php' ?>
