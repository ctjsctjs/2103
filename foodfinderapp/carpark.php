<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/databaseconnection.php' ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLgOEetVt0oeA8HdyUmOAdW8O1e0qpB7Q"></script>

<?php
	if(isset($_SESSION['FIRSTNAME']))
		include_once 'includes/nav_user.php';
	else
		include_once 'includes/nav_index.php';

	if(isset($_GET['carparkId'])) {
		
		$selectedCarpark = "SELECT * FROM carpark WHERE carparkId = '".$_GET['carparkId']."'";
		$result = mysqli_query($conn, $selectedCarpark) or die(mysqli_connect_error());
		$row = mysqli_fetch_array($result);		        
	}

	$json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?&latlng='.$row["latitude"].','.$row["longitude"].'&key=AIzaSyDbEqIHfTZwLD9cgm9-elubEhOCm7_C3VE');

	$json1 = json_decode($json);
?>

<section class="jumbotron jumbotron-fluid bg-light ">
	 <div class="container">
	 	<div class="row">
		 	<div class="col-lg-8 text-center">
		 		<h2><b><?php echo $row["development"]; ?></b></h2>
		 		<p class="lead"><?php echo $json1->{'results'}[0]->{'formatted_address'}; ?></p>
		 	 	<button type="button" class="btn btn-default btn-lg active">Save to Favourites</button>
		 	 	<button type="button" class="btn btn-default btn-lg active">Rate</button>
		 	 	<br><br>
		 	 	<p style="text-align:left">0 people has reviewed this place</p>
		 	 	<p style="text-align:left">Accessibility: &#9734;&#9734;&#9734;&#9734;&#9734;</p>
		 	 	<p style="text-align:left">Wheelchair Friendliness: Yes/No</p>
		 	 	<p style="text-align:left">Average Waiting Time: XXX mins</p>
		 	 	<p style="text-align:left">Shelter: Yes/No</p>

		 	</div>
		 	<div class="col-lg-4">
		 		<div id="carparkMap" style="height:400px; weight:400px"></div>
		 	</div>
	 	</div>
	</div>
</section>

<?php include_once 'includes/footer_login_signup.php' ?>

<script>

	function CarparkMap() {

	    maps = new google.maps.Map(document.getElementById('carparkMap'), {
	        zoom: 16,
	        center: {lat: <?php echo $row["latitude"] ?>, lng: <?php echo $row["longitude"] ?>}
	    });

	    addCarparkMarker({lat: <?php echo $row["latitude"] ?>, lng: <?php echo $row["longitude"] ?>}, 'restaurant Name');

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

	google.maps.event.addDomListener(window, 'load', CarparkMap);
</script>