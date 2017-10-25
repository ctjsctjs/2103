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
    <a href="index.php">
      <img class="main-logo ease"src="images/logo-white.svg">
    </a>
    <a class="button button-white modal-registerBtn" href="./signup.php">Register</a>
    <span class="button button-white modal-loginBtn">Log in</span>
    <p class="main-header">Bringing to you a dining and<br>parking experience like never before</p>
    <div class="main-row">
      <input type="text" class="main-form" placeholder="Enter a food establishment or carpark">
      <button class="main-button"><i class="fa fa-search" aria-hidden="true"></i>
      </button>
    </div>
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
<section class="modal">
  <div class="modal-container" id="modal-login">
    <form class="form" role="form" autocomplete="off" action="index.php" method="POST">
      <span class="modal-login-h">Welcome back!</span>
      <span class="modal-register-text">Don't have an account?</span>
      <span class="modal-link" id="modal-registerlink">Register here.</span>
      <input type="text" class="modal-form" name="email" placeholder="Email" value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
      <span class="modal-error"><?php echo $emailError ?></span>
      <input type="password" class="modal-form" placeholder="Password" name="password" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
      <span class="modal-error"><?php echo $passwordError ?></span>
      <button type="submit" class="modal-login-cfm button-red">Login</button>
      <a href="#" class="modal-link" id="modal-forgotpw">Forget Password?</a>
    </form>
  </div>
</section>

<?php include_once 'includes/footer_main.php' ?>
