<?php
include "../front/db.php";
session_start();
$phone_number_check=true;
$phone_number_pattern='/^[0-9]{10,15}$/';
if(isset($_SESSION['useremail'])){
	$email=$_SESSION['useremail'];
	$query="SELECT ID FROM users WHERE EmailID='$email'";
	$result=mysqli_query($connection,$query);
	if(!$result){
		echo mysqli_error($connection);
	}
	while($row=mysqli_fetch_array($result)){
		$admin_id=$row['ID'];
	}
	$query=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID=$admin_id");
	
	while($row=mysqli_fetch_array($query)){
		$profile_pic=$row['Profile_Pic'];
	}
}
else{
	header("Location:../front/login1.php");
}

if(isset($_POST['submit'])){
	$support_email=$_POST['support_email'];
	$support_contact=$_POST['support_number'];
	$contact_email=$_POST['event_email'];
	$facebook_url=$_POST['facebook'];
	$twitter_url=$_POST['twitter'];
	$linkedln_url=$_POST['linkedln'];
    $default_img_book=$_FILES['default-notes'];

	$query_support=mysqli_query($connection,"INSERT INTO system_configuration(Key_Info,Value,CreatedDate,CreatedBy) VALUES ('SupportEmailAddress','$support_email',NOW(),94 )");
	if(!$query_support){
		echo mysqli_error($connection);
	}
	
	$check_phone=preg_match($phone_number_pattern,$phone_number);
	if(!$check_phone){
		$phone_number_check=false;
	}
	if($phone_number_check){
	$query_contact=mysqli_query($connection,"INSERT INTO system_configuration(Key_Info,Value,CreatedDate,CreatedBy) VALUES ('SupportContact Number',$support_contact,NOW(),94)");
	}$query_notify=mysqli_query($connection,"INSERT INTO system_configuration(Key_Info,Value,CreatedDate,CreatedBy) VALUES ('EmailAddresssesForNotify','$contact_email',NOW(),94)");
	$query_facebook=mysqli_query($connection,"INSERT INTO system_configuration(Key_Info,Value,CreatedDate,CreatedBy) VALUES ('FBICON','$facebook_url',NOW(),94)");
	$query_twitter=mysqli_query($connection,"INSERT INTO system_configuration(Key_Info,Value,CreatedDate,CreatedBy) VALUES ('TwitterICON','$twitter_url',NOW(),94)");
	$query_linkedln=mysqli_query($connection,"INSERT INTO system_configuration(Key_Info,Value,CreatedDate,CreatedBy) VALUES ('LNICON','$linkedln_url',NOW(),94)");

	$profile_pic=$_FILES["default-profile"];	
    $filename=$profile_pic['name'];
    $filetmp=$profile_pic['tmp_name'];
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('jpg','png','jpeg');
	

	if (in_array($filecheck, $fileextstored)) {
        if (!is_dir("../members/")) {
            mkdir('../members/');
            }
           
            if (!is_dir("../members/"."default" )) {
                mkdir('../members/' .'default');
            }
            $destinationfile = '../members/default/' . "DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "INSERT INTO system_configuration(Key_Info,Value,CreatedDate,CreatedBy) VALUES ('DefaultMemberDisplayPicture','$destinationfile',NOW(),94)";
            $result_pic = mysqli_query($connection, $query_pic);
        }
		
	//notes upload
    $filename=$default_img_book['name'];
    $filetmp=$default_img_book['tmp_name'];
	$extension=explode('.',$filename);
	$filecheck=strtolower(end($extension));
	$fileextstored=array('jpg','png','jpeg');
	

	if (in_array($filecheck, $fileextstored)) {
        if (!is_dir("../members/")) {
            mkdir('../members/');
        }
           
            if (!is_dir("../members/"."default" )) {
                mkdir('../members/' .'default');
            }
            $destinationfile = '../members/default/' . "note_DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "INSERT INTO system_configuration(Key_Info,Value,CreatedDate,CreatedBy) VALUES ('DefaultNotesDisplayPicture','$destinationfile',NOW(),94)";
            $result_pic = mysqli_query($connection, $query_pic);
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
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-spamreports.php">Spam Reports</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item active" href="admin-manage-system.php">Manage System Configuration</a>
									<a class="dropdown-item" href="admin-manage-administration.php">Manage Administration</a>
									<a class="dropdown-item" href="admin-manage-category.php">Manage Category</a>

									<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
									<a class="dropdown-item" href="admin-manage-country.php">Manage Countries</a>
								</div>
							</li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							
							<?php echo "<img src='$profile_pic'>";?></a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="admin-myprofile.php">Update Profile</a>
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
								
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reports</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-spamreports.php">Spam Reports</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link active" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item active" href="admin-manage-system.php">Manage System Configuration</a>
										<a class="dropdown-item" href="admin-manage-administration.php">Manage Administration</a>
										<a class="dropdown-item" href="admin-manage-category.php">Manage Category</a>

										<a class="dropdown-item" href="admin-manage-type.php">Manage Type</a>
										<a class="dropdown-item" href="admin-manage-country.php">Manage Countries</a>
									</div>
								</li>
								<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								
							<?php echo "<img src='$profile_pic'>";?></a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="admin-myprofile.php">Update Profile</a>
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
				<h3> Manage System Configuration</h3>
				<form id="basic-profile-form" action="" method="post" enctype="multipart/form-data">
					<div class="form-group row">
						<div class="col-md-8 col-lg-6 col-12">
							<label id="fname" class="form-info" for="exampleInputName">Support email address*</label>
							<input type="email" class="form-control input-field" value="john" name="support_email" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8 col-lg-6 col-12">
							<label id="lname" for="exampleInputName ">Support phone number *</label>
							<input type="name" class="form-control input-field"  name="support_number" placeholder="Enter Phone Number" required>
<?php if(!$phone_number_check) echo "please enter a numeric value between 10 to 15";?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8 col-lg-6 col-12">
							<label id="email" for="exampleInputEmail1 " class="inline-block">Email Address(es) (for various events system will send notifications to these users)*</label>
							<input type="email" class="form-control input-field" aria-describedby="emailHelp"  name="event_email" placeholder="enter email address" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8 col-lg-6 col-12">
							<label id="email" for="exampleInputEmail1 ">Facebook URL</label>
							<input type="name" class="form-control input-field" aria-describedby="emailHelp" name="facebook" placeholder="enter facebook url">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8 col-lg-6 col-12">
							<label id="email" for="exampleInputEmail1 ">Twitter URL</label>
							<input type="name" class="form-control input-field" aria-describedby="emailHelp" name="twitter" placeholder="enter twitter url">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8 col-lg-6 col-12">
							<label id="email" for="exampleInputEmail1 ">Linkedin URL</label>
							<input type="name" class="form-control input-field" aria-describedby="emailHelp" name="linkedln" placeholder="enter linkedin url">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-8 col-lg-6 col-12">
							<label for="profile">Default image for notes (if seller do not upload)</label>
							<div class="user-profile-photo-uploader">
								<label for="image-uploader"><img src="images/images/upload-file.png" alt="upload your profile picture"></label>
								<input type="file" id="image-uploader" class=" form-control"  name="default-notes" placeholder="Upload a Picture">
							</div>

						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-8 col-lg-6 col-sm-12">
							<label for="profile">Default profile picture (if seller do not upload)</label>
							<div class="user-profile-photo-uploader">
								<label for="image-uploader"><img src="images/images/upload-file.png" alt="upload your profile picture"></label>
								<input type="file" id="image-uploader" class=" form-control" name="default-profile" placeholder="Upload a Picture">
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
				<div class="col-md-6 col-sm-4 col-xs-4">
					vesion 1.1.24
				</div>
				<div class="col-md-6 col-sm-8 col-xs-8 text-right">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
			</div>
		</div>
	</div>

	<!--jquery-->
	<script src="js/jquery.js"></script>
	<!--bootstrap-->
	<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>