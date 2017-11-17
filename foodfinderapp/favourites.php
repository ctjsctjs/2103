<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/databaseconnection.php' ?>

<?php
if(isset($_SESSION['FIRSTNAME']))
include_once 'includes/nav_user.php';
else
include_once 'includes/nav_index.php';
?>
<script src="js\jquery-3.2.1.min.js"></script>

<div class="container-carpark">
	<h2>Favourite Food Place</h2>
	<div class="container-responsive">
		<!-- QUERY NEED TO CHANGE AT WHERE STATEMENT -->
		<!-- SESSION["ID"] can't retrieve, for now temporary put "1" -->
		<!-- NIZAM -->
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			if (isset($_POST['deleteFavorite']))
			{
				$orderID = $_POST['deleteFavorite'];
				$deleteQuery = "DELETE from favouritefood WHERE favfoodID = ".$orderID;

				if ($conn->query($deleteQuery) === TRUE) {
					echo "Record deleted successfully</br>";
				} else {
					echo "Error deleting record: " . $conn->error;
				}
			}


		}
		$query = "SELECT favouritefood.favFoodID,foodestablishment.name,foodestablishment.address FROM `favouritefood` INNER JOIN foodestablishment on favouritefood.foodestablishmentId = foodestablishment.foodEstablishmentId WHERE favouritefood.userID = ".$_SESSION['ID'];
		if ($result = mysqli_query($conn, $query) or die(mysqli_connect_error)) {
			$rowcount = mysqli_num_rows($result);
			if ($rowcount > 0) {
				echo "<ul class='list-carpark'>";
				for ($i = 0; $i < $rowcount; $i++) {
					$row = mysqli_fetch_array($result, MYSQLI_NUM);
					echo "<li id='lot'><td><span class='carpark-location'>".$row[1]."</span><span class='carpark-lots lots-color'>".$row[2]."</span><span>"
					. "<form class='view-delete-form' role='form' method='POST' action='favourites.php'>"
					. "<a href='restaurant.php?foodEstablishmentId='".$row[1]."' class='button'>View</button>"
					. "<input type='hidden' name='deleteFavorite' value='".$row[0]."'><button class='button button-red'>Delete</button></td></li></form>";

				}
			}
			else {
				echo "No favourite";
			}
			echo "</ul>";
		}
		?>
	</div>
	<h2>Favourite Carpark</h2>
	<div class="container-responsive">

		<?php   $query = "SELECT favouriteCarpark.carparkId,carpark.carparkId,carpark.development,carpark.area FROM `favouriteCarpark` INNER JOIN carpark on favouriteCarpark.carparkId = carpark.carparkId WHERE favouriteCarpark.userID = ".$_SESSION['ID'];
		
		if ($result = mysqli_query($conn, $query) or die(mysqli_connect_error)) {
			$rowcount = mysqli_num_rows($result);
			if ($rowcount > 0) {
				echo "<ul class='list-carpark'>";
				for ($i = 0; $i < $rowcount; $i++) {
					$row = mysqli_fetch_array($result, MYSQLI_NUM);

					echo "<li id='lot'><td><span class='carpark-location'>".$row[2]."</span><span class='carpark-lots lots-color'>".$row[2]."</span><span>"
					."<form class='view-delete-form' role='form' method='POST' action='favourites.php'>"
					. "<a href='restaurant.php?foodEstablishmentId=".$row[1]."' class='button'>View</a>"
					."<input type='hidden' name='deleteFavorite' value='".$row[0]."'><button class='button button-red'>Delete</button></td></li>"
					."</form>";

				}
			}
			else {
				echo "No favourite";
			}
			echo "</ul>";
		}
		?>
	</div>
</div>
<!--<section class="container">
<div class="row">
<div class="col-md-12">
<ul class="section-header text-center favourites">
<li style="display: inline"><a href="#foodEstablishment"><b>Food Establishment</b></a></li>
<li style="display: inline"> | </li>
<li style="display: inline"><a href="#carpark"><b>Carpark</b></a></li>
<ul>
</div>
</div>
<section>-->

<?php include_once 'includes/footer_login_signup.php' ?>
