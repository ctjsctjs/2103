<?php include_once 'includes/header.php' ?>

<?php
  if(isset($_SESSION['FIRSTNAME']))
    include_once 'includes/nav_user.php';
else
  include_once 'includes/nav_index.php';
?>

<section class="container-main">
  <div class="container-responsive">
    <a href="index.php">
      <img class="main-logo ease"src="images/logo-white.svg">
    </a>
    <span class="button button-white modal-registerBtn">Register</span>
    <span class="button button-white modal-loginBtn">Log in</span>
    <p class="main-header">Bringing to you a dining and<br>parking experience like never before</p>
    <form class="form" role="form" autocomplete="off" action="resultsPage.php" method="POST">
    <div class="main-row">
      <input type="text" class="main-form" placeholder="Enter a food establishment or carpark" name="search">
      <button type ="submit" class="main-button"><i class="fa fa-search" aria-hidden="true"></i>
      </button>
    </div>
    <div class="slidecontainer">
      <input name="radius" type="range" min="0" max="500" value="0" class="slider" id="radius">
      <p>Value: <span id="radius-output"></span></p>
    </div>
    <div class="slidecontainer" id="minimum-lots">
      <input name="min-Lots" type="range" min="0" max="30" value="0" class="slider" id="myRange">
      <p>Value: <span id="demo"></span></p>
    </div>
    <div class="slidecontainer" id="slidecontainer2 minimum-carparks">
      <input name="min-carpark" type="range" min="0" max="10" value="0" class="slider" id="myRange">
      <p>Value: <span id="demo"></span></p>
    </div>
  </form>
  <a href="advancedSearch_result.php">Advanced Search</a>
  </div>
</section>

<section class="container-news">
  <p>The fastest growing startup in based in Singapore!</p>
</section>
<section class="container-white wrapper">
  <h1>Hassle Free Food Experience</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh justo, finibus ac semper non, eleifend sed sapien. Suspendisse sit amet felis in sem egestas convallis eget ac erat. Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue tempor maximus. Duis dignissim mauris quis dui semper tempor.</p>
</section>
<section class="container-pink wrapper">
  <h1>Find out where is the best food</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh justo, finibus ac semper non, eleifend sed sapien. Suspendisse sit amet felis in sem egestas convallis eget ac erat. Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue tempor maximus. Duis dignissim mauris quis dui semper tempor.
</section>

<script>
var slider = document.getElementById("radius");
var output = document.getElementById("radius-output");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>

<?php include_once 'includes/footer_main.php' ?>
