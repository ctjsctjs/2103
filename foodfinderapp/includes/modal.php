<section class="modal">
  <div class="modal-container" id="modal-login">
    <form role="form" autocomplete="off" action="protected/login_validation.php" method="POST">
      <span class="modal-login-h">Welcome back!</span>
      <span class="modal-register-text">Don't have an account?</span>
      <span class="modal-link" id="modal-registerlink">Register here.</span>
      <input type="text" class="modal-form" name="email" placeholder="Email" value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
      <span class="modal-error login-err" id="login-err">
        <?php
        if(isset($_GET['loginEmail'])){
          if ($_GET['loginEmail']=="empty"){
            echo "&#xf06a; Please enter your email";
          } else if ($_GET['loginEmail']=="invalid"){
            echo "&#xf06a; The account is invalid.";
          }
        }
        ?>
      </span>
      <input type="password" class="modal-form" placeholder="Password" name="password" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
      <span class="modal-error login-err">
        <?php
        if(isset($_GET['loginPw'])){
          if ($_GET['loginPw']=="empty"){
            echo "&#xf06a; Please enter your password.";
          } else if ($_GET['loginPw']=="invalid"){
            echo "&#xf06a; The password is invalid.";
          }
        }
        ?>
      </span>
      <button type="submit" class="modal-login-cfm button-red">Login</button>
      <a href="#" class="modal-link" id="modal-forgotpw">Forget Password?</a>
    </form>
  </div>
  <div class="modal-container" id="modal-register">
    <form role="form" autocomplete="off" action="protected/signup_validation.php" method="POST">
      <span class="modal-login-h">Register</span>
      <span class="modal-register-text">Already have an account?</span>
      <span class="modal-link" id="modal-loginlink">Login here.</span>
      <input type="text" class="modal-form" placeholder="First Name" name="firstName" value="<?php echo (isset($_POST['firstName']) ? $_POST['firstName']:''); ?>">
      <span class="modal-error reg-err">
        <?php
        if(isset($_GET['regFname'])){
          if ($_GET['regFname']=="empty"){
            echo "&#xf06a; Please enter your First Name.";
          } else if ($_GET['regFname']=="alphaNum"){
            echo "&#xf06a; Please only enter alpha numeric characters.";
          }
        }
        ?>
      </span>
      <input type="text" class="modal-form" placeholder="Last Name" name="lastName" value="<?php echo (isset($_POST['lastName']) ? $_POST['lastName']:''); ?>">
      <span class="modal-error reg-err">
        <?php
        if(isset($_GET['regLname'])){
          if ($_GET['regLname']=="empty"){
            echo "&#xf06a; Please enter your Last Name.";
          } else if ($_GET['regLname']=="alphaNum"){
            echo "&#xf06a; Please only enter alpha numeric characters.";
          }
        }
        ?>
      </span>
      <input type="text" class="modal-form" placeholder="Email" name="email"  value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
      <span class="modal-error reg-err">
        <?php
        if(isset($_GET['regEmail'])){
          if ($_GET['regEmail']=="empty"){
            echo "&#xf06a; Please enter your email.";
          } else if ($_GET['regEmail']=="invalid"){
            echo "&#xf06a; Please enter a valid email address.";
          }
        }
        ?>
      </span>
      <input type="password" class="modal-form" placeholder="Password" name="password" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
      <span class="modal-error reg-err">
        <?php
        if(isset($_GET['regPw'])){
          if ($_GET['regPw']=="empty"){
            echo "&#xf06a; Please enter your password.";
          } else if ($_GET['regPw']=="lengthErr"){
            echo "&#xf06a; Please enter 8 or more characters.";
          }
        }
        ?>
      </span>
      <input type="password" class="modal-form" placeholder="Re-enter Password"  name="passwordConfirm" value="<?php echo (isset($_POST['passwordConfirm']) ? $_POST['passwordConfirm']:''); ?>">
      <span class="modal-error reg-err">
        <?php
        if(isset($_GET['regPwCfm'])){
          if ($_GET['regPwCfm']=="empty"){
            echo "&#xf06a; Please re-enter your password.";
          } else if ($_GET['regPwCfm']=="diff"){
            echo "&#xf06a; Please ensure your password entered is correct.";
          }
        }
        ?>
      </span>
      <button type="submit" class="modal-login-cfm button-red">Register</button>
    </form>
  </div>
</section>
