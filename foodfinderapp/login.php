<?php include_once 'includes/header.php' ?>
<?php include_once 'protected/login_validation.php' ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <span class="anchor"></span>
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0 text-center">Login</h3>
                        </div>
                        <div class="card-body">
                            <form class="form" role="form" autocomplete="off" action="login.php" method="POST">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
                                    <span class="text-danger"><?php echo $emailError ?></span>
                                    <span class="float-right"><a href="#">Forget Password?</a></span>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="password" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
                                    <span class="text-danger"><?php echo $passwordError ?></span>
                                </div>

                                <a class="btn btn-outline-dark my-2 my-sm-0 float-left" name="signupbtn"  href="./signup.php">Sign Up a New Account!</a>
								<button type="submit" class="btn btn-outline-dark my-2 my-sm-0 float-right">Login</button> 
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->

<?php include_once 'includes/footer_login_signup.php' ?>