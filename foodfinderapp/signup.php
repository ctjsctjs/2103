<?php include_once 'includes/header.php' ?>
<?php include_once 'includes/nav_login_signup.php' ?>
<?php include_once 'protected/signup_validation.php' ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <span class="anchor"></span>
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0 text-center">Sign Up</h3>
                        </div>
                        <div class="card-body">
                            <form class="signup-form" role="form" autocomplete="off" action="signup.php" method="POST">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="firstName" value="<?php echo (isset($_POST['firstName']) ? $_POST['firstName']:''); ?>">
                                    <span class="text-danger"><?php echo $firstnameError ?></span>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="lastName" value="<?php echo (isset($_POST['lastName']) ? $_POST['lastName']:''); ?>">
                                    <span class="text-danger"><?php echo $lastnameError ?></span>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="email"  value="<?php echo (isset($_POST['email']) ? $_POST['email']:''); ?>">
                                    <span class="text-danger"><?php echo $emailError ?></span>
                                </div>
                                <div class="form-group">
                                    <label>Password (Please enter between 8-16 alphanumeric characters)</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="password""" value="<?php echo (isset($_POST['password']) ? $_POST['password']:''); ?>">
                                    <span class="text-danger"><?php echo $passwordError ?></span>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="passwordConfirm"  value="<?php echo (isset($_POST['passwordConfirm']) ? $_POST['passwordConfirm']:''); ?>">
                                    <span class="text-danger"><?php echo $passwordConError ?></span>
                                </div>
                                <a class="btn btn-outline-dark my-2 my-sm-0 float-left" name="backbtn"  href="./index.php">Back</a>
								<button type="submit" class="btn btn-outline-dark my-2 my-sm-0 float-right">Submit</button> 
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

<?php include_once 'includes/footer_main.php' ?>