<?php include_once 'includes/header.php' ?>
<?php include_once 'includes/nav_userVerification.php' ?>

<?php include_once 'protected/databaseconnection.php' ?>

<?php
	error_reporting(E_ERROR | E_PARSE);


	if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
		// Verify data
		$email = $_GET['email']; // Set email variable
		$hash = $_GET['hash']; // Set hash variable

		$search = "SELECT * FROM user WHERE email= '$email' AND hash= '$hash' AND accountActivated='0'";
		$result = mysqli_query($conn, $search) or die(mysqli_connect_error());
		$match = mysqli_num_rows($result);
		
		if ($match == 1) {
		// We have a match, activate the account
		$updateAccount = "UPDATE user SET accountActivated = 1 WHERE email='$email' AND hash='$hash' AND accountActivated='0'";
		mysqli_query($conn, $updateAccount) or die(mysqli_connect_error());
		echo "<p align='center'>Your account has been activated, you can now login.</p>";
		} 
		else {
			// No match -> invalid url or account has already been activated.
			echo "<p align='center'>The url is either invalid or you already have activated your account.</p>";
		}
	} 
	else {
	    // Invalid approach
	    echo "<p align='center'>Invalid approach, please use the link that has been sent to your email.</p>";
	}	
?>


<?php include_once 'includes/footer_login_signup.php' ?>