<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/databaseconnection.php' ?>

<?php
if(isset($_SESSION['FIRSTNAME']))
include_once 'includes/nav_user.php';
else
include_once 'includes/nav_index.php';
?>

<section class="container-main">
  <div class="container-responsive">
    <a href="index.php">
      <img class="main-logo ease public"src="images/logo-white.svg">
    </a>
    <span class="button button-white modal-registerBtn public">Register</span>
    <span class="button button-white modal-loginBtn public">Log in</span>
    <p class="main-header">Bringing to you a dining and<br>parking experience like never before</p>
    <form role="form" autocomplete="off" action="resultsPage.php" method="POST">
      <div class="main-row">
        <input type="text" class="main-form" placeholder="Enter a food establishment or carpark" name="search">
        <button type ="submit" class="main-button"><i class="fa fa-search" aria-hidden="true"></i></button>
      </div>
    </form>
    <?php if(isset($_SESSION['ID'])) {
        
        $getTermSearches = "SELECT termSearch FROM foodSearch WHERE userId = ".$_SESSION['ID']." ORDER BY datetimeSearch DESC";
        $result = mysqli_query($conn,  $getTermSearches) or die(mysqli_connect_error());
        
        $count = 0;
        $recentSearches = "";
        
        if (mysqli_num_rows($result) > 0) {
            echo "<p>You've recently searched for: </p>";
            while(($row = mysqli_fetch_assoc($result)) and ($count != 3)) {
                if($recentSearches == "") {
                    echo "<form action='resultsPage.php' method='POST'><input type='hidden' name='search' class='form-control' value='".$row['termSearch']."'><button class='recentSearchesButton' type='submit'>".$row['termSearch']."</button></form>";
                    $recentSearches = $row['termSearch'];
                    $count++;
                }else if($recentSearches != $row['termSearch']) {
                   echo "<form action='resultsPage.php' method='POST'><input type='hidden' name='search' class='form-control' value='".$row['termSearch']."'><button class='recentSearchesButton' type='submit'>".$row['termSearch']."</button></form>";
                    $recentSearches = $row['termSearch'];
                    $count++;
                }
            }
        }
    }
    ?>
  </div>
</section>

<section class="container-news">
  <p>The fastest growing startup in based in Singapore!</p>
</section>
<section class="container-featured">
  <div class=" container-responsive">
    <h1 class="header-verified">Verified by you</h1>
    <span class="text-verified"> Check out the highest rated food places rating by the community </span>
    <hr class="divider" id="result-divider">
    <?php include_once 'includes/featured.php' ?>
  </div>
</section>
<section class="container white wrapper">
  <div class="container-responsive">
    <h1>Worry Free Food Experience</h1>
    <p>Tired of waiting in the car instead of enjoying your delicious food?
      Fret not, FoodPark is here to eliminate your parking problems. FoodPark
      is a web application that tracks real-time data of available parking lots near
      various food establishments, allowing you to locate the nearest available
      parking location.</p>
      <a href="viewAllFood.php"><span class="button button-red" id="foodEst-link">Browse Food Places</span></a>
      <img class="container-img" src="images/car.svg">
    </div>
  </section>
  <section class="container grey wrapper">
    <div class="container-responsive">
      <h1>Search quickly with precision</h1>
      <p>Our search algorithm brings the best results to you within seconds,
        making sure you find a place to park and eat as quick as possible. Our
        Advanced Search allows you to make detailed searches, solving all your
        parking frustrations. </p>
        <a href="advancedSearch.php"><span class="button button-white" id="advSearch-link">Try Advanced Search</span></a>
        <img class="container-img-search" src="images/search.svg">
      </div>
    </section>

    <?php include_once 'includes/footer_main.php' ?>
