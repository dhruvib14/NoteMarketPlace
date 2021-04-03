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
	<!--responsive css-->
	<link rel="stylesheet" href="css/responsive.css">
</head>

<body>
	<!--header-->
	<header>
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light nav-user-profile ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper">
					<div class="navbar-header navbar-brand">
						<a href="home.php"><img src="images/images/logo.png"></a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav pull-right mr-auto ">
							<li class="nav-item"><a class="smooth-scroll nav-link" href="search-notes.php">Search Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="buyer-request.php">Buyer Request</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.php">Contact Us</a></li>
							<li class="nav-item dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="navbardrop" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="images/images/user-img.png"></a>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="user-profile.php">My Profile</a>
									<a class="dropdown-item" href="mydownloads.php">My Downloads</a>
									<a class="dropdown-item" href="sold-notes.php">My Sold Notes</a>
									<a class="dropdown-item" href="myrejectednotes.php">My Rejected Notes</a>
									<a class="dropdown-item" href="change-password.php">Change Password</a>
									<a class="dropdown-item dd-logout" href="logout.php"><p>Logout</p></a>
								</div>
							</li>
							<li class="nav-item"><a class="smooth-scroll nav-link" id="button-nav" href="logout.php">
									<p>Logout</p>
								</a></li>
						</ul>
					</div>
					<!--mobile menu-->
					<div id="mobile-nav">
						<div class="navbar-header">
							<a href="home.php"><img src="images/images/logo.png"></a>
							<!--mobile menu close button-->
							<span id="mobile-nav-close-btn">&times;</span>
						</div>

						<div id="mobile-nav-content">
							<ul class="navbar-nav nav">
								<li class="nav-item"><a class="smooth-scroll " href="search-notes.php">Search Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll" href="dashboard.php">Sell Your Notes</a></li>
								<li class="nav-item"><a class="smooth-scroll " href="buyer-request.php">Buyer Request</a></li>
								<li class="nav-item"><a class="smooth-scroll" href="faq-page.php">FAQ</a></li>
								<li class="nav-item"><a class="smooth-scroll  " href="contactus.php">Contact Us</a></li>
								<li class="dropdown"><a class="smooth-scroll nav-link pic-nav " href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/images/user-img.png"></a>
									<div class="dropdown-menu pull-right" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="user-profile.php">My Profile</a>
										<a class="dropdown-item" href="mydownloads.php">My Downloads</a>
										<a class="dropdown-item" href="sold-notes.php">My Sold Notes</a>
										<a class="dropdown-item" href="myrejectednotes.php">My Rejected Notes</a>
										<a class="dropdown-item" href="change-password.php">Change Password</a>
										<a class="dropdown-item dd-logout" href="logout.php"><p>Logout</p></a>
									</div>
								</li>
								<li class="nav-item"><a class="smooth-scroll " id="button-nav" href="logout.php">
										<p>Logout</p>
									</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</header>






	<!--header ends-->

	<!--header ends-->
	<section id="user-profile">

		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="logo">
					<div id="user-logo">

						<h3 id="user-profile-logo">User Profile</h3>
					</div>
				</div>
			</div>
			<div class="container">
				<h3> Basic Profile Details</h3>
				<form id="basic-profile-form">
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label id="fname" class="form-info" for="exampleInputName">First Name *</label>
							<input type="name" class="form-control input-field" placeholder="Your First Name" required>

						</div>
						<div class="form-group col-md-6 col-sm-12 col-xs-12">
							<label id="lname" for="exampleInputName ">Last Name *</label>
							<input type="name" class="form-control input-field" placeholder="Your Last Name" required>

						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label id="email" for="exampleInputEmail1 ">Email </label>
							<input type="email" class="form-control input-field" aria-describedby="emailHelp" placeholder="abc@gmail.com" required readonly>
						</div>
						<div class="col-md-6 col-sm-12">
							<label for="birthday">Date Of Birth </label>
							<input type="date" class="form-control input-field" id="birthdate" name="birthdate" placeholder="Enter Your Date Of Birth">
						</div>

					</div>
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label id="gender" for="gender">Gender </label>
							<select class="form-control options-arrow-down">
								<option selected>Male</option>
								<option>Female</option>
							</select>
						</div>
						<div class="col-md-6 col-sm-12">
							<label for="phone-number">Phone Number </label>
							<div class="row">
								<div class="col-md-4 col-sm-4 col-4">
									<select class="form-control options-arrow-down">
										<option selected>+91</option>
										<option>+81</option>
										<option>+63</option>
									</select>
								</div>
								<div class="col-md-8 col-sm-8 col-8">
									<input type="text" class="form-control input-field" id="phone-number" placeholder="Enter Your Phone Number">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label for="profile">Profile Picture </label>
							<div class="user-profile-photo-uploader">
								<label for="image-uploader"><img src="images/images/upload-file.png" alt="upload your profile picture"></label>
								<input type="file" id="image-uploader" class=" form-control" placeholder="Upload a Picture">
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>

		<!--address details-->

		<div class="row">
			<div class="container">
				<h3> Address Deatils </h3>
				<form id="address-detail-form">
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label class="add" for="exampleInputName">Address Line 1 *</label>
							<input type="address" class="form-control input-field" placeholder="Enter your Address" required>

						</div>
						<div class="col-md-6 col-sm-12"> <label class="add" for="exampleInputName">Address Line 2 </label>
							<input type="address" class="form-control input-field" placeholder="Enter your Address">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label class="add" for="city">City *</label>
							<input type="address" class="form-control input-field" placeholder="Enter your City" required>

						</div>
						<div class="col-md-6 col-sm-12">
							<label class="add" for="state">State *</label>
							<input type="address" class="form-control input-field" placeholder="Enter your state" required>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label class="add" for="zipcode">ZipCode *</label>
							<input type="address" class="form-control input-field" placeholder="Enter your ZipCode" required>

						</div>
						<div class="col-md-6 col-sm-12">
							<label class="add" for="country">Country *</label>
							<select class="form-control options-arrow-down">
								<option selected>India</option>
								<option>USA</option>
								<option>Canada</option>
							</select>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!--university and college information details-->

		<div class="row">
			<div class="container">
				<h3> University And College Information Deatils </h3>
				<form id="university-detail-form">
					<div class="form-group row">
						<div class="col-md-6 col-sm-12">
							<label class="college" for="exampleInputName">University </label>
							<input type="text" class="form-control input-field" placeholder="Enter your university">

						</div>
						<div class="col-md-6 col-sm-12 col-12"> <label class="college" for="exampleInputName">College </label>
							<input type="text" class="form-control input-field" placeholder="Enter your College">
						</div>
					</div>

				</form>
			</div>
		</div>
		<div class="row">
			<div class="container">
				<button type="submit" id="user-submit" class="btn btn-primary"><a href="search-notes.html">Submit</a></button>
			</div>
		</div>

	</section>
	<div class="footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-7">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
				<div class="col-md-6 col-sm-5 social-icons">
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