<?php
include "../front/db.php";
session_start();
$name_pattern = '/^[a-zA-Z ]{3,49}$/';
$phone_number_pattern='/^[0-9]{10,20}$/';
$email_exist=false;
$fname_check=true;
$lname_check=true;
$phone_number_check=true;
if(isset($_SESSION['useremail'])){
	$email=$_SESSION['useremail'];
	
$query_id=mysqli_query($connection,"SELECT FIrstName,LastName,ID FROM users WHERE EmailID= '$email'");
if(!$query_id){
	echo mysqli_error($connection);
}
while($row=mysqli_fetch_assoc($query_id)){
$fname=$row['FIrstName'];
$lname=$row['LastName'];
$userID=$row['ID'];
}

$query=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID=$userID");
	while($row=mysqli_fetch_array($query)){
		$profile_pic=$row['Profile_Pic'];
	}

//for adding in a database


if(isset($_POST['submit'])){

	$fname=$_POST['edit-fname'];
	$lname=$_POST['edit-lname'];
	$semail=$_POST['edit-semail'];

	$country_id=$_POST['country_code'];	
	$phone_number=$_POST['phone_number'];
    $password="Admin@123";
	$p=md5($password); 

/*	$query="SELECT Profile_Pic FROM users_details WHERE UserID=$userID";
	$result=mysqli_query($connection,$query);
*/


	$default_display_pic = "../members/default/reviewer1.png";
	$check_fname = preg_match($name_pattern, $fname);
    if (!$check_fname) {
        $fname_check = false;
    }

    $check_lname = preg_match($name_pattern, $lname);
    if (!$check_lname) {
        $lname_check = false;
    }

	$check_phone=preg_match($phone_number_pattern,$phone_number);
	if(!$check_phone){
		$phone_number_check=false;
	}
$query_email_exist=mysqli_query($connection,"SELECT * FROM users LEFT JOIN users_details ON users_details.UserID=users.ID  WHERE users.EmailID='$semail' OR users_details.Secondary_Email='$email' ");
if(!$query_email_exist){
	echo mysqli_error($connection);
}
$count_email=mysqli_num_rows($query_email_exist);
		if($count_email>0){
	$email_exist=true;}
if($fname_check&&$lname_check&&$phone_number_check&&!$email_exist){
$query_update=mysqli_query($connection,"UPDATE users LEFT JOIN users_details ON users_details.UserID=users.ID SET users.FirstName='$fname',users.LastName='$lname',users_details.Secondary_Email='$semail',Profile_Pic='$default_display_pic',users_details.Phone_No='$phone_number',users_details.Phone_No_Country_Code='$country_id' WHERE users.ID=$userID");
if(!$query_update){
	echo mysqli_error($connection);
}

$profile_pic=$_FILES["upload-profile"];
$filename=$profile_pic['name'];
$filetmp=$profile_pic['tmp_name'];
$extension=explode('.',$filename);
$filecheck=strtolower(end($extension));
$fileextstored=array('jpg','png','jpeg');

	if (in_array($filecheck, $fileextstored)) {
		if (!is_dir("../members/")) {
			mkdir('../members/');
		}
		if (!is_dir("../members/" . $userID)) {
			mkdir("../members/" . $userID);
		}
		
		$destinationfile = '../members/' . $userID .'/' . "DP_" . time() . '.' . $filecheck;
		move_uploaded_file($filetmp, $destinationfile);
		$query_pic = "UPDATE users_details SET Profile_Pic='$destinationfile' WHERE UserID=$userID";
		$result_pic = mysqli_query($connection, $query_pic);
	} else {
		echo "upload failed".mysqli_error($connection);
		$profile_validation=false;
	}
}
}
}
else{
	header("Location:../front/login1.php");
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


    	<!--header-->
		<header>
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light  ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper">
					<div class="navbar-header navbar-brand">
						<a href="admin-dashboard.php"><img src="images/images/logo.png"></a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->

					<div class="collapse navbar-collapse">
						<ul class="navbar-nav pull-right ">
							<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-dashboard.php">Dashboard</a></li>

							<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
									<a class="dropdown-item " href="admin-published-notes.php">Published Notes</a>
									<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
									<a class="dropdown-item " href="admin-rejected-notes.php">Rejected Notes</a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="admin-members.php">Members</a></li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item active" href="admin-spamreports.php">Spam Reports</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
									<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
									<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

									<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
									<a class="dropdown-item " href="admin-manage-country.php">Manage Countries</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
							<?php echo "<img src='$profile_pic'>";?></a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item active" href="admin-myprofile.php">Update Profile</a>
									<a class="dropdown-item" href="../front/change-password.php">Change Password</a>
									<a class="dropdown-item dd-logout" onclick='javascript:logout($(this));return false;' href="../front/logout.php"><p>Logout</p></a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" onclick='javascript:logout($(this));return false;' id="button-nav" href="../front/logout.php">
									<p>Logout</p>
								</a></li>
						</ul>
					</div>
					<!--mobile menu-->
					<div id="mobile-nav">
						<div class="navbar-header">
							<img src="images/images/logo.png">
							<!--mobile menu close button-->
							<span id="mobile-nav-close-btn">&times;</span>
						</div>

						<div id="mobile-nav-content">
							<ul class="navbar-nav  ">
								<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-dashboard.php">Dashboard</a></li>

								<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notes</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-notes-under-review.php">Notes Under Review</a>
										<a class="dropdown-item " href="admin-published-notes.php">Published Notes</a>
										<a class="dropdown-item" href="admin-downloaded-notes.php">Downloaded Notes</a>
										<a class="dropdown-item " href="admin-rejected-notes.php">Rejected Notes</a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll nav-link " href="admin-members.php">Members</a></li>
								
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item " href="admin-spamreports.php">Spam Reports</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
										<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
										<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

										<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
										<a class="dropdown-item " href="admin-manage-country.php">Manage Countries</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								
							<?php echo "<img src='$profile_pic'>";?></a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item active" href="admin-myprofile.php">Update Profile</a>
										<a class="dropdown-item" href="../front/change-password.php">Change Password</a>
										<a class="dropdown-item dd-logout" onclick='javascript:logout($(this));return false;' href="../front/logout.php"><p>Logout</p></a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll nav-link" onclick='javascript:logout($(this));return false;' id="button-nav" href="../front/logout.php">
										<p>Logout</p>
									</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>


	</header>


	<section id="user-profile" class="admin-myprofie">

		<div class="row">
			<div class="container">
				<h3> My Profile</h3>
				<form id="basic-profile-form" method="post" action="" enctype="multipart/form-data">
					<div class="form-group row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<label id="fname" class="form-info" for="exampleInputName">First Name *</label>
							<input type="name" name="edit-fname" class="form-control input-field"  value="<?php echo $fname?>" placeholder="Your First Name" required>
							<?php
						if(!$fname_check){
							echo "Please enter a valid alphabatic name";
						}
						?></div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<label id="lname" for="exampleInputName ">Last Name *</label>
							<input type="name" class="form-control input-field" name="edit-lname" placeholder="Your Last Name" value="<?php echo $lname?>" required>
							<?php
						if(!$lname_check){
							echo "Please enter a valid alphabatic name";
						}
						?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<label id="email" for="exampleInputEmail1 ">Email *</label>
							<input type="email" class="form-control input-field" disabled aria-describedby="emailHelp" value="<?php echo $email?>" read-only placeholder="abc@gmail.com" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<label id="email" for="exampleInputEmail1 ">Secondary Email</label>
							<input type="email" class="form-control input-field" name="edit-semail" aria-describedby="emailHelp" placeholder="enter your email address" required>
							<?php 
						if($email_exist){
							echo "<h6>User Already Exist</h6>";
						}
						?>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<label for="phone-number">Phone Number </label>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4">
									<select class="form-control options-arrow-down" required name="country_code">
										<?php
										
									$query = "SELECT Country_Code,ID FROM country";
									$result = mysqli_query($connection, $query);
									echo "<option value='' selected disabled>Select your country code</option>";

									while ($raw = mysqli_fetch_assoc($result)) {
										$country_id = $raw['ID'];
										$code = $raw['Country_Code'];
										echo "<option value='$country_id'>$code</option>";}?>
									</select>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-8 col-8">
									<input type="text" class="form-control input-field" name="phone_number" id="phone-number" placeholder="Enter Your Phone Number">
									<?php
						if(!$phone_number_check){
							echo "Please enter a valid digit between 10 to 20 ";
						}
						?>	
							</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<label for="profile">Profile Picture </label>
							<div class="user-profile-photo-uploader">
								<label for="image-uploader"><img src="images/images/upload-file.png" alt="upload your profile picture"></label>
								<input type="file" id="image-uploader" class=" form-control"  name="upload-profile" placeholder="Upload a Picture">
							</div>
						</div>
					</div>
				
				<div class="row">
					<div class="container">
						<button type="submit" id="user-submit" class="btn btn-primary" name="submit">Submit</button>
					</div>
				</div></form>
			</div>
		</div>
	</section>

	<div class="admin-footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-4 col-xs-3 col-3">
					vesion 1.1.24
				</div>
				<div class="col-md-6 col-sm-8 col-xs-9 col-9 text-right">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
			</div>
		</div>
	</div>

	<!--jquery-->
	<script src="js/jquery.js"></script>
	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>