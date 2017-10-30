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
    <form class="form" role="form" autocomplete="off" action="advancedSearch_result.php" method="POST">
    <div class="main-row">
      <input type="text" class="main-form" placeholder="Enter a food establishment or carpark" name="search">
      <button type ="submit" class="main-button"><i class="fa fa-search" aria-hidden="true"></i>
      </button>
    </div>
    <div class="slidecontainer">
      <input name="radius" type="range" min="50" max="500" value="50" class="slider" id="radius">
      <p>Value: <span id="radius-output"></span></p>
    </div>
    <div class="slidecontainer" id="slidecontainer2 minimum-carparks">
      <input name="minCarpark" type="range" min="1" max="10" value="1" class="slider" id="minCarpark">
      <p>Value: <span id="minCarpark-output"></span></p>
    </div>
    <div class="slidecontainer" id="minimum-lots">
      <input name="minLots" type="range" min="1" max="100" value="1" class="slider" id="minLots">
      <p>Value: <span id="minLots-output"></span></p>
    </div>
  </form>
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
var slider1 = document.getElementById("radius");
var output1 = document.getElementById("radius-output");
output1.innerHTML = slider1.value;
slider1.oninput = function() {
  output1.innerHTML = this.value;
}

var slider2 = document.getElementById("minLots");
var output2 = document.getElementById("minLots-output");
output2.innerHTML = slider2.value;
slider2.oninput = function() {
  output2.innerHTML = this.value;
}

var slider3 = document.getElementById("minCarpark");
var output3 = document.getElementById("minCarpark-output");
output3.innerHTML = slider3.value;
slider3.oninput = function() {
  output3.innerHTML = this.value;
}
</script>
