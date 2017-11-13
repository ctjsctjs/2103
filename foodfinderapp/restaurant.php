<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/databaseconnection.php' ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLgOEetVt0oeA8HdyUmOAdW8O1e0qpB7Q"></script>
<!-- Style for Rating Star (Nizam) -->
<style>
body{width:610;}
.demo-table {width: 196px;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
.demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
.demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
.demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
</style>
<!-->
<?php
	if(isset($_SESSION['FIRSTNAME']))
		include_once 'includes/nav_user.php';
	else
		include_once 'includes/nav_index.php';

	if(isset($_GET['foodEstablishmentId'])) {
		
                // Editted SQL statement (Nizam)
            $foodID = $_GET['foodEstablishmentId'];
		$selectedFoodEstablishment = "SELECT name, address, RIGHT(address, 6) as postalcode,CAST(AVG(review.AvgRating) as decimal(18,1)), COUNT(review.AvgRating) FROM foodestablishment INNER JOIN review ON foodestablishment.foodestablishmentId = review.foodEstablishmentId WHERE foodestablishment.foodEstablishmentId = '".$_GET['foodEstablishmentId']."'";
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

<section class="jumbotron jumbotron-fluid bg-light ">
	 <div class="container">
	 	<div class="row">
		 	<div class="col-lg-8 text-center">
		 		<h2><b><?php echo $row["name"]; ?></b></h2>
		 	 	<p class="lead"><?php echo $row["address"]; ?></p>
<form method="post" action="restaurant.php?foodEstablishmentId=1" id="form" name="form">
<input type="button" value="Save to Favourites" id="view" name="view"/>
<input type="button" value="Rate" id="rate" name="rate"/>
		 	 	
</form>
<?php 
if($_POST && isset($_POST['view']))
   {
      $insert = "INSERT INTO favouritefood(foodestablishmentid, userid, status) 
                  VALUES  ($foodID, 2, 'Y')";
      if ($conn->query($insert) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
   }
   
?>
                                <br><br>
		 	 	<p style="text-align:left"><?php echo $numofreview?> people has reviewed this place</p>
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
                                echo '<ul onMouseOut="resetRating'.$_GET['foodEstablishmentId'].'">';

  for($i=1;$i<=5;$i++) {
  $selected = "";
  if(!empty($row[$p]) && $i<=$row[$p]) {
	$selected = "selected";
  }
  
  echo '<li class="'.$selected.'" onmouseover="highlightStar(this,'.$_GET['foodEstablishmentId'].')" onmouseout="removeHighlight('.$_GET['foodEstablishmentId'].')" onClick="addRating(this,'.$_GET['foodEstablishmentId'].')">&#9733;</li>';
                                
                            }
                            echo '</ul>';
                            echo '</td></tr>';
                            }
                 }
                 
  }
  
  ?>
                    
    
    

</div>



</tbody>
</table>


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