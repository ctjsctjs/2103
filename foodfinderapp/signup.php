<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/signup_validation.php' ?>

<?php
  include_once 'includes/nav_index.php';
?>
<div class="register-wrapper">
<div class="container-register-left"></div>
<div class="container-register-right">
  <form class="signup-form" role="form" autocomplete="off" action="signup.php" method="POST">
      <div class="form-group">
          <input type="text" class="reg-form" name="firstName" value="<?php echo (isset($_POST['firstName']) ? $_POST['firstName']:''); ?>">
          <span class="text-danger"><?php echo $firstnameError ?></span>
      </div>
      <div class="form-group">
          <input type="text" class="reg-form" name="lastName" value="<?php echo (isset($_POST['lastName']) ? $_POST['lastName']:''); ?>">
          <span class="text-danger"><?php echo $lastnameError ?></span>
      </div>
      <div class="form-group">
          <input type="text" class="reg-form" name="email"  value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
          <span class="text-danger"><?php echo $emailError ?></span>
      </div>
      <div class="form-group">
          <input type="password" class="reg-form" name="password""" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
          <span class="text-danger"><?php echo $passwordError ?></span>
      </div>
      <div class="form-group">
          <input type="password" class="reg-form" name="passwordConfirm"  value="<?php echo (isset($_POST['passwordConfirm']) ? $_POST['passwordConfirm']:''); ?>">
          <span class="text-danger"><?php echo $passwordConError ?></span>
      </div>
      <a class="btn btn-outline-dark my-2 my-sm-0 float-left" name="backbtn"  href="./index.php">Back</a>
<button type="submit" class="btn btn-outline-dark my-2 my-sm-0 float-right">Submit</button>
  </form>
</div>
</div>

<?php include_once 'includes/footer_main.php' ?>
