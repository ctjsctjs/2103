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
//echo "Connected successfully <br/>";

$googleKey = 'AIzaSyDwLlB04j3op5bOzPeAQhhygV8bhY8zqWQ';
$datamallKey = 'SFHPvNC5RP+jFTzftMxxFQ==';

$search = $_POST['search'];

$sql = "SELECT name, RIGHT(address, 6) as postalcode FROM foodestablishment WHERE name LIKE '%" . $search . "%'";
$result = mysqli_query($conn, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo "Name: " . $row["name"] . "<br>";
            echo "Postal Code: " . $row["postalcode"] . "<br>";
            $json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=.' . $row['postalcode']. '&key='. $googleKey);
            $json = json_decode($json);

            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

            echo "Latitude: " . $lat . "<br/>";
            echo "Longitude: " . $long . "<br/><br/>";

            #SQL statement to find all carpark within 500m
            $locateSQL = "SELECT *, ( 6371 *
                acos(
                    cos( radians(". $lat .")) * cos( radians( latitude )) *
                    cos( radians( longitude ) - radians(". $long .")) +
                    sin(radians(". $lat .")) * sin(radians(latitude))
                    ))
                as distance FROM carpark HAVING distance < 0.5 ORDER BY distance";

            $locateResult = mysqli_query($conn, $locateSQL);

            if ($locateResult) {
                if (mysqli_num_rows($locateResult) > 0) {
                    while($locateRow = mysqli_fetch_assoc($locateResult)) {
                        echo "carparkID " . $locateRow["carparkId"]. " - distance: " . $locateRow["distance"] . "<br>";

                        /**
                        $opts = array(
                            'http'=>array(
                              'method'=>"GET",
                              'header'=>"Accept-language: json" .
                                        "AccessKey: " . $datamallKey
                            )
                          );

                          $context = stream_context_create($opts);

                          // Open the file using the HTTP headers set above
                          $file = file_get_contents('http://datamall2.mytransport.sg/ltaodataservice/CarParkAvailability', false, $context);
                          print_r($file);**/

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

                        echo "Available Lots: ". $lots ."<br><br/>";

                    }
                }
                 else {
                    echo "0 results <br/>";
                }
         }
        }
    } else {
        echo "0 results";
    }
}



?>
