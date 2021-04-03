<?php 
include "db.php";


use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
	$mail_sent=false;
if(isset($_POST['submit'])){
	$name=$_POST['name'];
	$subject=$_POST['subject'];
	$email=$_POST['email'];
	$comments=$_POST['comments'];

	
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
            $mail->setFrom($email, $name);

            $mail->addAddress('trainingm08@gmail.com ', 'NotesMarketPlace');
            $mail->addReplyTo($email, $name);

            $mail->IsHTML(true);
            $mail->Subject = "$subject";
            $mail->Body = "Hello,
			<br><br>
                           Comment: <b>$comments</b>
				<br>Regards,
				<br>Sender Name: <b>$name</b><br>Sender Email: <b>$email</b>";
            $mail->AltBody = '';
            $mail->send();
            $mail_sent = true;
        } catch (Exception $e) {
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
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

<!--favicon>
<link rel="shortcut icon" href="images/images/favicon.ico">
	<!--open sans font-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
	<!--font-awesome-->
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<!--bootstrap-->
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.4.5.css">
	<!--css-->
	<link rel="stylesheet" href="css/style.css">
	<!--responsive css-->
	<link rel="stylesheet" href="css/responsive.css">
</head>

<body>
	<!--header-->
	<header>
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light nav-user-profile ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper ">
					<div class="navbar-header navbar-brand">
						<a href="home.html"><img src="images/images/logo.png"> </a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->

					<div class="collapse navbar-collapse">
						<ul class="navbar-nav nav pull-right ">
							<li class="nav-item"><a class="smooth-scroll nav-link" href="search-notes.php">Search Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="contactus.php">Contact Us</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" href="login1.php">
									<p>Login</p>
								</a></li>
						</ul>
					</div>


					<!--mobile menu-->
					<div id="mobile-nav">
						<div class="navbar-header">
							<a href="home.html"><img src="images/images/logo.png"></a>
							<!--mobile menu close button-->
							<span id="mobile-nav-close-btn">&times;</span>
						</div>

						<div id="mobile-nav-content">
							<ul class="navbar-nav">
								<li class="nav-item"><a class="smooth-scroll nav-link" href="search-notes.php">Search Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link active" href="contactus.php">Contact Us</a></li>
								<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" href="login1.php">
										<p>Login</p>
									</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>


	</header>

	<!--header ends-->
	<div class="logo img-responsive">
		<div id="user-logo">
			<h3 id="user-profile-logo">Contact Us</h3>
		</div>
	</div>

<div class="container ">
	<div class="row ">
	<div class="col-12">
		<div class="horizontal-heading contact-us">
		
			<h3> Get In Touch</h3>
		
			<h6>Let Us know How To Get Back To You</h6>
			<form id="basic-profile-form" method="post" action="contactus.php">
				<div class="form-group row">
			<div class="col-lg-6 col-md-6 col-12">
					
						<label id="fname" class="form-info" for="exampleInputName">Full Name *</label>
						<input type="name" class="form-control input-field" name="name" placeholder="Enter Your Full Name" value="<?php if(isset($_SESSION["useremail"]) ) {
	echo $_SESSION["fname"]." ".$_SESSION["lname"];
}?>" required>
					
						<label id="email" for="exampleInputEmail1 ">Email *</label>
						<input type="name" class="form-control input-field" aria-describedby="emailHelp" name="email" value="<?php if(isset($_SESSION["useremail"]) ) {
	echo $_SESSION["useremail"];}?>" <?php if(isset($_SESSION["useremail"])){?> disabled <?php }?> placeholder="Enter your email address disabled"  required>
					
						<label id="email" for="exampleInputEmail1 ">Subject *</label>
						<input type="name" class="form-control input-field"  name="subject" placeholder="Enter your subject" required>
					
				
					</div>
				
				<div class="col-lg-6 col-md-6 col-12">
					
						<label for="exampleInputName ">Comments *</label>
						<textarea class="form-control" id="exampleFormControlTextarea1" name="comments" rows="9" placeholder="Comments..."></textarea>
					</div></div>


	<div class="row no-gutters ">
	<div class="col-12">
			<button type="submit" id="user-submit" class="btn btn-primary" name="submit">Submit</button>
		</div>
	</div></form>
		</div></div></div>
	</div>

	<div class="footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-7 col-xs-7">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
				<div class="col-md-6 col-sm-5 col-xs-5 social-icons">
					<ul class="social-list">

						<li> <a href="#"><i class="fa fa-linkedin"> </i></a></li>
						<li> <a href="#"><i class="fa fa-twitter"> </i></a></li>
						<li> <a href="#"><i class="fa fa-facebook"> </i></a></li>

					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--jquery-->
	<script src="js/jquery.js"></script>
	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>

</body>

</html>