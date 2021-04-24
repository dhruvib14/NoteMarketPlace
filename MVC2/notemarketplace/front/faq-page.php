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
		<nav id="navuser" class="navbar nav-notes navbar-fixed-top navbar-expand-lg navbar-light  ">
			<div class="container-fluid ">
				<div class="site-nav-wrapper">
					<div class="navbar-header navbar-brand">
						<a href="home.php"><img src="images/images/logo.png"> </a><span id="mobile-nav-open-btn">
							&#9776;</span>
					</div>
					<!--main menu-->
					<div class="collapse navbar-collapse">

						<ul class="navbar-nav ">
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="search-notes.php">Search Notes</a>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<?php if(isset($_SESSION['useremail'])){
								echo "<li class='nav-item'><a class='smooth-scroll nav-link' href='buyer-request.php'>Buyer Request</a></li>";
							}
							?>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.php">Contact Us</a></li>
						
							<?php if(isset($_SESSION['useremail'])){
								$useremail=$_SESSION['useremail'];
								
                                $query_id=mysqli_query($connection,"SELECT ID FROM users WHERE EmailID='$useremail'");
								while($row=mysqli_fetch_assoc($query_id)){
									$userid=$row['ID'];
								}
								$query_profile=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID='$userid'");
								if(!$query_profile){
									echo mysqli_error($connection);
								}
								$count=mysqli_num_rows($query_profile);
							
								while($row=mysqli_fetch_assoc($query_profile)){
									$profile_pic=$row['Profile_Pic'];
								}
							
						echo "	<li class='nav-item dropdown'><a class='smooth-scroll nav-link pic-nav ' href='#' id='navbardrop' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><img src='$profile_pic' alt='profile'></a>
								<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
									<a class='dropdown-item' href='user-profile.php'>My Profile</a>
									<a class='dropdown-item' href='mydownloads.php'>My Downloads</a>
									<a class='dropdown-item' href='sold-notes.php'>My Sold Notes</a>
									<a class='dropdown-item' href='myrejectednotes.php'>My Rejected Notes</a>
									<a class='dropdown-item' href='change-password.php'>Change Password</a>
									<a class='dropdown-item dd-logout' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='logout.php'>
									<p>Logout</p>
								</a></li>";}
								else
								{echo "
									<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='login1.php'>
											<p>Login</p>
										</a></li>";}?>
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
							<ul class="navbar-nav">
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="search-notes.php">Search Notes</a>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="dashboard.php">Sell Your Notes</a></li>
							<?php if(isset($_SESSION['useremail'])){
								echo "<li class='nav-item'><a class='smooth-scroll nav-link' href='buyer-request.php'>Buyer Request</a></li>";
							}
							?>
							<li class="nav-item"><a class="smooth-scroll nav-link" href="faq-page.php">FAQ</a></li>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="contactus.php">Contact Us</a></li>
						
							<?php if(isset($_SESSION['useremail'])){
								$useremail=$_SESSION['useremail'];
								
                                $query_id=mysqli_query($connection,"SELECT ID FROM users WHERE EmailID='$useremail'");
								while($row=mysqli_fetch_assoc($query_id)){
									$userid=$row['ID'];
								}
								$query_profile=mysqli_query($connection,"SELECT Profile_Pic FROM users_details WHERE UserID='$userid'");
								if(!$query_profile){
									echo mysqli_error($connection);
								}
								$count=mysqli_num_rows($query_profile);
							
								while($row=mysqli_fetch_assoc($query_profile)){
									$profile_pic=$row['Profile_Pic'];
								}
						echo "	<li class='nav-item dropdown'><a class='smooth-scroll nav-link pic-nav ' href='#' id='navbardrop' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><img src='$profile_pic'></a>
								<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
									<a class='dropdown-item' href='user-profile.php'>My Profile</a>
									<a class='dropdown-item' href='mydownloads.php'>My Downloads</a>
									<a class='dropdown-item' href='sold-notes.php'>My Sold Notes</a>
									<a class='dropdown-item' href='myrejectednotes.php'>My Rejected Notes</a>
									<a class='dropdown-item' href='change-password.php'>Change Password</a>
									<a class='dropdown-item dd-logout' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='logout.php'>
									<p>Logout</p>
								</a></li>";}
								else
								{echo "
									<li class='nav-item'><a class='smooth-scroll nav-link' id='button-nav' href='login1.php'>
											<p>Login</p>
										</a></li>";}?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</nav>

	</header>
	<!--header ends-->


	<div class="logo ">
		
			<img src="images/images/banner-home.jpg">
			<h3 id="user-profile-logo" class="text-center">Frequently Asked Questions</h3>
		
	</div>

	<section id="faq-page">
		<div class="container">
			<h3 class="faq-heading">General Questions</h3>
			<div class="faq"> <button type="button" class="collapsible" onclick="faqcollpase()">What is Note-Marketplaces?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">What Do the unvidersity Say?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">is this jegal?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>


			<h3 class="faq-heading">Uploaders</h3>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">What Can't I sell?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">What notes can I sell?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>


			<h3 class="faq-heading">Downloaders</h3>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">How do I buy notes?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">Can i edit the notes I purchased?</button>
				<div class="content">
					<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta, veritatis fugiat, nemo et corporis accusantium dolor deleniti hic vel consequuntur dolorem nulla harum sequi magnam non! Porro aliquam accusamus iure.</p>
				</div>
			</div>

		</div>


	</section>
	<div class="footer">
		<hr>
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<p>Copyright <span>&#169;</span> Tatvasoft All rights reserved.</p>
				</div>
				<div class="col-md-6 social-icons">
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