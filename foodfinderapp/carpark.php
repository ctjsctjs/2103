<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/databaseconnection.php' ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLgOEetVt0oeA8HdyUmOAdW8O1e0qpB7Q"></script>
<style>
body{width:610;}
.demo-table {width: 225px;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
.demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
.demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
.demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
</style>
<?php
	if(isset($_SESSION['FIRSTNAME']))
		include_once 'includes/nav_user.php';
	else
		include_once 'includes/nav_index.php';

	if(isset($_GET['carparkId'])) {
		$carparkID = $_GET['carparkId'];
		$selectedCarpark = "SELECT latitude,longitude,development,CAST(AVG(feedback.AvgRating) as decimal(18,1)), COUNT(feedback.AvgRating) FROM carpark INNER JOIN feedback ON carpark.carparkId = feedback.carparkId WHERE carpark.carparkId = '".$_GET['carparkId']."'";
		$result = mysqli_query($conn, $selectedCarpark) or die(mysqli_connect_error());
		$row = mysqli_fetch_array($result);
                $rating = $row[3];
                $numofreview = $row[4];
                $latitude = $row[0];
                $longtitude = $row[1];


	}

	$json = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?&latlng='.$row["latitude"].','.$row["longitude"].'&key=AIzaSyDbEqIHfTZwLD9cgm9-elubEhOCm7_C3VE');

	$json1 = json_decode($json);
?>


	 <div class="container">
	 	<div class="row">
		 	<div class="col-lg-8 text-center">
		 		<h2><b><?php echo $row["development"]; ?></b></h2>
		 		<p class="lead"><?php echo $json1->{'results'}[0]->{'formatted_address'}; ?></p>
		 	 	<?php echo "<form method='post' action='carpark.php?carparkId=".$carparkID."' id='form' name='form'>"
. "<input type='hidden' name='saveFood' value='save".$carparkID."'>"
        . "<button class='button'>Save</button>"
        . "<a href='carparkReview.php?carparkId=".$carparkID."' class='button button-red'>Rate</a></td></li>"
. "</form>";


	?>
                                <?php
 $userID = $_SESSION['ID'];
    if (isset($_POST['saveFood']) == 'save'.$carparkID){
      $insert = "INSERT INTO favouriteCarpark(carparkId, userId, status)
                  VALUES  ($carparkID,$userID , '1')";
      if ($conn->query($insert) === TRUE) {
    echo "Added to favourites";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
   }

?>
		 	 	<br><br>
		 	 	<table class="demo-table">
<tbody>
<div id="tutorial-<?php echo $_GET['carparkId']; ?>">
    <?php $property=array("Accessiblity","Cleaniness","Parking Rate","Space","User Friendly"); ?>
    <?php
                 $reviewquery = "SELECT ROUND(AVG(accessibility)) AS accessibility, ROUND(AVG(clean)) AS clean,ROUND(AVG(parkRate)) AS parkRate,ROUND(AVG(space)) AS space,ROUND(AVG(userFriendly)) AS userFriendly FROM feedback WHERE carparkId = '".$_GET['carparkId']."'";
                 $listreview = mysqli_query($conn, $reviewquery);

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






</tbody>
</table>

		 	</div>
		 	<div class="col-lg-4">
		 		<div id="carparkMap" style="height:400px; weight:400px"></div>
		 	</div>
	 	</div>
	</div>


<?php include_once 'includes/footer_login_signup.php' ?>

<script>

	function CarparkMap() {

	    maps = new google.maps.Map(document.getElementById('carparkMap'), {
	        zoom: 16,
	        center: {lat: <?php echo $latitude ?>, lng: <?php echo $longtitude ?>}
	    });

	    addCarparkMarker({lat: <?php echo $latitude ?>, lng: <?php echo $longtitude ?>}, 'restaurant Name');

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

	google.maps.event.addDomListener(window, 'load', CarparkMap);
</script>
