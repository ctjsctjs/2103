<?php  

// include database connection
include_once 'databaseconnection.php';

// declare variables to get the value from input
$passwordError = $passwordConError = "";

// set a boolean variable to check if the fields have errors and retrun true if no error was detected
$valid = True;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //=====================  password validation ==========================
	// if the password field is empty
	if (empty($_POST["password"])){
		$passwordError = "Please enter a new password.";
		$_POST["password"] = "";
		$valid = False;
	}
	// else if the password field is invalid
	else if ((strlen($_POST["password"]) < 8) || (!preg_match("/((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i",$_POST["password"])) || (strlen($_POST["password"]) > 16)){
		$passwordError = "You did not enter between 8 and 16 alphanumeric characters.";
		$_POST["password"] = "";
		$valid = False;
	}

    //=====================  password confirm validation ==========================
   // if the confiemed password field is empty
	if (empty($_POST["passwordConfirm"])){
		$passwordConError = "Please enter the confirmed new password.";
		$_POST["passwordConfirm"] = "";
		$valid = False;
	}
    // else if the confirmed password is not the same as the password entered above
	else if (!($_POST["passwordConfirm"] === $_POST["password"])){
		$passwordConError = "You did not enter the same password.";
		$_POST["passwordConfirm"] = "";
		$valid = False;
	}

	// if there are no errors in the sign up form, it will proceed to insert the user information into the database
	if($valid==True){

		$email = mysqli_real_escape_string($conn, $_POST['email']);
		echo $email;
		$passwordConfirm = mysqli_real_escape_string($conn, $_POST['passwordConfirm']);
		echo $passwordConfirm;

		// hash the password
		$hashedPassword = password_hash($passwordConfirm, PASSWORD_DEFAULT);

		$updateAccount = "UPDATE user SET password = '$hashedPassword' WHERE email='$email'";
		mysqli_query($conn, $updateAccount) or die(mysqli_connect_error());

		$_POST["password"] = '';
		$_POST['passwordConfirm'] = '';
		header("Location: index.php?message=passwordResetSuccess");
        }
    }	
?>