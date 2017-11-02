<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/databaseconnection.php' ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLgOEetVt0oeA8HdyUmOAdW8O1e0qpB7Q"></script>


<?php
	if(isset($_SESSION['FIRSTNAME']))
		include_once 'includes/nav_user.php';
	else
		include_once 'includes/nav_index.php';

	if(isset($_GET['foodEstablishmentId'])) {
		
		$selectedFoodEstablishment = "SELECT name, address, RIGHT(address, 6) as postalcode FROM foodestablishment WHERE foodEstablishmentId = '".$_GET['foodEstablishmentId']."'";
		$result = mysqli_query($conn, $selectedFoodEstablishment) or die(mysqli_connect_error());
		$row = mysqli_fetch_array($result);

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

<section class="jumbotron jumbotron-fluid bg-light ">
	 <div class="container">
	 	<div class="row">
		 	<div class="col-lg-8 text-center">
		 		<h2><b><?php echo $row["name"]; ?></b></h2>
		 	 	<p class="lead"><?php echo $row["address"]; ?></p>
		 	 	<button type="button" class="btn btn-default btn-lg active">Save to Favourites</button>
		 	 	<button type="button" class="btn btn-default btn-lg active">Rate</button>
		 	 	<br><br>
		 	 	<p style="text-align:left">0 people has reviewed this place</p>
		 	 	<p style="text-align:left">Quality: &#9734;&#9734;&#9734;&#9734;&#9734;</p>
		 	 	<p style="text-align:left">Cleaniness: &#9734;&#9734;&#9734;&#9734;&#9734;</p>
		 	 	<p style="text-align:left">Comfort: &#9734;&#9734;&#9734;&#9734;&#9734;</p>
		 	 	<p style="text-align:left">Ambience: &#9734;&#9734;&#9734;&#9734;&#9734;</p>
		 	 	<p style="text-align:left">Service: &#9734;&#9734;&#9734;&#9734;&#9734;</p>

		 	</div>
		 	<div class="col-lg-4">
		 		<div id="foodCarparkMap" style="height:400px; weight:400px"></div>
		 	</div>
	 	</div>
	</div>
</section>

<section class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="section-header text-center">
				<h2>Carparks Nearby</h2>
			</div>	
		</div>
	</div>
	<div class="row">
		<ul>
			<?php
				for($i=0; $i < count($carparkNameArray); $i++) {
					echo "<li>Carpark Name: ".$carparkNameArray[$i]."</li>";
					echo "<ul><li>Distance from food establishment: ".$carparkDistanceArray[$i]."m</li>";
					echo "<li>Lots Available: ".$carparkJsonResult->{'value'}[$carparkIdsArray[$i]-1]->{'Lots'}."</li></ul>";
				}
			?>
		</ul>	
	</div>
</section>

<?php include_once 'includes/footer_main.php' ?>

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
	            icon: "img/carpark.png"
	        });

	       
	    }

	    //Add restaurant marker function
	    function addRestaurantMarker(coords, restuarantDetails) {
	        var marker = new google.maps.Marker({
	            position:coords,
	            map:maps,
	            icon: "img/restaurant.png"
	        });
	    }
	    
	}

	google.maps.event.addDomListener(window, 'load', foodEstablishmentMap);
</script>