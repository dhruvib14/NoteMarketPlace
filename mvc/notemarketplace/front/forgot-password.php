<?php
include "db.php";
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
$password = substr( str_shuffle( $chars ), 0, 8 );
echo $password;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if(isset($_POST['submit'])){
	$email=$_POST['email'];
if(!empty($_POST['email'])){
	$query="SELECT * FROM users WHERE EmailID='$email'";
    $result=mysqli_query($connection, $query);
	if(mysqli_num_rows($result)>0){
		
		$p=md5($password);
	
	//mail function
        require 'PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $config_email = 'trainingm08@gmail.com ';
            $mail->Username = $config_email;
            $mail->Password = 'abc@08(mail)';

            // Sender and recipient settings
            $mail->setFrom($config_email, 'NotesMarketPlace');

            $mail->addAddress($email);
            $mail->addReplyTo($config_email, 'NotesMarketPlace');

            $mail->IsHTML(true);
            $mail->Subject = "Email verification";
            

            $mail->Body = "Hello <br>
 <br>
           We have generated a new password for you .<br> 
 <br>
         Password:$password <br> 
<br>
           Regards,  <br>Notes Marketplace ";

            $mail->AltBody = '';

            $mail->send();
            $mail_sent = true;
			if($mail_sent=true){
				echo '<script type="text/javascript"> alert("Your password has been changed successfully and newly generated password is sent on your registered email address")</script>';
					$query="UPDATE users SET Password='$p' WHERE EmailId='$email'";
				$result=mysqli_query($connection, $query);
		if($result){
			echo '<script type="text/javascript"> alert("updated")</script>';
			 header("Location:login1.php");
			
		}
				else echo"none";
			}
			
			
        } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        } }
    }
}

?>



<!DOCTYPE html>
<html lang="en">


<head>

	<!--meta-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">

	<title>Notes Marketplace </title>

	<!--open sans font-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<!--font-awesome-->
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<!--bootstrap-->
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.4.5.css">
	<!--css-->
	<link rel="stylesheet" href="css/style.css">
	<!--reponsive css-->
	<link rel="stylesheet" href="css/responsive.css">
</head>


<body>
	<!--forgot-password page-->
	<div id="forgot-bg">
		<section id="forgot-password">
			<div id="forgot-password-div">
				<div class="container">
					<div class="row text-center">
						<div class="col-md-12">
							<img class="main-logo img-responsive " src="images/images/top-logo.png">

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div id="forgot-password-content" class=" content-box-md centered">
								<h3> Forgot Password?</h3>
								<h6>Enter your email to reset your password</h6>
								<form class="centered" action="forgot-password.php" method="post">
									<div class="form-group">
										<label id="email" for="exampleInputEmail1">Email</label>
										<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="abc@gmail.com">

									</div>

									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<!--jquery-->
	<script src="js/jquery.js"></script>
	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>


</html>