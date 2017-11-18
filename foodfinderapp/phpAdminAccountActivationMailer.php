<?php
error_reporting(E_ALL);
require("PHPMailer_5.2.4/class.phpmailer.php");

$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->SMTPDebug  = 0;
//$mail->Debugoutput = 'html';
//$mail->From = "quizgroup24@gmail.com";
$mail->FromName = "Food Finder App";
$mail->Host = "smtp.gmail.com"; // specif smtp server
$mail->SMTPSecure= "ssl"; // Used instead of TLS when only POP mail is selected
$mail->Port = 465; // 465 Used instead of 587 when only POP mail is selected
$mail->SMTPAuth = true;

//$mail->Username = "";
//$mail->Password = ""; // SMTP password
$mail->Username = "jeremyteh8@gmail.com"; // SMTP username
$mail->Password = "jtys#2804"; // SMTP password
$mail->setFrom("jeremyteh8@gmail.com");  //add sender email address.
$mail->AddAddress("$email"); 
$mail->WordWrap = 50; // set word wrap



$mail->IsHTML(true); // set email format to HTML
$mail->Subject = 'Food Finder App Email Verification';

        
$message = 'Dear '.$firstName.',<br><br>
        
Thank you for signing up as a vendor with Foodpark!<br><br>

Before you can gain full access to your vendor account in Foodpark Portal, you are required to prepare the following documents to send to us! <br>
As much as we would like to work with you to giver consumers a better experience, we would also want to ensure the authenticity of you as a vendor. <br><br>

You are required to send us your: <br><br>

	1. Business Registration document <br>
	2. NRIC and/or relevant documents to identify you as the owner of the business <br>
	3. ACRA Business Tax Registration Information <br><br>

Please reply to this email with the following information. <br><br>

Verification of this information will take 3-5 working days. <br><br>

Once verified, you may login with the following credentials.<br><br>

-------------------------<br>
Email: '.$email.'<br>
Password: '.$passwordConfirm.'<br>
-------------------------<br><br>

Please click this link to login to your account once an verification email has been sent to you:<br>
http://localhost/foodfinderapp/login.php<br><br>

';

$mail->Body = $message;

if($mail->Send()) {echo " ";}
else {echo "";}
?>