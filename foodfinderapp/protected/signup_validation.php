<?php

// include database connection
include_once 'databaseconnection.php';

// declare variables to get the value from input
$firstnameError = $lastnameError = $emailError = $passwordError = $passwordConError = "";

// set a boolean variable to check if the fields have errors and retrun true if no error was detected
$valid = True;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //=====================  first name validation ==========================
    // if the first name field is empty
	if (empty($_POST["firstName"])){
		$firstnameError = "Please enter your first name.";
		$_POST["firstName"] = "";
		$valid = False;
	}
    // else if the first name field contains numbers
	else if (!ctype_alpha($_POST["firstName"])){
		$firstnameError = "Please enter letters only.";
		$_POST["firstName"] = "";
		$valid = False;
	}

    //=====================  last name validation ==========================
	// if the last name field is empty
	if (empty($_POST["lastName"])){
		$lastnameError = "Please enter your last name.";
		$_POST["lastName"] = "";
		$valid = False;
	}
    // else if the last name field contains numbers
	else if (!ctype_alpha($_POST["lastName"])){
		$lastnameError = "Please enter letters only.";
		$_POST["lastName"] = "";
		$valid = False;
	}

    //=====================  email validation ==========================
	// if the email field is empty
	if (empty($_POST["email"])){
		$emailError = "Please enter a valid email address.";
		$_POST["email"] = "";
		$valid = False;
	}
    // else if the email field is invalid
	else if (!preg_match("/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i" ,$_POST["email"])){
		$emailError = "The email format is not valid. Please enter again.";
		$_POST["email"] = "";
		$valid = False;
	}
	// else if the email field is not empty check if the email is unique
	else if (!empty($_POST["email"])) {
		$checkUniqueEmail = "SELECT * FROM user";
		$result = mysqli_query($conn, $checkUniqueEmail) or die(mysqli_connect_error());
		for ($i = 0; $i < mysqli_num_rows($result); $i++) {
			$row = mysqli_fetch_array($result);
			if (strtoupper($row['email']) == strtoupper($_POST["email"])) {
				$emailError = "This email has been registered before.";
				$_POST["email"] = "";
				$valid = False;
			}
		}
	}

    //=====================  password validation ==========================
	// if the password field is empty
	if (empty($_POST["password"])){
		$passwordError = "Please enter a password.";
		$_POST["password"] = "";
		$valid = False;
	}
	// else if the password field is invalid
	else if ((strlen($_POST["password"]) < 8) || (!preg_match("/((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i",$_POST["password"])) || (strlen($_POST["password"]) > 16)){
		$passwordError = "You did not enter between 8-16 alphanumeric characters.";
		$_POST["password"] = "";
		$valid = False;
	}

    //=====================  password confirm validation ==========================
   // if the confiemed password field is empty
	if (empty($_POST["passwordConfirm"])){
		$passwordConError = "Please enter the confirmed password.";
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

		$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
		$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$passwordConfirm = mysqli_real_escape_string($conn, $_POST['passwordConfirm']);

        // hash the password
		$hashedPassword = password_hash($passwordConfirm, PASSWORD_DEFAULT);


		$insertUser = "INSERT INTO user(firstName, lastName, email, password)VALUES('$firstName', '$lastName ', '$email', '$hashedPassword')";

		mysqli_query($conn, $insertUser) or die(mysqli_connect_error());
		$_POST['firstName'] = '';
		$_POST['lastName'] = '';
		$_POST['email'] = '';
		$_POST["password"] = '';
		$_POST['passwordConfirm'] = '';
		header("Location: ../index.php?message=success");

        } else {
					header("Location: ../index.php?message=fail");
				}
    }
?>
