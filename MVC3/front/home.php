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

	<!-- HOME AECTION-->
	<section id="home">

		<!--backgroup img-->
		<img src="images/images/banner-home.jpg">


		<!--overlay-->
		<div id="home-overlay"></div>

		<!--for home content-->
		<div id="home-content" class="container">

			<div id="home-content-inner ">
				<div id="home-heading" class=" col-md-12 col-lg-8 col-sm-12 col-12">
					<h3 id="home-heading-1">Download Free/Paid Notes <br>or Sale your Book </h3>
				</div>


				<div id="home-text">
					<p class="text-left col-md-12 col-lg-6 col-12 col-sm-12">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam fuga, id ducimus itaque totam omnis. Numquam expedita totam labore reprehenderit, sint cupiditate eaque </p>
				</div>

				<div id="home-btn" class="col-md-12 col-lg-6 col-12 col-sm-12">
					<a class="btn btn-general btn-home smooth-scroll" href="#" title="learn more" role="button">learn More</a>
				</div>
			</div>

		</div>
	</section>

	<section id="about-notemarketplace">

		<div class="content-box-md">

			<div class="container">
				<div class="row no-gutters">
					<!--left side-->
					<div class="col-md-12 col-lg-4 col-12">
						<div id="about-left">
							<div class="horizontal-heading">
								<h3>About <br> NotesMarketPlace</h3>

							</div>


						</div>
					</div>

					<!--right side-->
					<div class="col-md-12 col-lg-8 col-12">
						<div id="about-right">
							<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae atque, officiis non, assumenda perferendis commodi, eligendi reiciendis, ea voluptatum error eum rerum porro ut aut optio facere ab quo voluptates.</p>
							<p id="p-2nd">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error distinctio, reiciendis veniam nisi rerum laborum commodi fuga eaque laudantium quos eum ipsum, atque labore voluptas autem odio cum blanditiis, possimus!</p>
						</div>
					</div>

				</div>
			</div>
		</div>

	</section>
	<section id="how-it-works">
		<div class="horizontal-heading container">
			<h3>How It Works</h3>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-2 col-lg-2"></div>
				<!--left-->
				<div class="col-md-4 col-lg-4 col-12" id="how-it-works-left">
					<div class="image">
						<img src="images/images/download.png">
					</div>
					<h4>Download Free/Paid Notes</h4>
					<h5> Get Material for your<br>Cource etc.</h5>
					<div id="download-btn">
						<a class="btn btn-general smooth-scroll" href="#" title="learn more" role="button">download</a>
					</div>

				</div>
				<div class="col-md-4 col-lg-4 col-12" id="how-it-works-right">
					<div class="image">
						<img src="images/images/seller.png">
					</div>
					<h4>Seller</h4>
					<h5>Upload and Download Course<br>and materials etc.</h5>
					<div id="download-btn">
						<a class="btn btn-general smooth-scroll" href="#" title="learn more" role="button" id="sell-book">sell book</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--customer saying-->
	<section id="customer-saying">
		<div class="container">
			<div class="horizontal-heading container">
				<h3>What our Customers are Saying</h3>
			</div>

			<div class="row no-gutters">
				<!--first customer-->
				<div class="col-md-12 col-lg-6 col-12 customer" id="cust-1">
					<div class="customer-box">

						<div class="row">
							<div class="col-md-3 col-lg-3 col-sm-4  col-4 customer-img">
								<img src="images/images/customer-1.png">
							</div>
							<div class="col-md-9 col-lg-9 col-sm-8 col-8">
								<div class="author-name-des">
									<h5>Walter Maller</h5>
									<h6>Founder & CEO, Matrix Group</h6>
								</div>
							</div>
						</div>
						<p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore quas aliquid necessitatibus aspernatur, qui, velit cumque sequi sint animi earum sit nam veniam."</p>
					</div>
				</div>

				<!--second customer-->
				<div class="col-md-12  col-lg-6 col-12 customer" id="cust-2">
					<div class="customer-box">
						<div class="row no-gutters">
							<div class="col-md-3 col-lg-3 col-sm-4 col-4 customer-img">
								<img src="images/images/customer-2.png">
							</div>
							<div class="col-md-9 col-lg-9 col-sm-8  col-8">
								<div class="author-name-des">
									<h5>Jonnie Riley</h5>
									<h6>Employee, Curios Snacks</h6>
								</div>
							</div>
						</div>


						<p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore quas aliquid necessitatibus aspernatur, qui, velit cumque sequi sint animi earum sit nam veniam."</p>
					</div>
				</div>
			</div>

			<!--third customer-->
			<div class="row no-gutters">
				<div class="col-md-12 col-lg-6 col-12  customer" id="cust-3">
					<div class="customer-box">
						<div class="row no-gutters">
							<div class="col-md-3 col-lg-3 col-sm-4 col-4 customer-img">
								<img src="images/images/customer-3.png">
							</div>
							<div class="col-md-9 col-lg-9 col-sm-8  col-8">
								<div class="author-name-des">
									<h5>Amilia Luna</h5>
									<h6>Teacher, saint Joseph High School</h6>
								</div>
							</div>
						</div>



						<p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore quas aliquid necessitatibus aspernatur, qui, velit cumque sequi sint animi earum sit nam veniam."</p>
					</div>
				</div>

				<!--fourth customer-->
				<div class="col-md-12 col-lg-6 col-12 customer" id="cust-4">
					<div class="customer-box">
						<div class="row no-gutters">
							<div class="col-md-3 col-lg-3 col-sm-4 col-4 customer-img">
								<img src="images/images/customer-4.png">
							</div>
							<div class="col-md-9 col-lg-9 col-sm-8  col-8">
								<div class="author-name-des">
									<h5>Daniel Cardos</h5>
									<h6>Software Engineer, Inflnitum Company</h6>
								</div>
							</div>
						</div>



						<p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore quas aliquid necessitatibus aspernatur, qui, velit cumque sequi sint animi earum sit nam veniam."</p>
					</div>
				</div>
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