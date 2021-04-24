<?php 
include "db.php";

$login_failed = false;
$email_verified = true;
$correct_email=true;
$password_verified = true;

session_start();
if (isset($_POST['login-user'])) {
	if(!empty($_POST['email'])&& !empty($_POST['password'])){
	$email=$_POST['email'];
	$password=$_POST['password'];
		$p=md5($password);

		//email verfication checker
    $email_verification_checker = mysqli_query($connection, "SELECT IsEmailVerified FROM users WHERE EmailID='$email' AND IsEmailVerified=0");
    $email_count = mysqli_num_rows($email_verification_checker);

    if ($email_count == 1) {
        $email_verified = false;
    }
		
	//email verfication checker
    $password_checker= mysqli_query($connection, "SELECT Password FROM users WHERE Password='$p' AND EmailID='$email'");
    $password_count = mysqli_num_rows($password_checker);

    if ($password_count == 0) {
        $password_verified = false;
    }	
		
    //correct email
 $correct_email_checker = mysqli_query($connection, "SELECT EmailID FROM users WHERE EmailID='$email'");
    $email_count = mysqli_num_rows($correct_email_checker);

    if ($email_count == 0) {
        $correct_email = false;
    }

$query="SELECT * FROM users WHERE EmailID = '$email' AND Password='$p' AND IsEmailVerified='1'";
		$result=mysqli_query($connection, $query);
		
	if(!$result){
	die("query failed".mysqli_error($connection));
}
$numrows=mysqli_num_rows($result);
		
    if($numrows!=0)  
    { 	

	while($row =mysqli_fetch_array($result)) { 
	$db_email= $row['EmailID'];
	$db_password= $row['Password'];	
		$db_roleid=$row['RoleID'];
		$db_fname= $row['FirstName'];	
		$db_lname= $row['LastName'];
		$db_id=$row['ID'];
	}
	
	
if($email == $db_email && $p == $db_password){
	session_start();
	$_SESSION["useremail"]=$email;
	echo '<script type="text/javascript"> alert($_SESSION["useremail"])</script>';
	$_SESSION["fname"]=$db_fname;
	$_SESSION["lname"]=$db_lname;
	$_SESSION["roleid"]=$db_roleid;
	$_SESSION["user_id"]=$db_id;
	//$_SESSION["user_id"] = mysqli_insert_id($connection);
	if (isset($_POST['remember'])) {
            setcookie('email', $email, time() + 60 * 60 * 24 * 365);
            setcookie('password', $p, time() + 60 * 60 * 24 * 365);
        }
		$query="SELECT * FROM users_details WHERE UserID='$db_id' ";
		$result=mysqli_query($connection,$query);
		$exist=mysqli_num_rows($result);
		if(!$result){
			echo mysqli_error($connection);
		}
		echo $exist;
		if($exist==0){
			header("Location:user-profile.php");	
		}
		else{
	if($db_roleid=1)
	 header("Location:search-notes.php");
	elseif($db_roleid=2)
	 header("Location:admin/dashboard.php");
}
}
		
	
	else {
		$login_failed = true;
echo "invalid username or password";
	}}
	}else echo "all fields are required";
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
	<div id="login-bg">

		<section id="login">

			<div class="container">
				<div class="row text-center">
					<div class="col-md-12">
						<img class="main-logo img-responsive " src="images/images/top-logo.png">
					</div>
				</div>

				<div id="login-content">
					<div class="row">
						<div class="col-md-12">
							<div id="login-box">
								<h3> Login</h3>
								<h6 class="inline">Enter your email address and password to login</h6>
								<form id="login-form" method="post" action="login1.php">
									<div class="form-group">
										<label id="email" for="exampleInputEmail1">Email</label>
										<input type='email' class='form-control' id='exampleInputEmail1' aria-describedby='emailHelp' placeholder='abc@gmail.com' name='email'>

										<div class="correct-email">
											<?php
                                        if(!$correct_email)
                                            echo "Please Enter a Valid Email Address";
                                        ?>
										</div>
									</div>
									<div class="form-group" id="password-both">
										<label id="password" for="exampleInputPassword1">Password</label>
										<label id="forgot-password-login" for="forgot-Password1"><a href="forgot-password.php">Forgot Password?</a></label>
										<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password" name="password">
										<div class="eye"><img src="images/images/eye.png" alt="eye" onclick="Toggle()"></div>
									</div>
									<?php
                                        if(!$email_verified& $correct_email){
											echo "<h5 style='color: red';>verify your email first</h5>";
										}
                                        elseif(!$password_verified&$correct_email){
									echo "<h5 style='color: red';>The Password that youve entered is incorrect</h5>";
}?>
									<div class="form-group form-check">
										<input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
										<label id="remember" class="form-check-label" for="exampleCheck1">Remember Me</label>
									</div>
									<button type="login" name="login-user" class="btn btn-primary">Login</button>
								</form>
								<h5 id="not-account">
									Don't have an account?<span><a href="sign-up.php"> Sign Up </a> </span>
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