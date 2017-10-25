<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/login_validation.php' ?>

<?php
  if(isset($_SESSION['FIRSTNAME']))
    include_once 'includes/nav_user.php';
else
  include_once 'includes/nav_index.php';
?>

<section class="container-main">
  <div class="container-responsive">
    <a href="index.php"><img class="main-logo ease"src="images/logo-white.svg"></a>
    <span class="button button-white modal-registerBtn" >Register</span>
    <span class="button button-white modal-loginBtn">Log in</span>

    <p class="main-header">Bringing to you a dining and  <br>parking experience like to other</p>
    <div class="main-row">
      <input type="text" class="main-form" placeholder="Enter a food establishment or carpark">
      <button class="main-button"><i class="fa fa-search" aria-hidden="true"></i>      
      </button>
    </div> 
  </div>
</section>

<div class="container-news">
  <p>The fastest growing startup in based in Singapore!</p>
</div>

<section class="container-white wrapper">
  <h1>Hassle Free Food Experience</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh justo, finibus ac semper non, eleifend sed sapien. Suspendisse sit amet felis in sem egestas convallis eget ac erat. Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue tempor maximus. Duis dignissim mauris quis dui semper tempor. 
  </p>
</section>

<section class="container-pink wrapper">
  <h1>Find out where is the best food</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh justo, finibus ac semper non, eleifend sed sapien. Suspendisse sit amet felis in sem egestas convallis eget ac erat. Vestibulum nec aliquet tortor. Aliquam aliquam lorem non augue tempor maximus. Duis dignissim mauris quis dui semper tempor. 
</section>

<section class="modal-login">
  <div class="modal-container">
    <form class="form" role="form" autocomplete="off" action="login.php" method="POST">
      <h class="modal-login-h">Login</h>
      <input type="text" class="modal-form" name="email" placeholder="Email" value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
      <span class="text-danger"><?php echo $emailError ?></span>
      <input type="password" class="modal-form" placeholder="Password" name="password" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
      <span class="text-danger"><?php echo $passwordError ?></span>
      <span class="float-right"><a href="#">Forget Password?</a></span>

      <a class="" name="signupbtn"  href="./signup.php">Sign Up a New Account!</a>
      <button type="submit" class="button button-red">Login</button> 
    </form>
  </div>
</section>

<?php include_once 'includes/footer_main.php' ?>