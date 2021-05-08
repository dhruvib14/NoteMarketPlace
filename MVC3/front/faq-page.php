<?php 
include "db.php";
session_start();?>

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
							<li class="nav-item"><a class="smooth-scroll nav-link " href="search-notes.php">Search Notes</a>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="dashboard.php">Sell Your Notes</a></li>
							<?php if(isset($_SESSION['useremail'])){
								echo "<li class='nav-item'><a class='smooth-scroll nav-link' href='buyer-request.php'>Buyer Request</a></li>";
							}
							?>
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="faq-page.php">FAQ</a></li>
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
									<a class='dropdown-item dd-logout' onclick='javascript:logout($(this));return false;' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' onclick='javascript:logout($(this));return false;' id='button-nav' href='logout.php'>
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
							<li class="nav-item"><a class="smooth-scroll nav-link " href="search-notes.php">Search Notes</a>
							<li class="nav-item"><a class="smooth-scroll nav-link " href="dashboard.php">Sell Your Notes</a></li>
							<?php if(isset($_SESSION['useremail'])){
								echo "<li class='nav-item'><a class='smooth-scroll nav-link' href='buyer-request.php'>Buyer Request</a></li>";
							}
							?>
							<li class="nav-item"><a class="smooth-scroll nav-link active" href="faq-page.php">FAQ</a></li>
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
									<a class='dropdown-item dd-logout' onclick='javascript:logout($(this));return false;' href='logout.php'><p>Logout</p></a>
								</div>
							</li>";}
?>
<?php if(isset($_SESSION['useremail'])){echo "
							<li class='nav-item'><a class='smooth-scroll nav-link' onclick='javascript:logout($(this));return false;' id='button-nav' href='logout.php'>
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


<div class="row">
<div class="col-12">	<div class="logo ">
		
			<img src="images/images/banner-home.jpg">
			<h3 id="user-profile-logo" class="text-center">Frequently Asked Questions</h3>
		</div></div>
	</div>

	<section id="faq-page">
		<div class="container">
			<h3 class="faq-heading">General Questions</h3>
			<div class="faq"> <button type="button" class="collapsible" onclick="faqcollpase()">What is Notes Marketplace? </button>
				<div class="content">
					<p> Notes Marketplace is an online marketplace for university students to buy and sell their course notes. 
 </p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">Where did Notes Marketplace start?</button>
				<div class="content">
					<p> What started out as four friends chucking around an idea in Ahmedabad ended up turning into an earliest version of Notes Marketplace. So, with 2021 batch of tatvasoft – we has developed this product.</p>
				</div>
			</div>
			


			<h3 class="faq-heading">Uploaders</h3>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">Why should I upload now? </button>
				<div class="content">
					<p>To maximize sales. We can't sell your notes if they are rotting on your hard drive. Your notes are available for purchase the instant they are approved, which means that you could be missing potential sales as we speak. Despite exam and holiday breaks, our users purchase notes all year round, so the best time to upload notes is always today. </p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">What can't I sell?</button>
				<div class="content">
					<p>We won't approve materials that have been created by your university or another third party. We also do not accept assignments, essays, practical’s or take-home exams. We love notes though.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">How long does it take to upload? </button>
				<div class="content">
					<p>Uploading notes is quick and easy. It can take as little as 90 seconds per set of notes. Put it this way, in the time it took to read these FAQs, you could’ve uploaded several sets of notes</p>
				</div>
			</div>


			<h3 class="faq-heading">Downloaders</h3>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">How do I buy notes? </button>
				<div class="content">
					<p>Search for the notes you are after using the 'SEARCH NOTES' tab at the at the top right of every page. You can then filter results by university, category, course information etc. To purchase, go to detail page of note and click on download button. If notes are free to download – it will download over the browser and if notes are paid, Once Seller will allow download you can have notes at my downloads grid for actual download.</p>
				</div>
			</div>
			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">Why should I buy notes? </button>
				<div class="content">
					<p> The notes on our site are incredibly useful as an educational tool when used correctly. They effectively demonstrate the techniques that top students employ in order to receive top marks. They also summaries the course in a concise format and show what that student believed were the most important elements of the course. Learn from the best. 
 </p>
				</div>
			</div>

			<div class="faq">
				<button type="button" class="collapsible" onclick="faqcollpase()">Will downloading notes guarantee I improve my grades? </button>
				<div class="content">
					<p>How long is a piece of string? However, 90% of students who purchased notes through our site said that doing so improved their grades.
 </p>
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
