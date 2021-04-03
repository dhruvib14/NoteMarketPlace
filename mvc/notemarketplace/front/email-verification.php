<?php 
include "db.php";
session_start();
echo $_SESSION["id"];
$id=$_SESSION["id"];
	if(isset($_POST['submit']))
	{
	$query="UPDATE users SET IsEmailVerified=1 WHERE ID=$id";
				$result=mysqli_query($connection, $query);
		if($result){
			header("Location:user-profile.php");
			
		}
		else
			echo '<script type="text/javascript"> alert("not updated")</script>';
			
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
	<!--responsive css-->
	<link rel="stylesheet" href="css/responsive.css">
</head>

<body>
	<div id="email-background">
		<section id="email-verification">
			<div class="container">
				<div class="row">
					<div class="row" id="email-content">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<img src="images/images/logo.png">
						</div>
						<form action="email-verification.php" method="post">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<h3 id="email-heading">Email Verification</h3>
							</div>
							<div class="row">
								<h5> Dear  <?php
								
									echo $_SESSION["username"];
									?>
									</h5>
							</div>
							<div class="row">
								<p>Thank for Signing Up</p>
							</div>
							<div class="row">
								<p>Simply click below for email verification.</p>
							</div>
						</div>
						<button type="submit" id="email-verify" class="btn btn-primary" name="submit">Verify Email Address</button></form>
					</div>
				</div>
			</div>
		</section>
	</div>
</body>

</html>