<?php include_once 'includes/header.php' ?>

<?php
  if(isset($_SESSION['FIRSTNAME']))
    include_once 'includes/nav_user.php';
else
  include_once 'includes/nav_index.php';
?>

<section class="container-search">
  <div class="bg"></div>
  <div class="button-container">
    <a href="login.php"><span class="button" id="login-button">Log in</span></a>
    <a href="login.php"><span class="button">Register</span> </a>
  </div>

  <div class="search-inner wrapper">
    <img src="images/logo.svg">
    <p>Parking and eating has never been easier</p>
    <div class="search-inner-row">
      <input type="text" class="search-form" placeholder="&#xf002; Enter a food establishment or carpark...">
    </div>
  </div> 
</section>

<section class="container-description wrapper">
  <h1>Hassle Free Food Experience</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh justo, finibus ac semper non, eleifend sed sapien. Suspendisse sit amet felis in sem egestas convallis eget ac erat. Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue tempor maximus. Duis dignissim mauris quis dui semper tempor. 
  </p>
</section>

<section class="container-feature wrapper">
  <h1>Find out where is the best food</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh justo, finibus ac semper non, eleifend sed sapien. Suspendisse sit amet felis in sem egestas convallis eget ac erat. Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue tempor maximus. Duis dignissim mauris quis dui semper tempor. 
</section>

<?php include_once 'includes/footer_main.php' ?>