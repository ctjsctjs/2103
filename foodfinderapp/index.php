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

    <?php if(isset($_SESSION['FIRSTNAME'])) {
      $getTopThreeSearches = "SELECT DISTINCT termSearch FROM foodSearch ORDER BY termSearch DESC";
      $result = mysqli_query($conn,  $getTopThreeSearches) or die(mysqli_connect_error());
    }
    ?>
    <div class="row">
      <p>Top 3 searches</p>
      <ul>
        <?php for($a=0; $a<3; $a++) {
          while($row = mysqli_fetch_assoc($result)) { ?>
            <li><?php echo $row['termSearch'] ?></li>
          <?php }?>
        </ul>
      </div>
    <?php } ?>
  </div>
</section>

<section class="container-news">
  <p>The fastest growing startup in based in Singapore!</p>
</section>
<section class="container white wrapper">
  <div class="container-responsive">
    <h1>Worry Free Food Experience</h1>
    <p>Tired of waiting in the car instead of enjoying your delicious food?
      Fret not, FoodPark is here to eliminate your parking problems. FoodPark
      is a web application that tracks real-time data of available parking lots near
      various food establishments, allowing you to locate the nearest available
      parking location.</p>
      <img class="container-img" src="images/car.svg">
    </div>
  </section>
  <section class="container grey wrapper">
    <div class="container-responsive">
      <h1>Search for the best in Singapore</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        In nibh justo, finibus ac semper non, eleifend sed sapien.
        Suspendisse sit amet felis in sem egestas convallis eget ac erat.
        Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue
        tempor maximus. Duis dignissim mauris quis dui semper tempor.
      </p>
      <img class="container-img" src="images/food.svg">
    </div>
  </section>
  <section class="container pink wrapper">
    <div class="container-responsive">
      <h1>Search for the best in Singapore</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        In nibh justo, finibus ac semper non, eleifend sed sapien.
        Suspendisse sit amet felis in sem egestas convallis eget ac erat.
        Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue
        tempor maximus. Duis dignissim mauris quis dui semper tempor.
      </p>
    </div>
  </section>

  <?php include_once 'includes/modal.php' ?>
  <?php include_once 'includes/footer_main.php' ?>
