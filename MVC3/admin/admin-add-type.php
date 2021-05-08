<?php
include "../front/db.php";
session_start();
if(isset($_SESSION['useremail'])){
$email=$_SESSION['useremail'];
$query=mysqli_query($connection,"SELECT ID FROM users WHERE EmailID='$email'");
while($row=mysqli_fetch_array($query)){
	$admin_id=$row['ID'];
}
$query=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID=$admin_id");
	
	while($row=mysqli_fetch_array($query)){
		$profile_pic=$row['Profile_Pic'];
	}
}


else {
	header("Location:../front/login1.php");	
}

if(isset($_GET['type_id'])){
	$type_id=$_GET['type_id'];
	$query=mysqli_query($connection,"SELECT * FROM type WHERE ID=$type_id");
	if(!$query){
		echo mysqli_error($connection);
	}
	while($row=mysqli_fetch_array($query)){
		$type_name=$row['Type_Name'];
		$description=$row['Description'];
	}
}

if(isset($_POST['submit'])){
	$type_name=$_POST['type_name'];
	$description=$_POST['description'];

	
	
if(isset($_GET['type_id'])){
	$query=mysqli_query($connection,"UPDATE type SET Type_Name='$type_name',Description='$description',ModifiedDate=Now(),ModifiedBy=$admin_id,IsActive=1 WHERE ID=$type_id ");
if(!$query){
	echo mysqli_error($connection);
}}
else{
$query_insert=mysqli_query($connection,"INSERT INTO type(Type_Name,Description,CreatedBy,CreatedDate,IsActive) VALUES ('$type_name','$description',$admin_id,NOW(),1)");
	if(!$query_insert){
		echo mysqli_error($connection);
	}
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
									<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
									<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
									<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

									<a class="dropdown-item active" href="admin-manage-type.php">Manage Type</a>
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
										<a class="dropdown-item " href="admin-manage-system.php">Manage System Configuration</a>
										<a class="dropdown-item " href="admin-manage-administration.php">Manage Administration</a>
										<a class="dropdown-item " href="admin-manage-category.php">Manage Category</a>

										<a class="dropdown-item active" href="admin-manage-type.php">Manage Type</a>
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
				<h3>Add Type</h3>
				<form id="basic-profile-form" method="post" action="admin-add-type.php">
					<div class="form-group row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<label id="fname" class="form-info" for="exampleInputName">Type Name *</label>
							<input type="name" class="form-control input-field" name="type_name" placeholder="Your category name" required value="<?php if(isset($_GET['type_id'])) echo $type_name;?>">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<label id="fname" class="form-info" for="exampleInputName">Description *</label>
							<textarea class="form-control" id="exampleFormControlTextarea1" name="description" placeholder="enter your description" rows="6" required><?php if(isset($_GET['type_id'])) echo $description; ?></textarea>
						</div>
					</div>
				
				<div class="row">
					<div class="container">
						<button type="submit" name="submit" id="user-submit" class="btn btn-primary">Submit</button>
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
	<script src="js/bootstrap/bootstrap.min.4.5.js"></script>

	<!--js-->
	<script src="js/script.js"></script>
</body>

</html>