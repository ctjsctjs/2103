<?php  

// include database connection
include_once 'databaseconnection.php';

// declare variables to get the value from input
$emailError = $passwordError = "";

// set a boolean variable to check if the fields have errors and retrun true if no error was detected
$valid = True;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	//=====================  email validation ==========================
	// if the email field is empty
    if (empty($_POST["email"])){
        $emailError = "Please enter your email.";
        $_POST['email'] = "";
        $valid = False;
    }

    //=====================  password validation ==========================
    // if the password field is empty
    if (empty($_POST["password"])){
        $passwordError = "Please enter your password.";
        $_POST['password'] = "";
        $valid = False;
    }

    if($valid == True){

        $email = mysqli_real_escape_string($conn, $_POST['email']);
       	$password = mysqli_real_escape_string($conn, $_POST['password']);

       	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $selectUser = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $selectUser) or die(mysqli_connect_error());
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck < 1) {
        	echo '<script language="javascript">';
			echo 'alert("Login Failed! PLease try again.")';
			echo '</script>';
			$_POST['email'] = "";
			$_POST['password'] = "";
        }

        else {

        	if($row = mysqli_fetch_array($result)) {

        		$hashedPwdCheck = password_verify($password, $row['password']);
        		if($hashedPwdCheck == false) {
		        	echo '<script language="javascript">';
					echo 'alert("Login Failed! PLease try again.")';
					echo '</script>';
					$_POST['email'] = "";
					$_POST['password'] = "";
        		}
        		else if($hashedPwdCheck == true) {
        			session_start();
            		$_SESSION['FIRSTNAME'] = $row['firstName'];
		            $_SESSION['LASTNAME'] = $row['lastName'];
		            $_SESSION['EMAIL'] = $row['email'];
		            $_SESSION['PASSWORD'] = $row['password'];
		            $_SESSION['ID'] = $row['userid'];
		            
		            header('Location: index.php');

        		}
        	}
        }
    }
}