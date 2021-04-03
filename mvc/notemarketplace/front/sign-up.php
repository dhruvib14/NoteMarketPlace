<?php 
include "db.php";
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
	$mail_sent=false;
$name_pattern = '/^[a-zA-Z ]{3,49}$/';
$fname_check = true;
$lname_check = true;
$mail_exist=false;
$mail_check = true;


//boolean for proper Password validation 
$upper_psd_check = true;
$lower_psd_check = true;
$number_psd_check = true;
$length_check = true;
$password_match = true;

//define variable for NOT NULL 
$fname = "checked";
$lname = "checked";
session_start();
if(isset($_POST['signup'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$spassword=$_POST['spassword'];
	$scpassword=$_POST['scpassword'];
    $createddate=date("y-m-d H-i-s");
 $modifieddate=date("y-m-d H-i-s");
$p=md5($spassword);
$cp=md5($scpassword);
	
	$check_fname = preg_match($name_pattern, $fname);
    if (!$check_fname) {
        $fname_check = false;
    }

    $check_lname = preg_match($name_pattern, $lname);
    if (!$check_lname) {
        $lname_check = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail_check = false;
    }

    $upper_psd = preg_match('@[A-Z]@', $spassword);
    if (!$upper_psd)
        $upper_psd_check = false;

    $lower_psd = preg_match('@[a-z]@', $spassword);
    if (!$lower_psd)
        $lower_psd_check = false;

    $number_check = preg_match('@[0-9]@', $spassword);
    if (!$number_check)
        $number_psd_check = false;


    if ($spassword != $scpassword) {
        $password_match = false;
    }
    if (strlen($spassword) < 6) {
        $length_check = false;
    }
if($password_match && $length_check && $lname_check && $fname_check && $mail_check && $upper_psd_check && $lower_psd_check && $number_psd_check)
{
	$query="SELECT * FROM users WHERE EmailID='$email'";
	$email_count=mysqli_query($connection, $query);
	if(mysqli_num_rows($email_count)>0){
		$mail_exist=true;
		//header("Location:login1.php");
	}
	else{
		$query="INSERT INTO users (RoleID,FirstName, LastName, EmailID, Password,CreatedDate,ModifiedDate) VALUES (1,'$fname','$lname','$email','$p','$createddate','$modifieddate')";
		if(mysqli_query($connection, $query)){
	    echo '<script type="text/javascript"> alert("successfully")</script>';
			$query="SELECT * FROM users WHERE EmailID='$email'";
				$result=mysqli_query($connection, $query);
			$email_count=mysqli_num_rows($result);
			while($row =mysqli_fetch_array($result)) { 
			$id=$row['ID'];
				$username=$row['FirstName'];
				$_SESSION['email']=$row['EmailID'];
				$_SESSION["username"]=$row['FirstName'];
					$_SESSION['id']=$row['ID'];
				$user=$_SESSION["username"];
				
				echo $_SESSION["roleid"];
				
			}
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
            $mail->AddEmbeddedImage('images/images/logo.png', 'logo');

            $mail->Body = "Hello $fname,<br>
 <br>
            Thank you for signing up with us. Please click on below link to verify your email address and to do login.<br> 
 <br>
           <a href='http://localhost/notemarketplace/front/email-verification.php'>email verification</a> <br> 
<br>
           Regards,  Notes Marketplace ";

            $mail->AltBody = '';

            $mail->send();
            $mail_sent = true;
        } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        } 
    }
		
    
		else{
			echo '<script type="text/javascript"> alert("successfully not")</script>';
		}
			
		}
		}
	
	else{
			echo '<script type="text/javascript"> alert("please submit the valid details.mysqli_error")</script>';
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
<!-- Favicon -->
	<link rel="shortcut icon" href="images/images/favicon.ico">
	<!--open sans font-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<!--font-awesome-->
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<!--bootstrap-->
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.4.5.css">
	<!--css-->
	<link rel="stylesheet" href="css/style.css">
	<!--responsive-->
	<link rel="stylesheet" href="css/responsive.css">
</head>


<body>

	<!--login page-->
	<div id="signup-bg">

		<section id="signup">

			<div class="container">
				<div class="row text-center">
					<div class="col-md-12">
						<div class="main-logo">
							<img class="main-logo img-responsive " src="images/images/top-logo.png">
						</div>
					</div>
				</div>

				<div id="signup-content">
					<div class="row">
						<div class="col-md-12">
							<div id="signup-box">
								<h3> Create an account</h3>
								<h6>Enter your details to signup</h6>

							
							<?php
								if($mail_sent){
									echo " 	<h5 class='created-green text-center' style='color:green; padding-bottom:20px;'> Your account has been successfully created.</h5>";}
	?>							
								
								<form id="signup-form" method="post" action="sign-up.php">
									<div class="form-group">
										<label id="fname" for="exampleInputName">First Name *</label>
										<input type="name" class="form-control input-field" aria-describedby="emailHelp" placeholder="Your First Name"  name="fname" required>
										<?php
                                        if (strlen($fname) == 0)
                                            echo "Please enter your first name";
                                        else  if (!$fname_check)
                                            echo "First name should be more than 3 characters!";
                                        ?>

									</div>
									<div class="form-group">
										<label id="lname" for="exampleInputName ">Last Name *</label>
										<input type="name" class="form-control input-field" placeholder="Your Last Name" name="lname" required>
										<?php
                                        if (strlen($lname) == 0)
                                            echo "Please enter your last name";
                                        else if (!$lname_check)
                                            echo "Last name should be more than 3 characters!";
                                        ?>

									</div>
									<div class="form-group">
										<label id="email" for="exampleInputEmail1 ">Email *</label>
										<input type="email" class="form-control input-field" aria-describedby="emailHelp" placeholder="abc@gmail.com" name="email" required>
										<?php
                                        if ($mail_exist)
                                            echo "Email address already exists!";
                                        else if (!$mail_check)
                                            echo "Please enter Valid Email address";
                                        ?>

									</div>
									<div class="form-group">
										<label id="password" for="exampleInputPassword1">Password *</label>

										<input type="password" class="form-control input-field" name="spassword" id="spassword" placeholder="Enter your password" required>
										<div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle4()"></div>
										<?php
                                        if (!$length_check)
                                            echo "The Password Length Should be more than 6 characters";
                                        else if (!$upper_psd_check)
                                            echo "Please enter at least one uppercase letter";
                                        else if (!$lower_psd_check)
                                            echo "Please enter at least one lowercase letter";
                                        else if (!$number_psd_check)
                                            echo "Please enter at least one numeric letter";
                                        ?>
									</div>
									<div class="form-group">
										<label id="confirmpassword password" for="exampleInputPassword2">Confirm Password *</label>

										<input type="password" class="form-control input-field" id="scpassword" name="scpassword" placeholder="confirm your password" required onClick="validatePassword()">
										<div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle5()"></div>
										<?php
                                        if (!$password_match )
                                            echo "The Password and Confirm Password doesn't match!";
                                        ?>
									</div>

									<button type="login" class="btn btn-primary" name="signup">sign up</button>
								</form>
								<h5 id="have-account">
									Already have an account? <span><a href="login1.php">Login </a> </span>
								</h5>

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