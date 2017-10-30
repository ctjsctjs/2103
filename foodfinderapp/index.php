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
    <form class="form" role="form" autocomplete="off" action="protected/login_validation.php" method="POST">
      <span class="modal-login-h">Welcome back!</span>
      <span class="modal-register-text">Don't have an account?</span>
      <span class="modal-link" id="modal-registerlink">Register here.</span>
      <input type="text" class="modal-form" name="email" placeholder="Email" value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
      <span class="modal-error" id="demo"></span>
      <input type="password" class="modal-form" placeholder="Password" name="password" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
      <span class="modal-error"></span>
      <button type="submit" class="modal-login-cfm button-red">Login</button>
      <a href="#" class="modal-link" id="modal-forgotpw">Forget Password?</a>
    </form>
  </div>
  <div class="modal-container" id="modal-register">
    <form class="form" role="form" autocomplete="off" action="protected/signup_validation.php" method="POST">
      <span class="modal-login-h">Register</span>
      <span class="modal-register-text">Have an account?</span>
      <span class="modal-link" id="modal-registerlink">Login here.</span>
      <input type="text" class="modal-form" placeholder="First Name" name="firstName" value="<?php echo (isset($_POST['firstName']) ? $_POST['firstName']:''); ?>">
      <span class="modal-error"></span>
      <input type="text" class="modal-form" placeholder="Last Name" name="lastName" value="<?php echo (isset($_POST['lastName']) ? $_POST['lastName']:''); ?>">
      <span class="modal-error"></span>
      <input type="text" class="modal-form" placeholder="Email" name="email"  value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
      <span class="modal-error"></span>
      <input type="password" class="modal-form" placeholder="Password" name="password" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
      <span class="modal-error"></span>
      <input type="password" class="modal-form" placeholder="Re-enter Password"  name="passwordConfirm" value="<?php echo (isset($_POST['passwordConfirm']) ? $_POST['passwordConfirm']:''); ?>">
      <span class="modal-error"></span>
      <button type="submit" class="modal-login-cfm button-red">Register</button>
    </form>
</div>
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
