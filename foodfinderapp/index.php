<?php include_once 'includes/header.php' ?>

<?php
  if(isset($_SESSION['FIRSTNAME']))
    include_once 'includes/nav_user.php';
else
  include_once 'includes/nav_index.php';
?>

<section class="container-search">
  <a href="index.php"><img class="search-logo ease"src="images/logo-white.svg"></a>
  <p>Parking and eating<br>has never been easier</p>
  <div class="search-row">
    <input type="text" class="search-form" placeholder="Enter a food establishment or carpark">
    <button class="search-button"><i class="fa fa-search" aria-hidden="true"></i>      
    </button>
  </div> 
</section>

<section class="container-news">
  <p>The fastest growing startup in based in Singapore!</p>
</section>

<section class="container-white wrapper">
  <h1>Hassle Free Food Experience</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh justo, finibus ac semper non, eleifend sed sapien. Suspendisse sit amet felis in sem egestas convallis eget ac erat. Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue tempor maximus. Duis dignissim mauris quis dui semper tempor. 
  </p>
</section>

<section class="container-pink wrapper">
  <h1>Find out where is the best food</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh justo, finibus ac semper non, eleifend sed sapien. Suspendisse sit amet felis in sem egestas convallis eget ac erat. Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue tempor maximus. Duis dignissim mauris quis dui semper tempor. 
</section>


<?php include_once 'includes/footer_main.php' ?>